@extends('layouts.oregonet-auth')

@section('title', 'Sebelum Bergabung')

@section('content')

    <h1 class="au-title">Sebelum Bergabung</h1>
    <p class="au-sub">Mohon baca dan setujui ketentuan berikut sebelum membuat akun Oregonet.</p>

    @if (session('status'))
        <p class="au-help">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('register.consent.store') }}" class="au-form">
        @csrf

        <div class="au-doc-list">
            <a href="{{ route('legal.terms') }}" target="_blank" rel="noopener" class="au-doc">
                <div>
                    <strong>{{ $terms->title }}</strong>
                    <small>{{ $terms->summary }}</small>
                </div>
                <span aria-hidden="true">&rsaquo;</span>
            </a>

            <a href="{{ route('legal.privacy') }}" target="_blank" rel="noopener" class="au-doc">
                <div>
                    <strong>{{ $privacy->title }}</strong>
                    <small>{{ $privacy->summary }}</small>
                </div>
                <span aria-hidden="true">&rsaquo;</span>
            </a>
        </div>

        <label class="au-check">
            <input type="checkbox" name="agree_terms" value="1" id="agree_terms">
            <span>Saya menyetujui Syarat dan Ketentuan Oregonet.</span>
        </label>
        @error('agree_terms')
            <p class="au-error">{{ $message }}</p>
        @enderror

        <label class="au-check">
            <input type="checkbox" name="agree_privacy" value="1" id="agree_privacy">
            <span>Saya telah membaca Kebijakan Privasi Oregonet.</span>
        </label>
        @error('agree_privacy')
            <p class="au-error">{{ $message }}</p>
        @enderror

        <button type="submit" class="au-btn" id="consent-btn" disabled>
            Setuju &amp; Lanjutkan
        </button>
    </form>

    <p class="au-foot">
        <a class="au-link" href="{{ route('login') }}">Sudah Punya Akun? Masuk</a>
    </p>

    <style>
        .au-doc-list { border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; margin-bottom: 16px; }
        .au-doc { display: flex; justify-content: space-between; align-items: center; padding: 14px 16px; text-decoration: none; color: inherit; }
        .au-doc + .au-doc { border-top: 1px solid #e5e7eb; }
        .au-doc small { display: block; opacity: .65; margin-top: 2px; }
        .au-check { display: flex; gap: 10px; align-items: center; margin: 10px 0; font-size: .9rem; cursor: pointer; }
        .au-btn[disabled] { opacity: .5; cursor: not-allowed; }
    </style>

    <script>
        const agreeTerms = document.getElementById('agree_terms');
        const agreePrivacy = document.getElementById('agree_privacy');
        const consentBtn = document.getElementById('consent-btn');

        function syncConsentButton() {
            consentBtn.disabled = !(agreeTerms.checked && agreePrivacy.checked);
        }

        agreeTerms.addEventListener('change', syncConsentButton);
        agreePrivacy.addEventListener('change', syncConsentButton);
        syncConsentButton();
    </script>

@endsection
