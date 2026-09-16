@extends('layouts.guest')

@section('title', 'Permintaan Jasa')

@section('header')
    <h2 class="font-semibold text-lg text-gray-800">
        {{ __('Permintaan Jasa') }}
    </h2>
@endsection

@section('content')
    <div class="py-4 px-4">
        <a href="{{ route('guest.service-requests.create') }}"
           class="block w-full mb-4 px-4 py-3 bg-indigo-600 text-white text-center rounded-lg font-medium hover:bg-indigo-700 transition-colors">
            + Ajukan Jasa Baru
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

        @if ($requests->isEmpty())
            <div class="text-center py-8 text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <p class="mt-2">Belum ada permintaan jasa</p>
                <a href="{{ route('guest.service-requests.create') }}" class="text-indigo-600 hover:underline mt-2 inline-block">Ajukan sekarang</a>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($requests as $request)
                    <a href="{{ route('guest.service-requests.show', $request) }}" class="block">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($request->status === 'assigned') bg-blue-100 text-blue-800
                                            @elseif($request->status === 'in_progress') bg-purple-100 text-purple-800
                                            @elseif($request->status === 'completed') bg-green-100 text-green-800
                                            @elseif($request->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                        </span>
                                        <span class="text-xs text-gray-500">{{ $request->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    <h3 class="font-semibold text-gray-900">{{ $request->service->name }}</h3>
                                    @if ($request->notes)
                                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $request->notes }}</p>
                                    @endif
                                    @if ($request->worker)
                                        <p class="text-xs text-gray-500 mt-2">Pekerja: {{ $request->worker->name }}</p>
                                    @endif
                                    @if ($request->cost)
                                        <p class="text-sm font-semibold text-indigo-600 mt-2">Biaya: Rp{{ number_format($request->cost, 0, ',', '.') }}</p>
                                    @endif
                                </div>
                                <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>

                            @if ($request->status === 'completed' && !$request->feedback)
                                <div class="mt-3 pt-3 border-t border-gray-100">
                                    <a href="{{ route('guest.service-requests.show', $request) }}#feedback"
                                       class="text-sm text-indigo-600 font-medium">Beri Feedback →</a>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
