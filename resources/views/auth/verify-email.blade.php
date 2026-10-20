@extends('layouts.oregonet-auth')

@section('title', __('Verifikasi Email'))

@section('content')

    <h1 class="au-title">{{ __('Verifikasi Email') }}</h1>
    <p class="au-sub">
        {{ __('Kami sudah mengirim link verifikasi ke email Anda. Klik link tersebut untuk mengaktifkan akun. Jika belum menerima email, periksa folder spam atau kirim ulang.') }}
    </p>

    @if (session('status') == 'verification-link-sent')
        <p class="au-sub" style="color:#16a34a;">
            {{ __('Link verifikasi baru sudah dikirim ke email Anda.') }}
        </p>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="au-form">
        @csrf
        <button type="submit" class="au-btn">{{ __('Kirim Ulang Email Verifikasi') }}</button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="au-form" style="margin-top:12px;">
        @csrf
        <button type="submit" class="au-link" style="background:none;border:0;cursor:pointer;">
            {{ __('Keluar') }}
        </button>
    </form>

@endsection
