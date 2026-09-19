<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepairPricing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RepairPricingController extends Controller
{
    public function index(): View
    {
        $order = array_flip(array_keys(RepairPricing::SEVERITIES));

        $pricings = RepairPricing::all()
            ->sort(fn($a, $b) => [$a->category, $order[$a->severity] ?? 99] <=> [$b->category, $order[$b->severity] ?? 99])
            ->values();

        return view('admin.repair-pricings.index', compact('pricings'));
    }

    public function create(): View
    {
        return view('admin.repair-pricings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        RepairPricing::create($this->validated($request));

        return redirect()->route('admin.repair-pricings.index')
            ->with('success', 'Harga repair berhasil ditambahkan.');
    }

    public function edit(RepairPricing $pricing): View
    {
        return view('admin.repair-pricings.edit', [
            'pricing' => $pricing,

        ]);
    }

   public function update(Request $request, RepairPricing $pricing): RedirectResponse
    {
        $pricing->update($this->validated($request, $pricing));

        return redirect()->route('admin.repair-pricings.index')
            ->with('success', 'Harga repair berhasil diperbarui.');
    }

     public function toggle(RepairPricing $pricing): RedirectResponse
    {
        $pricing->update(['is_active' => ! $pricing->is_active]);

                return back()->with('success', 'Harga "' . $pricing->category . ' (' . $pricing->severity_label . ')" ' .
            ($pricing->is_active ? 'diaktifkan.' : 'dinonaktifkan.'));
    }

    public function destroy(RepairPricing $pricing): RedirectResponse
    {
        // Aman dihapus: order menyimpan snapshot harga sendiri (snapshot_repair_price).
        $pricing->delete();

        return redirect()->route('admin.repair-pricings.index')
            ->with('success', 'Harga repair berhasil dihapus.');
    }

    private function validated(Request $request, ?RepairPricing $current = null): array
    {


        $data = $request->validate([
            'category' => ['required', Rule::in(array_keys(RepairPricing::CATEGORIES))],
            'severity' => [
                'required',
                Rule::in(array_keys(RepairPricing::SEVERITIES)),
                Rule::unique('repair_pricings', 'severity')
                    ->where(fn($q) => $q->where('category', $request->input('category')))
                    ->ignore($current?->id),
            ],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ], [

            'severity.unique' => 'Kategori ini sudah punya harga untuk tingkat kerusakan tersebut.',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
