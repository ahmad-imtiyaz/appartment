<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\CoinMutation;
use App\Models\CoinRedemption;
use App\Models\CoinRedemptionProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoinRedemptionController extends Controller
{
    public function index(): View
    {
        $products = CoinRedemptionProduct::active()->get();
        $redemptions = auth()->user()->coinRedemptions()->with('product')->latest()->paginate(10);

        return view('guest.coin-redemptions.index', compact('products', 'redemptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'coin_redemption_product_id' => ['required', 'exists:coin_redemption_products,id'],
        ]);

        $product = CoinRedemptionProduct::findOrFail($validated['coin_redemption_product_id']);

        if (!$product->canBeRedeemed()) {
            return back()->with('error', 'Produk tidak tersedia untuk ditukarkan.');
        }

        $user = auth()->user();

        if ($user->coin_balance < $product->coin_cost) {
            return back()->with('error', 'Koin Anda tidak mencukupi untuk menukarkan produk ini.');
        }

        // Deduct coins
        $balanceBefore = $user->coin_balance;
        $balanceAfter = $balanceBefore - $product->coin_cost;

        $user->update(['coin_balance' => $balanceAfter]);

        // Create redemption record
        $redemption = CoinRedemption::create([
            'user_id' => $user->id,
            'coin_redemption_product_id' => $product->id,
            'coin_cost' => $product->coin_cost,
            'status' => 'processing',
        ]);

        // Record coin mutation
        CoinMutation::create([
            'user_id' => $user->id,
            'type' => 'redeem',
            'amount' => $product->coin_cost,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'reference_type' => 'CoinRedemption',
            'reference_id' => $redemption->id,
            'description' => 'Penukaran koin: ' . $product->name,
        ]);

        // Decrease product stock
        $product->decrement('stock');

        return redirect()->route('guest.coin-redemptions.index')
            ->with('success', 'Permintaan penukaran koin berhasil diajukan. Menunggu persetujuan admin.');
    }

    public function cancel(CoinRedemption $coinRedemption): RedirectResponse
    {
        // Check ownership
        if ($coinRedemption->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$coinRedemption->canBeCancelledByGuest()) {
            return back()->with('error', 'Hanya penukaran dengan status "Sedang Proses" yang bisa dibatalkan.');
        }

        // Refund coins
        $user = auth()->user();
        $balanceBefore = $user->coin_balance;
        $balanceAfter = $balanceBefore + $coinRedemption->coin_cost;

        $user->update(['coin_balance' => $balanceAfter]);

        // Record coin mutation for refund
        CoinMutation::create([
            'user_id' => $user->id,
            'type' => 'earn',
            'amount' => $coinRedemption->coin_cost,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'reference_type' => 'CoinRedemption',
            'reference_id' => $coinRedemption->id,
            'description' => 'Refund pembatalan penukaran: ' . $coinRedemption->product->name,
        ]);

        // Increase product stock
        $coinRedemption->product->increment('stock');

        $coinRedemption->update([
            'status' => 'cancelled',
            'processed_at' => now(),
        ]);

        return redirect()->route('guest.coin-redemptions.index')
            ->with('success', 'Penukaran koin dibatalkan, koin dikembalikan ke akun Anda.');
    }
}