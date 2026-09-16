@extends('layouts.guest')

@section('title', 'Home')

@section('header')
    <h2 class="font-semibold text-lg text-gray-800">
        {{ __('Welcome, ') }}{{ auth()->user()->name }}
    </h2>
@endsection

@section('content')
    <div class="py-4 px-4 space-y-4">

        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-xl p-6 text-white">
            <p class="text-indigo-100 text-sm">Saldo Saat Ini</p>
            <p class="text-3xl font-bold mt-1">Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
        </div>

        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('guest.topups.create') }}" class="bg-indigo-600 text-white py-3 rounded-lg text-center font-medium hover:bg-indigo-700 transition-colors">
                + Top Up
            </a>
            <a href="{{ route('guest.service-requests.create') }}" class="bg-green-600 text-white py-3 rounded-lg text-center font-medium hover:bg-green-700 transition-colors">
                Ajukan Jasa
            </a>
        </div>

        <div>
            <h3 class="font-semibold text-gray-900 mb-3">Permintaan Terbaru</h3>
            @php
                $recentRequests = auth()->user()->serviceRequests()->with('service')->latest()->take(3)->get();
            @endphp

            @if ($recentRequests->isEmpty())
                <p class="text-sm text-gray-500">Belum ada permintaan jasa.</p>
            @else
                <div class="space-y-3">
                    @foreach ($recentRequests as $request)
                        <a href="{{ route('guest.service-requests.show', $request) }}" class="block">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-medium text-gray-900">{{ $request->service->name }}</h4>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($request->status === 'completed') bg-green-100 text-green-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
@endsection
