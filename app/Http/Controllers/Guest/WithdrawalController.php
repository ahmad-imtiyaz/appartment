<?php

namespace App\Http\Controllers\Guest;

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
        $withdrawals = auth()->user()->withdrawalRequests()->latest()->get();

        return view('guest.withdrawals.index', compact('withdrawals'));
    }

    public function create(): View
    {
        $setting = WithdrawalSetting::current();

        return view('guest.withdrawals.create', compact('setting'));
    }

    public function store(Request $request): RedirectResponse
    {
        $setting = WithdrawalSetting::current();

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:' . $setting->min_amount],
            'bank_name' => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_holder_name' => ['required', 'string', 'max:100'],
        ], [
            'amount.min' => 'Minimal penarikan Rp' . number_format($setting->min_amount, 0, ',', '.') . '.',
        ]);

        $amount = (float) $validated['amount'];
        $fee = $setting->calculateFee($amount);
        $net = $amount - $fee;

        if ($net <= 0) {
            return back()->withInput()->withErrors(['amount' => 'Nominal terlalu kecil setelah dipotong biaya admin.']);
        }

        $ok = DB::transaction(function () use ($validated, $amount, $fee, $net) {
            $user = User::whereKey(auth()->id())->lockForUpdate()->first();

            if ($user->balance < $amount) {
                return false;
            }

            $before = $user->balance;
            $after = $before - $amount;
            $user->update(['balance' => $after]);

            $withdrawal = WithdrawalRequest::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'fee' => $fee,
                'net_amount' => $net,
                'bank_name' => $validated['bank_name'],
                'account_number' => $validated['account_number'],
                'account_holder_name' => $validated['account_holder_name'],
                'status' => 'pending',
            ]);

            BalanceMutation::create([
                'user_id' => $user->id,
                'type' => 'debit',
                'amount' => $amount,
                'balance_before' => $before,
                'balance_after' => $after,
                'reference_type' => 'WithdrawalRequest',
                'reference_id' => $withdrawal->id,
                'description' => 'Pengajuan penarikan saldo',
            ]);

            return true;
        });

        if (!$ok) {
            return back()->withInput()->withErrors(['amount' => 'Saldo tidak cukup.']);
        }

        return redirect()
            ->route('guest.withdrawals.index')
            ->with('success', __('guest.flash.withdraw_sent'));
    }
}
