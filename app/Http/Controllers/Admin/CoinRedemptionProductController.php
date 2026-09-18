<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoinRedemptionProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CoinRedemptionProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = CoinRedemptionProduct::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $products = $query->latest()->paginate(20)->withQueryString();

        return view('admin.coin-redemption-products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.coin-redemption-products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'coin_cost' => ['required', 'integer', 'min:1'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('coin-redemption-products', 'public');
        }

        CoinRedemptionProduct::create($validated);

        return redirect()->route('admin.coin-redemption-products.index')
            ->with('success', 'Produk penukaran koin berhasil ditambahkan.');
    }

    public function edit(CoinRedemptionProduct $coinRedemptionProduct): View
    {
        return view('admin.coin-redemption-products.edit', ['product' => $coinRedemptionProduct]);
    }

    public function update(Request $request, CoinRedemptionProduct $coinRedemptionProduct): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'coin_cost' => ['required', 'integer', 'min:1'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($coinRedemptionProduct->image) {
                Storage::disk('public')->delete($coinRedemptionProduct->image);
            }
            $validated['image'] = $request->file('image')->store('coin-redemption-products', 'public');
        }

        $coinRedemptionProduct->update($validated);

        return redirect()->route('admin.coin-redemption-products.index')
            ->with('success', 'Produk penukaran koin berhasil diperbarui.');
    }

    public function destroy(CoinRedemptionProduct $coinRedemptionProduct): RedirectResponse
    {
        if ($coinRedemptionProduct->image) {
            Storage::disk('public')->delete($coinRedemptionProduct->image);
        }

        $coinRedemptionProduct->delete();

        return redirect()->route('admin.coin-redemption-products.index')
            ->with('success', 'Produk penukaran koin berhasil dihapus.');
    }
}