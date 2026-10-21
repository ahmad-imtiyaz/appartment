<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkerPayout;
use App\Notifications\WorkerPayoutPaidNotification;
use App\Services\FcmService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use function Illuminate\Support\defer;

class WorkerPayoutController extends Controller
{
    public function index(Request $request): View
    {
        $status = in_array($request->status, ['pending', 'paid']) ? $request->status : null;

        $payouts = WorkerPayout::with(['worker', 'serviceRequest.service', 'processedBy'])
            ->when($status, fn ($q) => $q->where('status', $status))
            // yang menunggu diproses tampil paling atas
            ->orderByRaw("status = 'pending' desc")
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $pendingCount = WorkerPayout::where('status', 'pending')->count();
        $pendingTotal = WorkerPayout::where('status', 'pending')->sum('amount');

        return view('admin.worker-payouts.index', compact('payouts', 'status', 'pendingCount', 'pendingTotal'));
    }

    /**
     * Tandai sudah ditransfer + upload foto bukti transfer.
     */
    public function pay(Request $request, WorkerPayout $workerPayout): RedirectResponse
    {
        $validated = $request->validate([
            'proof' => ['required', 'image', 'max:4096'],
            'admin_note' => ['nullable', 'string', 'max:255'],
        ], [
            'proof.required' => 'Upload foto bukti transfer.',
            'proof.image' => 'Bukti transfer harus berupa gambar.',
        ]);

        $path = $request->file('proof')->store('worker-payout-proofs', 'public');

        $paid = DB::transaction(function () use ($workerPayout, $validated, $path) {
            $locked = WorkerPayout::lockForUpdate()->findOrFail($workerPayout->id);

            if (!$locked->isPending()) {
                return false;
            }

            $locked->update([
                'status' => 'paid',
                'proof_path' => $path,
                'admin_note' => $validated['admin_note'] ?? null,
                'processed_by' => auth()->id(),
                'paid_at' => now(),
            ]);

            return true;
        });

        if (!$paid) {
            Storage::disk('public')->delete($path);

            return back()->with('error', 'Pencairan ini sudah diproses sebelumnya.');
        }

        $workerPayout->refresh()->load(['worker', 'serviceRequest.service']);
        $worker = $workerPayout->worker;
        $amount = 'Rp' . number_format($workerPayout->amount, 0, ',', '.');

        // Pemberitahuan ke pekerja: push (aplikasi) + email
        defer(fn () => app(FcmService::class)->sendToUser(
            $worker,
            'Pembayaran Selesai',
            'Telah dibayarkan sejumlah ' . $amount . '. Ketuk untuk melihat bukti transfer.',
            ['path' => route('worker.payouts.index', [], false)],
        ));

        try {
            $worker->notify(new WorkerPayoutPaidNotification($workerPayout));
        } catch (\Throwable $e) {
            report($e);
        }

        return back()->with('success', 'Pencairan ' . $amount . ' ke ' . $worker->name . ' ditandai selesai.');
    }
}
