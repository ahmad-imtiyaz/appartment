<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CleaningArea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CleaningAreaController extends Controller
{
    public function index(Request $request): View
    {
        $areas = CleaningArea::when($request->search, fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(20);

        return view('admin.cleaning-areas.index', compact('areas'));
    }

    public function create(): View
    {
        return view('admin.cleaning-areas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:cleaning_areas,name'],
            'is_active' => ['boolean'],
        ]);

        CleaningArea::create($validated);

        return redirect()->route('admin.cleaning-areas.index')
            ->with('success', 'Area cleaning berhasil ditambahkan.');
    }

    public function edit(CleaningArea $cleaningArea): View
    {
        return view('admin.cleaning-areas.edit', compact('cleaningArea'));
    }

    public function update(Request $request, CleaningArea $cleaningArea): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:cleaning_areas,name,' . $cleaningArea->id],
            'is_active' => ['boolean'],
        ]);

        $cleaningArea->update($validated);

        return redirect()->route('admin.cleaning-areas.index')
            ->with('success', 'Area cleaning berhasil diperbarui.');
    }

    public function destroy(CleaningArea $cleaningArea): RedirectResponse
    {
        $inUse = $cleaningArea->serviceRequests()
            ->whereIn('status', ['pending', 'assigned', 'in_progress'])
            ->exists();

        if ($inUse) {
            return redirect()->route('admin.cleaning-areas.index')
                ->with('error', 'Area ini sedang dipakai pesanan aktif. Tidak bisa dihapus.');
        }

        $cleaningArea->delete();

        return redirect()->route('admin.cleaning-areas.index')
            ->with('success', 'Area cleaning berhasil dihapus.');
    }
}
