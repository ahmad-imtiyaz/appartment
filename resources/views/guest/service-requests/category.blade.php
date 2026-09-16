@extends('layouts.guest')

@section('title', $category['title'])

@section('header')
    <div class="flex items-center gap-2">
        <a href="{{ route('guest.service-requests.index') }}" class="text-gray-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h2 class="font-semibold text-lg text-gray-800">{{ $category['title'] }}</h2>
    </div>
@endsection

@section('content')
    <div class="py-4 px-4 space-y-6">

        <!-- Sub layanan grid -->
        <div>
            <div class="grid grid-cols-3 gap-3">
                @foreach ($category['options'] as $option)
                    <a href="{{ route('guest.services.show', $category['slug']) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-3 flex flex-col items-center gap-2 hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 {{ $category['bg'] }} rounded-lg flex items-center justify-center">
                            {!! $option['icon'] !!}
                        </div>
                        <span class="text-xs font-medium text-gray-700 text-center leading-tight">{{ $option['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Active orders khusus kategori ini -->
        <div>
            <h3 class="font-semibold text-gray-900 mb-3">Pesanan {{ $category['title'] }} Aktif</h3>

            @if ($activeRequests->isEmpty())
                <div class="text-center py-8 text-gray-500 bg-white rounded-xl border border-dashed border-gray-200">
                    <p class="text-sm">Belum ada pesanan {{ strtolower($category['title']) }}</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($activeRequests as $request)
                        <a href="{{ route('guest.service-requests.show', $request) }}" class="block">
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-3 hover:shadow-md transition-shadow">
                                <div class="w-10 h-10 {{ $category['bg'] }} rounded-lg flex items-center justify-center shrink-0">
                                    {!! $category['options'][0]['icon'] !!}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-gray-500">Order #{{ str_pad($request->id, 7, '0', STR_PAD_LEFT) }}</p>
                                    <h4 class="font-medium text-gray-900 truncate">{{ $request->service->name }}</h4>
                                </div>
                                <span class="shrink-0 px-2 py-1 text-xs font-medium rounded-full
                                    @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($request->status === 'in_progress') bg-purple-100 text-purple-800
                                    @elseif($request->status === 'completed') bg-green-100 text-green-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <a href="{{ route('guest.services.show', $category['slug']) }}"
           class="block w-full px-4 py-3 bg-indigo-600 text-white text-center rounded-lg font-medium hover:bg-indigo-700 transition-colors">
            + Ajukan {{ $category['title'] }} Baru
        </a>

    </div>
@endsection
