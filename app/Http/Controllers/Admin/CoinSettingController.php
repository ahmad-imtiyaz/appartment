<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoinSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoinSettingController extends Controller
{
    public function index(): View
    {
        $setting = CoinSetting::current();

        return view('admin.coin-settings.index', compact('setting'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'increment_amount' => ['required', 'numeric', 'min:1'],
            'points_per_increment' => ['required', 'integer', 'min:1'],
        ]);

        CoinSetting::current()->update($validated);

        return redirect()->route('admin.coin-settings.index')
            ->with('success', 'Setting poin berhasil diperbarui.');
    }
}
