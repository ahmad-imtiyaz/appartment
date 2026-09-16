<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::latest()->get();

        return view('admin.payment-methods.index', compact('paymentMethods'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:bank_transfer,qris'],
            'display_name' => ['required', 'string', 'max:255'],
            'bank_name' => ['required_if:type,bank_transfer', 'nullable', 'string', 'max:255'],
            'account_number' => ['required_if:type,bank_transfer', 'nullable', 'string', 'max:50'],
            'account_holder_name' => ['required_if:type,bank_transfer', 'nullable', 'string', 'max:255'],
            'qr_image' => ['required_if:type,qris', 'nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('qr_image')) {
            $validated['qr_image'] = $request->file('qr_image')->store('payment-methods', 'public');
        }

        PaymentMethod::create($validated);

        return back()->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function update(Request $request, PaymentMethod $paymentMethod): RedirectResponse
    {
        $validated = $request->validate([
            'display_name' => ['required', 'string', 'max:255'],
            'bank_name' => ['required_if:type,bank_transfer', 'nullable', 'string', 'max:255'],
            'account_number' => ['required_if:type,bank_transfer', 'nullable', 'string', 'max:50'],
            'account_holder_name' => ['required_if:type,bank_transfer', 'nullable', 'string', 'max:255'],
            'qr_image' => ['nullable', 'image', 'max:2048'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('qr_image')) {
            if ($paymentMethod->qr_image) {
                Storage::disk('public')->delete($paymentMethod->qr_image);
            }
            $validated['qr_image'] = $request->file('qr_image')->store('payment-methods', 'public');
        }

        $paymentMethod->update($validated);

        return back()->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(PaymentMethod $paymentMethod): RedirectResponse
    {
        // soft-nonaktifkan aja daripada dihapus, biar histori topup lama ga kehilangan referensi
        $paymentMethod->update(['is_active' => false]);

        return back()->with('success', 'Metode pembayaran dinonaktifkan.');
    }
}
