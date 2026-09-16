<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\TopupRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TopupController extends Controller
{
    public function index()
    {
        $topups = auth()->user()->topupRequests()->with('paymentMethod')->latest()->get();

        return view('guest.topups.index', compact('topups'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'amount' => ['required', 'numeric', 'min:10000'],
            'proof_image' => ['required', 'image', 'max:2048'],
        ]);

        $validated['proof_image'] = $request->file('proof_image')->store('topup-proofs', 'public');
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        TopupRequest::create($validated);

        return back()->with('success', 'Pengajuan top up terkirim, menunggu verifikasi admin.');
    }
}
