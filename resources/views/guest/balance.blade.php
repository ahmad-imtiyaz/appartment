@extends('layouts.guest')

@section('title', 'Saldo & Riwayat Mutasi')

@section('header')
    <h2 class="font-semibold text-lg text-gray-800">
        {{ __('Saldo & Riwayat Mutasi') }}
    </h2>
@endsection

@section('content')
    <div class="py-4 px-4">
        <!-- Current Balance Card -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-xl p-6 text-white mb-6">
            <p class="text-indigo-100 text-sm">Saldo Saat Ini</p>
            <p class="text-3xl font-bold mt-1">Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-2 gap-3 mb-6">
            <a href="{{ route('guest.topups.create') }}" class="bg-indigo-600 text-white py-3 rounded-lg text-center font-medium hover:bg-indigo-700 transition-colors">
                + Top Up
            </a>
            <a href="{{ route('guest.service-requests.create') }}" class="bg-green-600 text-white py-3 rounded-lg text-center font-medium hover:bg-green-700 transition-colors">
                Ajukan Jasa
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-800 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Mutations List -->
        @if ($mutations->isEmpty())
            <div class="text-center py-8 text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="mt-2">Belum ada riwayat mutasi saldo</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($mutations as $mutation)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                @if($mutation->type === 'credit') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $mutation->type === 'credit' ? 'Masuk' : 'Keluar' }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $mutation->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $mutation->description }}</p>
                                @if ($mutation->reference_type)
                                    <p class="text-xs text-gray-500">{{ $mutation->reference_type }} #{{ $mutation->reference_id }}</p>
                                @endif
                            </div>
                            <span class="text-lg font-bold {{ $mutation->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $mutation->type === 'credit' ? '+' : '-' }}Rp{{ number_format($mutation->amount, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="mt-2 text-right">
                            <span class="text-xs text-gray-400">Saldo: Rp{{ number_format($mutation->balance_after, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $mutations->links() }}
            </div>
        @endif
    </div>
@endsection
