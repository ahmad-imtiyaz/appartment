<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\BalanceMutation;
use App\Models\ServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function accept(ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->worker_id === auth()->id(), 403);
        abort_if(!$serviceRequest->isWaitingAcceptance(), 422, 'Tugas ini tidak dalam status menunggu ACC.');

        $serviceRequest->update([
            'accepted_at' => now(),
            'status' => 'in_progress',
        ]);

        return back()->with('success', 'Tugas diterima, status diubah jadi sedang dikerjakan.');
    }

    public function complete(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->worker_id === auth()->id(), 403);
        abort_if(!$serviceRequest->isInProgress(), 422, 'Tugas ini belum berstatus sedang dikerjakan.');

        $validated = $request->validate([
            'worker_notes' => ['nullable', 'string', 'max:1000'],
            // wajib diisi manual khusus untuk Maintenance & Repair (harga custom per kasus)
            'cost' => ['nullable', 'numeric', 'min:0'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $validated, $serviceRequest) {
            $serviceRequest->loadMissing('service', 'user');

            // biaya final: dari input pekerja (mis. maintenance), fallback ke base_price service
            $cost = $validated['cost'] ?? $serviceRequest->service->base_price ?? 0;

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
