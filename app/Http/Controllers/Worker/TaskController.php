<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\BalanceMutation;
use App\Models\ServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->assignedTasks()
            ->with(['service', 'user', 'maintenanceDetail'])
            ->latest()
            ->get();

        return view('worker.tasks.index', compact('tasks'));
    }

    public function show(ServiceRequest $serviceRequest): View
    {
        abort_unless($serviceRequest->worker_id === auth()->id(), 403);

        $serviceRequest->load(['service', 'user', 'maintenanceDetail', 'photos']);

        return view('worker.tasks.show', compact('serviceRequest'));
    }

    public function accept(ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->worker_id === auth()->id(), 403);
        abort_if(!$serviceRequest->isWaitingAcceptance(), 422, 'Tugas ini tidak dalam status menunggu ACC.');

        $data = [
            'accepted_at' => now(),
            'status' => 'in_progress',
        ];

        if ($serviceRequest->isLaundry()) {
            $data['collected_at'] = now();
        }

        $serviceRequest->update($data);

        return back()->with('success', 'Tugas diterima, status diubah jadi sedang dikerjakan.');
    }

    public function weigh(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->worker_id === auth()->id(), 403);
        abort_unless($serviceRequest->status === 'in_progress', 422, 'Tugas belum dalam progress.');
        abort_if($serviceRequest->isLaundry() === false, 422, 'Tugas ini bukan laundry.');

        $validated = $request->validate([
            'billable_weight' => ['required', 'numeric', 'min:0.01'],
        ]);

        $billableWeight = max($validated['billable_weight'], 1);
        $snapshotPrice = $serviceRequest->snapshot_price_per_kg ?? 0;
        $totalPrice = round($billableWeight * $snapshotPrice, 2);

        $serviceRequest->update([
            'billable_weight' => $billableWeight,
            'total_price' => $totalPrice,
            'weighed_at' => now(),
        ]);

        return back()->with('success', 'Berat berhasil dicatat. Total harga: Rp' . number_format($totalPrice, 0, ',', '.'));
    }

    public function complete(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->worker_id === auth()->id(), 403);
        abort_if(!$serviceRequest->isInProgress(), 422, 'Tugas ini belum berstatus sedang dikerjakan.');

        $validated = $request->validate([
            'worker_notes' => ['nullable', 'string', 'max:1000'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $validated, $serviceRequest) {
            $serviceRequest->loadMissing('service', 'user');

            // For laundry: total_price already calculated during weigh step
            $cost = $serviceRequest->total_price ?? $serviceRequest->service->base_price ?? 0;

            $guest = $serviceRequest->user()->lockForUpdate()->first();

            abort_if($guest->balance < $cost, 422, 'Saldo guest tidak cukup untuk menyelesaikan tugas ini.');

            $balanceBefore = $guest->balance;
            $balanceAfter = $balanceBefore - $cost;
            $guest->update(['balance' => $balanceAfter]);

            BalanceMutation::create([
                'user_id' => $guest->id,
                'type' => 'debit',
                'amount' => $cost,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'reference_type' => 'ServiceRequest',
                'reference_id' => $serviceRequest->id,
                'description' => 'Pembayaran jasa ' . $serviceRequest->service->name,
            ]);

            foreach ($request->file('photos', []) as $photo) {
                $serviceRequest->photos()->create([
                    'type' => 'after',
                    'photo_path' => $photo->store('service-request-photos', 'public'),
                ]);
            }

            $serviceRequest->update([
                'cost' => $cost,
                'worker_notes' => $validated['worker_notes'] ?? null,
                'completed_at' => now(),
                'status' => 'completed',
            ]);
        });

        return back()->with('success', 'Tugas ditandai selesai.');
    }
}
