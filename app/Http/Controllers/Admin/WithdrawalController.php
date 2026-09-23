<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BalanceMutation;
use App\Models\User;
use App\Models\WithdrawalRequest;
use App\Models\WithdrawalSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WithdrawalController extends Controller
{
    public function index(): View
    {
        $withdrawals = WithdrawalRequest::with('user')->latest()->paginate(20);

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function approve(WithdrawalRequest $withdrawalRequest): RedirectResponse
    {
        abort_if(!$withdrawalRequest->isPending(), 422, 'Penarikan ini sudah diproses.');

        $withdrawalRequest->update([
            'status' => 'approved',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        return back()->with('success', 'Penarikan ditandai selesai (sudah ditransfer).');
    }

    public function reject(Request $request, WithdrawalRequest $withdrawalRequest): RedirectResponse
    {
        abort_if(!$withdrawalRequest->isPending(), 422, 'Penarikan ini sudah diproses.');

        $validated = $request->validate([
            'admin_note' => ['required', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($withdrawalRequest, $validated) {
            $user = User::whereKey($withdrawalRequest->user_id)->lockForUpdate()->first();

            $before = $user->balance;
            $after = $before + $withdrawalRequest->amount;
            $user->update(['balance' => $after]);

            BalanceMutation::create([
                'user_id' => $user->id,
                'type' => 'credit',
                'amount' => $withdrawalRequest->amount,
                'balance_before' => $before,
                'balance_after' => $after,
                'reference_type' => 'WithdrawalRequest',
                'reference_id' => $withdrawalRequest->id,
                'description' => 'Pengembalian saldo, penarikan ditolak',
            ]);

            $withdrawalRequest->update([
                'status' => 'rejected',
                'admin_note' => $validated['admin_note'],
                'processed_by' => auth()->id(),
                'processed_at' => now(),
            ]);
        });

        return back()->with('success', 'Penarikan ditolak, saldo dikembalikan ke user.');
    }

    public function settings(): View
    {
        $setting = WithdrawalSetting::current();

        return view('admin.withdrawals.settings', compact('setting'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'min_amount' => ['required', 'numeric', 'min:1000'],
            'fee_type' => ['required', 'in:flat,percent'],
            'fee_value' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validated['fee_type'] === 'percent' && $validated['fee_value'] > 100) {
            return back()->withInput()->withErrors(['fee_value' => 'Persentase maksimal 100.']);
        }

        WithdrawalSetting::current()->update($validated);

        return back()->with('success', 'Setting penarikan berhasil disimpan.');
    }
}
