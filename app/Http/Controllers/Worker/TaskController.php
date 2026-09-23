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
        abort_unless($serviceRequest->requiresSurveyPricing(), 404);
        abort_if($serviceRequest->status !== 'in_progress', 422, 'Tugas belum dalam progress.');
        abort_if($serviceRequest->survey_reported_at !== null, 422, 'Survey untuk tugas ini sudah dikirim.');

        if ($serviceRequest->isMaintenance()) {
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
        } else {
            $validated = $request->validate([
                'survey_notes' => ['required', 'string', 'max:1000'],
            ]);

            $serviceRequest->update([
                'survey_notes' => $validated['survey_notes'],
                'survey_reported_at' => now(),
            ]);
        }

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

    public function readyForPayment(ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->worker_id === auth()->id(), 403);
        abort_unless($serviceRequest->isLaundry(), 404);
        abort_if($serviceRequest->status !== 'in_progress', 422, 'Tugas belum dalam progress.');
        abort_if($serviceRequest->weighed_at === null, 422, 'Berat belum diinput, tidak bisa lanjut ke pembayaran.');

        $serviceRequest->update(['status' => 'waiting_payment']);

        return back()->with('success', 'Laundry selesai dicuci. Menunggu guest melakukan pembayaran.');
    }

    public function confirmDelivered(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->worker_id === auth()->id(), 403);
        abort_unless($serviceRequest->isLaundry(), 404);
        abort_if($serviceRequest->status !== 'waiting_payment', 422, 'Laundry belum dalam status menunggu pembayaran.');
        abort_if($serviceRequest->laundry_paid_at === null, 422, 'Guest belum membayar, belum bisa diantar.');

        $validated = $request->validate([
            'worker_notes' => ['nullable', 'string', 'max:1000'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'max:2048'],
        ]);

        foreach ($request->file('photos', []) as $photo) {
            $serviceRequest->photos()->create([
                'type' => 'after',
                'photo_path' => $photo->store('service-request-photos', 'public'),
            ]);
        }

        $serviceRequest->update([
            'cost' => $serviceRequest->total_price ?? 0,
            'worker_notes' => $validated['worker_notes'] ?? null,
            'completed_at' => now(),
            'status' => 'completed',
        ]);

        (new CoinRewardService())
            ->awardForServiceRequest($serviceRequest, $serviceRequest->user, $serviceRequest->total_price ?? 0);

        return back()->with('success', 'Laundry ditandai selesai & sudah diterima guest.');
    }

    public function complete(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->worker_id === auth()->id(), 403);
        abort_if($serviceRequest->isLaundry(), 422, 'Laundry pakai alur tersendiri: selesai cuci → bayar → konfirmasi terima.');
        abort_if(!$serviceRequest->isInProgress(), 422, 'Tugas ini belum berstatus sedang dikerjakan.');

        $isSurveyPriced = $serviceRequest->requiresSurveyPricing();

        if ($isSurveyPriced) {
            abort_if(!$serviceRequest->isPriceApproved(), 422, 'Harga belum disetujui & dibayar guest.');
        }

        $validated = $request->validate([
            'worker_notes' => ['nullable', 'string', 'max:1000'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $validated, $serviceRequest, $isSurveyPriced) {
            $serviceRequest->loadMissing('service', 'user');

            $cost = match (true) {
                $serviceRequest->service->slug === 'laundry' => $serviceRequest->total_price ?? 0,
                $serviceRequest->service->slug === 'cleaning' => $serviceRequest->total_price ?? 0,
                $isSurveyPriced => $serviceRequest->total_price ?? 0,
                $serviceRequest->service->slug === 'ac' => $serviceRequest->snapshot_ac_price ?? 0,
                default => $serviceRequest->service->base_price ?? 0,
            };

            $guest = $serviceRequest->user()->lockForUpdate()->first();

            if (!$isSurveyPriced) {
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
            }

            $rewardBase = $isSurveyPriced ? ($serviceRequest->total_price ?? 0) : $cost;
            (new CoinRewardService())->awardForServiceRequest($serviceRequest, $guest, $rewardBase);

            foreach ($request->file('photos', []) as $photo) {
                $serviceRequest->photos()->create([
                    'type' => 'after',
                    'photo_path' => $photo->store('service-request-photos', 'public'),
                ]);
            }

            $serviceRequest->update([
                'cost' => $isSurveyPriced ? ($serviceRequest->total_price ?? 0) : $cost,
                'worker_notes' => $validated['worker_notes'] ?? null,
                'completed_at' => now(),
                'status' => 'completed',
            ]);
        });

        return back()->with('success', 'Tugas ditandai selesai.');
    }
}
