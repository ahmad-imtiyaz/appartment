<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LegalDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConsentController extends Controller
{
    public function show(): View
    {
        return view('auth.consent', [
            'terms'   => LegalDocument::terms(),
            'privacy' => LegalDocument::privacy(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'agree_terms'   => ['accepted'],
            'agree_privacy' => ['accepted'],
        ], [
            'agree_terms.accepted'   => 'Anda harus menyetujui Syarat dan Ketentuan.',
            'agree_privacy.accepted' => 'Anda harus mengonfirmasi telah membaca Kebijakan Privasi.',
        ]);

        session(['register_consent' => [
            'terms_version'   => LegalDocument::terms()->version,
            'privacy_version' => LegalDocument::privacy()->version,
        ]]);

        return redirect()->route('register');
    }
}
