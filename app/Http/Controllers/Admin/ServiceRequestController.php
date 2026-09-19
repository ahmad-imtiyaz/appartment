<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepairPricing;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Notifications\PriceSetNotification;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

        return back()->with('success', "Tugas berhasil di-assign ke {$worker->name}.");
    }

    public function setPrice(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->isMaintenance(), 404);
        abort_if(
            $serviceRequest->status !== 'in_progress' || !$serviceRequest->survey_reported_at,
            422,
            'Survey dari pekerja belum masuk, harga belum bisa di-set.'
        );

        $detail = $serviceRequest->maintenanceDetail;
        abort_if(!$detail, 422, 'Data survey tidak ditemukan.');

        // Harga acuan dari price list (null kalau kategori "Lainnya" atau kombinasi belum di-patok)
        $suggestedPrice = RepairPricing::query()
            ->where('category', $detail->damage_category)
            ->where('severity', $detail->severity)
            ->where('is_active', true)
            ->value('price');

        $validated = $request->validate([
            'price' => ['required', 'numeric', 'min:0'],
            'price_change_note' => [
                Rule::requiredIf(fn() => $suggestedPrice !== null
                    && round((float) $request->input('price'), 2) !== round((float) $suggestedPrice, 2)),
                'nullable',
                'string',
                'max:255',
            ],
        ], [
            'price_change_note.required' => 'Wajib isi alasan kalau harga diubah dari harga acuan.',
        ]);

        $serviceRequest->update([
            'snapshot_repair_price' => $suggestedPrice,
            'total_price' => $validated['price'],
            'price_change_note' => $validated['price_change_note'] ?? null,
            'status' => 'waiting_approval',
        ]);

        $serviceRequest->user->notify(new PriceSetNotification($serviceRequest));

        return back()->with('success', 'Harga berhasil dikirim, menunggu persetujuan guest.');
    }
}
