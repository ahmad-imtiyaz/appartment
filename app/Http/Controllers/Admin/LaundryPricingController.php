<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaundryPricing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaundryPricingController extends Controller
{
    public function index(Request $request): View
    {
        $pricings = LaundryPricing::when($request->search, fn ($q) => $q->where('type', 'like', "%{$request->search}%")
            ->orWhere('duration', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(20);

        return view('admin.laundry-pricings.index', compact('pricings'));
    }

    public function create(): View
    {
        return view('admin.laundry-pricings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:cuci,cuci_setrika,setrika'],
            'duration' => ['required', 'in:reguler,express'],
            'price_per_kg' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Prevent duplicate combinations
        $exists = LaundryPricing::where('type', $validated['type'])
            ->where('duration', $validated['duration'])
            ->first();

        abort_if($exists, 422, 'Harga untuk kombinasi ini sudah ada.');

        LaundryPricing::create($validated);

        return redirect()->route('admin.laundry-pricings.index')
            ->with('success', 'Harga laundry berhasil ditambahkan.');
    }

    public function edit(LaundryPricing $pricing): View
    {
        return view('admin.laundry-pricings.edit', compact('pricing'));
    }

    public function update(Request $request, LaundryPricing $pricing): RedirectResponse
    {
        $validated = $request->validate([
            'price_per_kg' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $pricing->update($validated);

        return redirect()->route('admin.laundry-pricings.index')
            ->with('success', 'Harga laundry berhasil diperbarui.');
    }

    public function destroy(LaundryPricing $pricing): RedirectResponse
    {
        // Check if pricing is currently being used in active orders
        $activeOrders = \App\Models\ServiceRequest::where('laundry_type', $pricing->type)
            ->where('laundry_duration', $pricing->duration)
            ->whereIn('status', ['pending', 'assigned', 'in_progress'])
            ->exists();

        abort_if($activeOrders, 422, 'Harga ini sedang digunakan oleh pesanan aktif. Tidak bisa dihapus.');

        $pricing->delete();

        return redirect()->route('admin.laundry-pricings.index')
            ->with('success', 'Harga laundry berhasil dihapus.');
    }
}
