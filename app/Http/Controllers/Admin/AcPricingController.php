<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcPricing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcPricingController extends Controller
{
    public function index(Request $request): View
    {
        $pricings = AcPricing::when($request->search, fn ($q) => $q->where('type', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(20);

        return view('admin.ac-pricings.index', compact('pricings'));
    }

    public function create(): View
    {
        return view('admin.ac-pricings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:ac-cleaning,ac-refill,ac-repair'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Prevent duplicate type
        $exists = AcPricing::where('type', $validated['type'])->first();

        abort_if($exists, 422, 'Harga untuk jenis AC service ini sudah ada.');

        AcPricing::create($validated);

        return redirect()->route('admin.ac-pricings.index')
            ->with('success', 'Harga AC berhasil ditambahkan.');
    }

    public function edit(AcPricing $pricing): View
    {
        return view('admin.ac-pricings.edit', compact('pricing'));
    }

    public function update(Request $request, AcPricing $pricing): RedirectResponse
    {
        $validated = $request->validate([
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $pricing->update($validated);

        return redirect()->route('admin.ac-pricings.index')
            ->with('success', 'Harga AC berhasil diperbarui.');
    }

    public function destroy(AcPricing $pricing): RedirectResponse
    {
        // Check if there are any active AC service requests
        $activeOrders = \App\Models\ServiceRequest::whereHas('service', function ($q) {
                $q->where('services.slug', 'ac');
            })
            ->whereIn('status', ['pending', 'assigned', 'in_progress'])
            ->exists();

        if ($activeOrders) {
            return redirect()->route('admin.ac-pricings.index')
                ->with('error', 'Harga ini sedang digunakan oleh pesanan aktif. Tidak bisa dihapus.');
        }

        $pricing->delete();

        return redirect()->route('admin.ac-pricings.index')
            ->with('success', 'Harga AC berhasil dihapus.');
    }
}
