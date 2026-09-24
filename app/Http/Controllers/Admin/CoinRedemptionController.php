<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoinRedemption;
use App\Models\CoinMutation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoinRedemptionController extends Controller
{
    public function index(Request $request): View
    {
        $query = CoinRedemption::with(['user', 'product'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            })->orWhereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        $redemptions = $query->paginate(20)->withQueryString();

        return view('admin.coin-redemptions.index', compact('redemptions'));
    }

    public function show(CoinRedemption $coinRedemption): View
    {
        $coinRedemption->load(['user', 'product', 'processor']);
        return view('admin.coin-redemptions.show', compact('coinRedemption'));
    }

    public function approve(Request $request, CoinRedemption $coinRedemption): RedirectResponse
    {
        if (!$coinRedemption->isProcessing()) {
            return back()->with('error', 'Hanya penukaran dengan status "Sedang Proses" yang bisa di-approve.');
        }

        $coinRedemption->update([
            'status' => 'completed',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'admin_notes' => $request->input('admin_notes'),
        ]);

        return redirect()->route('admin.coin-redemptions.index')
             ->with('success', 'Penukaran poin berhasil di-approve.');
    }

    public function reject(Request $request, CoinRedemption $coinRedemption): RedirectResponse
    {
        if (!$coinRedemption->isProcessing()) {
            return back()->with('error', 'Hanya penukaran dengan status "Sedang Proses" yang bisa di-reject.');
        }

        // Refund coins to user
        $user = $coinRedemption->user;
        $balanceBefore = $user->coin_balance;
        $balanceAfter = $balanceBefore + $coinRedemption->coin_cost;

        $user->update(['coin_balance' => $balanceAfter]);

        // Record coin mutation for refund
        CoinMutation::create([
            'user_id' => $user->id,
            'type' => 'earn', // refund is like earning coins back
            'amount' => $coinRedemption->coin_cost,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'reference_type' => 'CoinRedemption',
            'reference_id' => $coinRedemption->id,
            'description' => 'Refund penukaran ditolak: ' . $coinRedemption->product->name,
        ]);

        $coinRedemption->update([
            'status' => 'cancelled',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'admin_notes' => $request->input('admin_notes'),
        ]);

        return redirect()->route('admin.coin-redemptions.index')
            ->with('success', 'Penukaran poin ditolak, poin dikembalikan ke user.');
    }
}
