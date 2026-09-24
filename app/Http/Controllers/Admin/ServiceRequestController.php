<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Notifications\PriceSetNotification;
use App\Notifications\TaskAssignedNotification;
use App\Services\FcmService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use function Illuminate\Support\defer;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        $serviceRequests = ServiceRequest::with(['service', 'user', 'worker'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return view('admin.service-requests.index', compact('serviceRequests'));
    }

    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['service', 'user', 'worker', 'maintenanceDetail', 'photos', 'feedback']);
        $workers = User::where('role', 'pekerja')->get();

        return view('admin.service-requests.show', compact('serviceRequest', 'workers'));
    }

    public function assign(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_if($serviceRequest->status !== 'pending', 422, 'Request ini sudah pernah di-assign.');

        $validated = $request->validate([
            'worker_id' => ['required', 'exists:users,id'],
        ]);

        $worker = User::where('id', $validated['worker_id'])
            ->where('role', 'pekerja')
            ->firstOrFail();

        $serviceRequest->update([
            'worker_id' => $worker->id,
            'assigned_by' => auth()->id(),
            'assigned_at' => now(),
            'status' => 'assigned',
        ]);

        $worker->notify(new TaskAssignedNotification($serviceRequest));
        $serviceRequest->update(['notified_at' => now()]);

        $serviceRequest->loadMissing('service');
        defer(fn () => app(FcmService::class)->sendToUser(
            $worker,
            'Tugas Baru: ' . $serviceRequest->service->name,
            'Kamu mendapat tugas baru. Ketuk untuk melihat detailnya.',
            ['path' => route('worker.tasks.show', $serviceRequest, false)],
        ));

        return back()->with('success', "Tugas berhasil di-assign ke {$worker->name}.");
    }

    public function setPrice(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        // Menggunakan helper requiresSurveyPricing() agar berlaku fleksibel
        abort_unless($serviceRequest->requiresSurveyPricing(), 404);

        abort_if(
            $serviceRequest->status !== 'in_progress' || !$serviceRequest->survey_reported_at,
            422,
            'Survey dari pekerja belum masuk, harga belum bisa di-set.'
        );

        $validated = $request->validate([
            'price' => ['required', 'numeric', 'min:0'],
            'price_change_note' => ['nullable', 'string', 'max:255'],
        ]);

        $serviceRequest->update([
            'total_price' => $validated['price'],
            'price_change_note' => $validated['price_change_note'] ?? null,
            'status' => 'waiting_approval',
        ]);

        $serviceRequest->user->notify(new PriceSetNotification($serviceRequest));

        return back()->with('success', 'Harga berhasil dikirim, menunggu persetujuan guest.');
    }
}
