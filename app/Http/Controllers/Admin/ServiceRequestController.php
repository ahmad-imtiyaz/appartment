<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Notifications\PriceSetNotification;
use App\Notifications\TaskAssignedNotification;
use App\Services\FcmService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Illuminate\Support\defer;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        // Nama jasa unik untuk tab (nama yang sama digabung jadi satu)
        $serviceNames = Service::orderBy('name')->pluck('name')->unique()->values();

        // Hanya terima nama jasa yang benar-benar ada
        $serviceName = $serviceNames->contains($request->service) ? $request->service : null;

        $serviceRequests = ServiceRequest::with(['service', 'user', 'worker'])
            ->withCount('candidates')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($serviceName, fn ($q) => $q->whereHas('service', fn ($s) => $s->where('name', $serviceName)))
            ->latest()
            ->paginate(20)
            ->withQueryString(); // filter tidak hilang saat pindah halaman

        return view('admin.service-requests.index', compact('serviceRequests', 'serviceNames', 'serviceName'));
    }

    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['service', 'user', 'worker', 'candidates', 'maintenanceDetail', 'photos', 'feedback']);

        // Hanya pekerja yang menangani jasa ini (atau pekerja tanpa spesialisasi)
        $workers = $this->eligibleWorkers($serviceRequest);

        return view('admin.service-requests.show', compact('serviceRequest', 'workers'));
    }

    /**
     * Assign ke satu atau beberapa pekerja sekaligus.
     * Kalau lebih dari satu, pekerja pertama yang ACC yang mendapat tugas.
     */
    public function assign(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_if($serviceRequest->status !== 'pending', 422, 'Request ini sudah pernah di-assign.');

        $validated = $request->validate([
            'worker_ids' => ['required', 'array', 'min:1'],
            'worker_ids.*' => ['integer', 'distinct', 'exists:users,id'],
        ], [
            'worker_ids.required' => 'Pilih minimal satu pekerja.',
            'worker_ids.min' => 'Pilih minimal satu pekerja.',
        ]);

        $serviceRequest->loadMissing('service');

        // Cek ulang di server: semua pekerja harus role pekerja & cocok dengan jasa request ini
        $workers = $this->eligibleWorkers($serviceRequest)
            ->whereIn('id', $validated['worker_ids'])
            ->values();

        abort_if(
            $workers->count() !== count($validated['worker_ids']),
            422,
            'Ada pekerja yang tidak valid atau tidak menangani jasa ' . $serviceRequest->service->name . '.'
        );

        DB::transaction(function () use ($serviceRequest, $workers) {
            $serviceRequest->candidates()->sync($workers->pluck('id')->all());

            $serviceRequest->update([
                // 1 pekerja = langsung ditugaskan; >1 = rebutan, worker_id diisi saat ACC
                'worker_id' => $workers->count() === 1 ? $workers->first()->id : null,
                'assigned_by' => auth()->id(),
                'assigned_at' => now(),
                'notified_at' => now(),
                'status' => 'assigned',
            ]);
        });

        $serviceName = $serviceRequest->service->name;
        $path = route('worker.tasks.show', $serviceRequest, false);

        foreach ($workers as $worker) {
            $worker->notify(new TaskAssignedNotification($serviceRequest));

            defer(fn () => app(FcmService::class)->sendToUser(
                $worker,
                'Tugas Baru: ' . $serviceName,
                $workers->count() > 1
                    ? 'Ada tugas baru. Siapa cepat ACC, dia yang dapat!'
                    : 'Kamu mendapat tugas baru. Ketuk untuk melihat detailnya.',
                ['path' => $path],
            ));
        }

        $message = $workers->count() === 1
            ? "Tugas berhasil di-assign ke {$workers->first()->name}."
            : "Tugas ditawarkan ke {$workers->count()} pekerja. Yang pertama ACC akan mendapat tugas ini.";

        return back()->with('success', $message);
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

    /**
     * Pekerja yang boleh mengerjakan jasa pada request ini:
     * tanpa spesialisasi (semua jasa) atau spesialisasinya sama dengan nama jasa.
     */
    private function eligibleWorkers(ServiceRequest $serviceRequest)
    {
        $serviceName = $serviceRequest->service->name;

        return User::where('role', 'pekerja')
            ->where(function ($q) use ($serviceName) {
                $q->whereNull('specialization')
                  ->orWhere('specialization', $serviceName);
            })
            ->orderBy('name')
            ->get();
    }
}
