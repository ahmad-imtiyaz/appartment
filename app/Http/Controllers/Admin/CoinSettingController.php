<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoinSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoinSettingController extends Controller
{
    public function index(Request $request): View
    {
        $settings = CoinSetting::when($request->search, fn ($q) => $q->where('min_amount', 'like', "%{$request->search}%"))
            ->orderBy('min_amount')
            ->paginate(20);

        return view('admin.coin-settings.index', compact('settings'));
    }

    public function create(): View
    {
        return view('admin.coin-settings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'min_amount' => ['required', 'numeric', 'min:0', 'unique:coin_settings,min_amount'],
            'coin_reward' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ]);

        CoinSetting::create($validated);

        return redirect()->route('admin.coin-settings.index')
            ->with('success', 'Setting koin berhasil ditambahkan.');
    }

    public function edit(CoinSetting $coinSetting): View
    {
        return view('admin.coin-settings.edit', ['setting' => $coinSetting]);
    }

    public function update(Request $request, CoinSetting $coinSetting): RedirectResponse
    {
        $validated = $request->validate([
            'min_amount' => ['required', 'numeric', 'min:0', 'unique:coin_settings,min_amount,' . $coinSetting->id],
            'coin_reward' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ]);

        $coinSetting->update($validated);

        return redirect()->route('admin.coin-settings.index')
            ->with('success', 'Setting koin berhasil diperbarui.');
    }

    public function destroy(CoinSetting $coinSetting): RedirectResponse
    {
        $coinSetting->delete();

        return redirect()->route('admin.coin-settings.index')
            ->with('success', 'Setting koin berhasil dihapus.');
    }
}
