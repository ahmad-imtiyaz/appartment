<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CleaningPricing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CleaningPricingController extends Controller
{
    public function index(Request $request): View
    {
        $pricings = CleaningPricing::when($request->search, fn ($q) => $q->where('type', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(20);

        return view('admin.cleaning-pricings.index', compact('pricings'));
    }

    public function create(): View
    {
        return view('admin.cleaning-pricings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:cleaning-regular,cleaning-deep,cleaning-postmove'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Prevent duplicate type
        $exists = CleaningPricing::where('type', $validated['type'])->first();

        abort_if($exists, 422, 'Harga untuk jenis cleaning ini sudah ada.');

        CleaningPricing::create($validated);

        return redirect()->route('admin.cleaning-pricings.index')
            ->with('success', 'Harga cleaning berhasil ditambahkan.');
    }

    public function edit(CleaningPricing $pricing): View
    {
        return view('admin.cleaning-pricings.edit', compact('pricing'));
    }

    public function update(Request $request, CleaningPricing $pricing): RedirectResponse
    {
        $validated = $request->validate([
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $pricing->update($validated);

        return redirect()->route('admin.cleaning-pricings.index')
            ->with('success', 'Harga cleaning berhasil diperbarui.');
    }

    public function destroy(CleaningPricing $pricing): RedirectResponse
    {
        // Check if there are any active cleaning service requests
        $activeOrders = \App\Models\ServiceRequest::whereHas('service', function ($q) {
                $q->where('services.slug', 'cleaning');
            })
            ->whereIn('status', ['pending', 'assigned', 'in_progress'])
            ->exists();

        if ($activeOrders) {
            return redirect()->route('admin.cleaning-pricings.index')
                ->with('error', 'Harga ini sedang digunakan oleh pesanan aktif. Tidak bisa dihapus.');
        }

        $pricing->delete();

        return redirect()->route('admin.cleaning-pricings.index')
            ->with('success', 'Harga cleaning berhasil dihapus.');
    }
}