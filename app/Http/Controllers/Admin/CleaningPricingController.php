<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CleaningPricing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CleaningPricingController extends Controller
{
    // tidak ada index/create — cuma 1 tarif aktif yang di-edit terus
    public function edit(): View
    {
        $pricing = CleaningPricing::active()->latest()->first();

        return view('admin.cleaning-pricings.edit', compact('pricing'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'price_per_hour' => ['required', 'numeric', 'min:0'],
        ]);

        $pricing = CleaningPricing::active()->latest()->first();

        if ($pricing) {
            $pricing->update($validated);
        } else {
            CleaningPricing::create($validated + ['is_active' => true]);
        }

        return redirect()->route('admin.cleaning-pricings.index')
            ->with('success', 'Tarif cleaning per jam berhasil diperbarui.');
    }
}
