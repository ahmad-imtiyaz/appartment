<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        $serviceRequests = ServiceRequest::with(['service', 'user', 'worker'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return view('admin.service-requests.index', compact('serviceRequests'));
    }

    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['service', 'user', 'worker', 'maintenanceDetail', 'photos', 'feedback']);

        return view('admin.service-requests.show', compact('serviceRequest'));
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
}
