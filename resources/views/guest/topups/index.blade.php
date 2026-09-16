@extends('layouts.guest')

@section('title', 'Riwayat Top Up')

@section('header')
    <h2 class="font-semibold text-lg text-gray-800">
        {{ __('Riwayat Top Up') }}
    </h2>
@endsection

@section('content')
    <div class="py-4 px-4">
        <!-- Current Balance Card -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-xl p-6 text-white mb-6">
            <p class="text-indigo-100 text-sm">Saldo Saat Ini</p>
            <p class="text-3xl font-bold mt-1">Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
        </div>

        <!-- Create New Topup Button -->
        <a href="{{ route('guest.topups.create') }}"
           class="block w-full mb-4 px-4 py-3 bg-indigo-600 text-white text-center rounded-lg font-medium hover:bg-indigo-700 transition-colors">
            + Top Up Baru
        </a>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-800 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-50 text-red-800 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Topup History -->
        @if ($topups->isEmpty())
            <div class="text-center py-8 text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="mt-2">Belum ada riwayat top up</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($topups as $topup)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-medium text-gray-900">{{ $topup->paymentMethod->display_name }}</span>
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                @if($topup->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($topup->status === 'approved') bg-green-100 text-green-800
                                @elseif($topup->status === 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($topup->status) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">{{ $topup->created_at->format('d M Y H:i') }}</span>
                            <span class="text-xl font-bold text-indigo-600">+Rp{{ number_format($topup->amount, 0, ',', '.') }}</span>
                        </div>
                        @if ($topup->status === 'rejected' && $topup->admin_note)
                            <p class="text-sm text-red-600 mt-2">Alasan: {{ $topup->admin_note }}</p>
                        @endif
                        @if ($topup->status === 'approved' && $topup->approved_at)
                            <p class="text-xs text-gray-500 mt-2">Disetujui: {{ $topup->approved_at->format('d M Y H:i') }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
