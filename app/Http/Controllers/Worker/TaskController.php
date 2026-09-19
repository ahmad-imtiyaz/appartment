<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\BalanceMutation;
use App\Models\MaintenanceDetail;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Notifications\SurveyReportedNotification;
use App\Services\CoinRewardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

    public function survey(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->worker_id === auth()->id(), 403);
        abort_unless($serviceRequest->isMaintenance(), 404);
        abort_if($serviceRequest->status !== 'in_progress', 422, 'Tugas belum dalam progress.');
        abort_if($serviceRequest->survey_reported_at !== null, 422, 'Survey untuk tugas ini sudah dikirim.');

        $validated = $request->validate([
            'damage_category' => ['required', Rule::in([...array_keys(\App\Models\RepairPricing::CATEGORIES), 'lainnya'])],
            'severity' => ['required', Rule::in(array_keys(\App\Models\RepairPricing::SEVERITIES))],
            'location' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'survey_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($serviceRequest, $validated) {
            $serviceRequest->maintenanceDetail()->updateOrCreate(
                ['service_request_id' => $serviceRequest->id],
                [
                    'damage_category' => $validated['damage_category'],
                    'severity' => $validated['severity'],
                    'location' => $validated['location'] ?? null,
                    'description' => $validated['description'] ?? null,
                ]
            );

            $serviceRequest->update([
                'survey_notes' => $validated['survey_notes'] ?? null,
                'survey_reported_at' => now(),
            ]);
        });

        // Notif ke admin yang assign tugas ini (fallback: admin pertama, kalau assigned_by kosong)
        $admin = $serviceRequest->assignedBy ?? User::where('role', 'admin')->first();
        $admin?->notify(new SurveyReportedNotification($serviceRequest));

        return back()->with('success', 'Hasil survey berhasil dikirim, menunggu admin menetapkan harga.');
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

            $cost = match ($serviceRequest->service->slug) {
                'laundry' => $serviceRequest->total_price ?? 0, // dihitung dari berat, di-set saat worker input berat
                'cleaning' => $serviceRequest->snapshot_cleaning_price ?? 0,
                'ac' => $serviceRequest->snapshot_ac_price ?? 0,
                'maintenance-repair' => 0, // sudah dipotong & tercatat saat approvePrice
                default => $serviceRequest->service->base_price ?? 0,
            };

            $isMaintenance = $serviceRequest->service->slug === 'maintenance-repair';
            $guest = $serviceRequest->user()->lockForUpdate()->first();

            if (!$isMaintenance) {
                abort_if($guest->balance < $cost, 422, 'Saldo guest tidak cukup untuk menyelesaikan tugas ini.');
            }

            $balanceBefore = $guest->balance;
            $balanceAfter = $balanceBefore - $cost;

            if (!$isMaintenance) {
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
            }

            // Reward koin berdasarkan tier CoinSetting yang aktif
             $rewardBase = $isMaintenance ? ($serviceRequest->total_price ?? 0) : $cost;
            (new CoinRewardService())->awardForServiceRequest($serviceRequest, $guest, $rewardBase);



            foreach ($request->file('photos', []) as $photo) {
                $serviceRequest->photos()->create([
                    'type' => 'after',
                    'photo_path' => $photo->store('service-request-photos', 'public'),
                ]);
            }

            $serviceRequest->update([
                'cost' => $isMaintenance ? ($serviceRequest->total_price ?? 0) : $cost,
                'worker_notes' => $validated['worker_notes'] ?? null,
                'completed_at' => now(),
                'status' => 'completed',
            ]);
        });

        return back()->with('success', 'Tugas ditandai selesai.');
    }
}
