<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommissionSettingController extends Controller
{
    public function index()
    {
        $setting = CommissionSetting::current();

        return view('admin.commission-settings.index', compact('setting'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        ], [
            'percentage.required' => 'Persentase potongan wajib diisi.',
            'percentage.numeric' => 'Persentase harus berupa angka.',
            'percentage.min' => 'Persentase minimal 0.',
            'percentage.max' => 'Persentase maksimal 100.',
        ]);

        CommissionSetting::current()->update(['percentage' => $validated['percentage']]);

        return back()->with('success', 'Potongan admin diubah menjadi ' . rtrim(rtrim(number_format($validated['percentage'], 2, ',', '.'), '0'), ',') . '%. Berlaku untuk tugas yang selesai setelah ini.');
    }
}
