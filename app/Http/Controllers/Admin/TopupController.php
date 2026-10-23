<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FcmService;
use App\Models\BalanceMutation;
use App\Models\TopupRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopupController extends Controller
{
    public function index()
    {
        $topupRequests = TopupRequest::with(['user', 'paymentMethod'])
            ->latest()
            ->paginate(20);

        return view('admin.topups.index', compact('topupRequests'));
    }

    public function approve(TopupRequest $topupRequest): RedirectResponse
    {
        abort_if(!$topupRequest->isPending(), 422, 'Top up ini sudah diproses sebelumnya.');

        DB::transaction(function () use ($topupRequest) {
            $user = $topupRequest->user()->lockForUpdate()->first();

            $balanceBefore = $user->balance;
            $balanceAfter = $balanceBefore + $topupRequest->amount;

            $user->update(['balance' => $balanceAfter]);

            BalanceMutation::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => $topupRequest->amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'reference_type' => 'TopupRequest',
                'reference_id' => $topupRequest->id,
                'description' => 'Top up saldo disetujui admin',
            ]);

            $topupRequest->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Kirim notifikasi push ke guest user
            defer(fn () => app(FcmService::class)->pushUser(
                $topupRequest->user,
                'Top Up Berhasil',
                'Saldo kamu sudah bertambah Rp' . number_format($topupRequest->amount, 0, ',', '.') . '.',
                route('guest.balance', [], false),
            ));
        });

        return back()->with('success', 'Top up disetujui, saldo user sudah bertambah.');
    }

    public function reject(Request $request, TopupRequest $topupRequest): RedirectResponse
    {
        abort_if(!$topupRequest->isPending(), 422, 'Top up ini sudah diproses sebelumnya.');

        $validated = $request->validate([
            'admin_note' => ['required', 'string', 'max:255'],
        ]);

        $topupRequest->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_note' => $validated['admin_note'],
        ]);

        // Kirim notifikasi push ke guest user
        defer(fn () => app(FcmService::class)->pushUser(
            $topupRequest->user,
            'Top Up Ditolak',
            'Top up kamu ditolak. Ketuk untuk melihat alasannya.',
            route('guest.topups.index', [], false),
        ));

        return back()->with('success', 'Top up ditolak.');
    }
}
