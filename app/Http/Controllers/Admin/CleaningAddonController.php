<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CleaningAddon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CleaningAddonController extends Controller
{
    public function index(Request $request): View
    {
        $addons = CleaningAddon::when($request->search, fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(20);

        return view('admin.cleaning-addons.index', compact('addons'));
    }

    public function create(): View
    {
        return view('admin.cleaning-addons.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:cleaning_addons,name'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        CleaningAddon::create($validated);

        return redirect()->route('admin.cleaning-addons.index')
            ->with('success', 'Pekerjaan tambahan berhasil ditambahkan.');
    }

    public function edit(CleaningAddon $cleaningAddon): View
    {
        return view('admin.cleaning-addons.edit', compact('cleaningAddon'));
    }

    public function update(Request $request, CleaningAddon $cleaningAddon): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:cleaning_addons,name,' . $cleaningAddon->id],
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $cleaningAddon->update($validated);

        return redirect()->route('admin.cleaning-addons.index')
            ->with('success', 'Pekerjaan tambahan berhasil diperbarui.');
    }

    public function destroy(CleaningAddon $cleaningAddon): RedirectResponse
    {
        // note: harga add-on yang sudah dipakai order lama tetap aman
        // karena disnapshot di pivot cleaning_addon_service_request
        $cleaningAddon->delete();

        return redirect()->route('admin.cleaning-addons.index')
            ->with('success', 'Pekerjaan tambahan berhasil dihapus.');
    }
}
