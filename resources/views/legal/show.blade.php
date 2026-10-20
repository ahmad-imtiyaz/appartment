@extends('layouts.oregonet-auth')

@section('title', $doc->title)

@section('content')

    <h1 class="au-title">{{ $doc->title }}</h1>
    <p class="au-sub">
        Versi {{ $doc->version }} &middot; Diperbarui {{ $doc->updated_at->translatedFormat('d F Y') }}
    </p>

    <div class="au-legal">{!! nl2br(e($doc->content)) !!}</div>

    <p class="au-foot">
        <a class="au-link" href="javascript:window.close()">Tutup</a>
    </p>

    <style>
        .au-legal { max-height: 60vh; overflow-y: auto; line-height: 1.6; font-size: .92rem; padding-right: 6px; }
    </style>

@endsection
