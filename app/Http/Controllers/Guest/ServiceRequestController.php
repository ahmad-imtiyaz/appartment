<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceDetail;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $requests = auth()->user()->serviceRequests()
            ->with(['service', 'worker', 'feedback'])
            ->latest()
            ->get();

        return view('guest.service-requests.index', compact('requests'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'scheduled_at' => ['nullable', 'date', 'after:now'],

            // hanya wajib kalau service-nya Maintenance & Repair, dicek manual di bawah
            'damage_category' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:100'],
            'urgency' => ['nullable', 'in:low,medium,high'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'max:2048'],
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $isMaintenance = $service->slug === 'maintenance-repair';

        if ($isMaintenance) {
            $request->validate([
                'damage_category' => ['required', 'string', 'max:100'],
            ]);
        }

        $serviceRequest = DB::transaction(function () use ($request, $validated, $service, $isMaintenance) {
            $serviceRequest = ServiceRequest::create([
                'user_id' => auth()->id(),
                'service_id' => $service->id,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
                'scheduled_at' => $validated['scheduled_at'] ?? null,
            ]);

            if ($isMaintenance) {
                MaintenanceDetail::create([
                    'service_request_id' => $serviceRequest->id,
                    'damage_category' => $validated['damage_category'],
                    'location' => $validated['location'] ?? null,
                    'description' => $validated['notes'] ?? null,
                    'urgency' => $validated['urgency'] ?? 'medium',
                ]);
            }

            foreach ($request->file('photos', []) as $photo) {
                ServiceRequestPhoto::create([
                    'service_request_id' => $serviceRequest->id,
                    'type' => 'before',
                    'photo_path' => $photo->store('service-request-photos', 'public'),
                ]);
            }

            return $serviceRequest;
        });

        return redirect()
            ->route('guest.service-requests.index')
            ->with('success', 'Permintaan jasa "' . $service->name . '" berhasil diajukan, menunggu diproses admin.');
    }
}
