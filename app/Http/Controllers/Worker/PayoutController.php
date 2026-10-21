<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\WorkerPayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PayoutController extends Controller
{
    /**
     * Riwayat pencairan pendapatan pekerja.
     */
    public function index(): View
    {
        $worker = auth()->user();

        $payouts = $worker->workerPayouts()
            ->with('serviceRequest.service')
            ->latest()
            ->paginate(20);

        $totalPaid = $worker->workerPayouts()->where('status', 'paid')->sum('amount');
        $totalPending = $worker->workerPayouts()->where('status', 'pending')->sum('amount');

        // Tugas selesai yang pendapatannya belum diajukan
        $unrequested = ServiceRequest::with('service')
            ->where('worker_id', $worker->id)
            ->where('status', 'completed')
            ->where('worker_earning', '>', 0)
            ->doesntHave('payout')
            ->latest('completed_at')
            ->get();

        return view('worker.payouts.index', compact('payouts', 'totalPaid', 'totalPending', 'unrequested'));
    }

    /**
     * Ajukan pencairan pendapatan satu tugas.
     */
    public function store(ServiceRequest $serviceRequest): RedirectResponse
    {
        $worker = auth()->user();

        abort_unless($serviceRequest->worker_id === $worker->id, 403);

        if (!$worker->hasBankAccount()) {
            return redirect()
                ->route('worker.profile.edit')
                ->with('error', 'Lengkapi data rekening dulu sebelum mengajukan pencairan.');
        }

        $created = DB::transaction(function () use ($serviceRequest, $worker) {
            // Kunci baris tugas supaya klik ganda tidak membuat 2 pengajuan
            $locked = ServiceRequest::lockForUpdate()->findOrFail($serviceRequest->id);

            if (!$locked->canRequestPayout()) {
                return false;
            }

            WorkerPayout::create([
                'service_request_id' => $locked->id,
                'worker_id' => $worker->id,
                'amount' => $locked->worker_earning,
                'bank_name' => $worker->bank_name,
                'account_number' => $worker->bank_account_number,
                'account_holder_name' => $worker->bank_account_holder,
                'status' => 'pending',
            ]);

            return true;
        });

        if (!$created) {
            return back()->with('error', 'Pendapatan tugas ini tidak bisa diajukan atau sudah pernah diajukan.');
        }

        return back()->with('success', 'Pencairan Rp' . number_format($serviceRequest->worker_earning, 0, ',', '.') . ' berhasil diajukan, menunggu diproses admin.');
    }
}
