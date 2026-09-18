@extends('layouts.guest')

@section('title', $service->name)

@section('header')
    <div class="flex items-center gap-2">
        <a href="{{ route('guest.home') }}" class="text-gray-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h2 class="font-semibold text-lg text-gray-800">{{ $service->name }}</h2>
    </div>
@endsection

@section('content')
<div class="py-4 px-4 space-y-6">

    {{-- Hero header --}}
    <div class="rounded-2xl p-6 text-white" style="background: linear-gradient(135deg, #DC2626 0%, #F97316 100%);">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 3v3M16 3v3M3 9h18M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                    <circle cx="12" cy="14" r="3.2"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-lg">{{ $service->name }}</h3>
                <p class="text-sm opacity-80">{{ $service->description ?? 'Layanan terbaik untuk apartemen Anda' }}</p>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <p class="text-sm opacity-80">Balance : <span class="font-bold">Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}</span></p>
        </div>
    </div>

    {{-- Success / Error messages --}}
    @if (session('success'))
        <div class="p-3 bg-green-50 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="p-3 bg-red-50 text-red-800 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    {{-- Laundry Type/Duration Selection --}}
    @if($service->slug === 'laundry' && $laundryPricings->isNotEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-5">
            <div>
                <h3 class="font-bold text-gray-900 mb-1">Pilih Jenis Laundry</h3>
                <p class="text-xs text-gray-400">Jenis layanan cuci yang kamu inginkan</p>
            </div>

            {{-- Jenis Laundry Cards --}}
            <div class="grid grid-cols-3 gap-3">
                @php
                    $typeConfig = [
                        'cuci'       => ['label' => 'Cuci',       'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12h15m-15 6h-1.5m19.5 0h-1.5M5.25 6h13.5M5.25 12h13.5m-13.5 6h13.5"/></svg>', 'color' => 'blue'],
                        'cuci_setrika' => ['label' => 'Cuci + Setrika', 'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>', 'color' => 'indigo'],
                        'setrika'    => ['label' => 'Setrika',     'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zM8.25 6h7.5v2.25h-7.5V6zM12 3a9 9 0 100 18 9 9 0 000-18z"/></svg>', 'color' => 'purple'],
                    ];
                @endphp
                @foreach(['cuci', 'cuci_setrika', 'setrika'] as $type)
                    @php
                        $cfg = $typeConfig[$type];
                        $checked = old('laundry_type') === $type ? 'checked' : '';
                        $typeId = 'type-' . $type;
                    @endphp
                    <label class="group relative cursor-pointer" for="{{ $typeId }}">
                        <input type="radio" name="laundry_type_display" value="{{ $type }}" {{ $checked }}
    id="{{ $typeId }}"
    class="laundry-type-radio absolute opacity-0 pointer-events-none peer"
    data-type="{{ $type }}">
                        <div class="flex flex-col items-center gap-2 p-3 rounded-xl border-2 border-gray-100 bg-gray-50
                            peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:shadow-md
                            hover:border-gray-300 hover:bg-white hover:shadow-sm
                            transition-all duration-200">
                            <div class="w-10 h-10 rounded-full bg-{{ $cfg['color'] }}/10 flex items-center justify-center text-{{ $cfg['color'] }} group-hover:bg-{{ $cfg['color'] }}/20 transition-colors">
                                {!! $cfg['icon'] !!}
                            </div>
                            <span class="text-xs font-semibold text-gray-700">{{ $cfg['label'] }}</span>
                            @if($checked)
                                <div class="absolute top-1.5 right-1.5 w-4 h-4 bg-indigo-500 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>

            {{-- Durasi Section --}}
            <div class="pt-2 border-t border-gray-100">
                <div>
                    <h3 class="font-bold text-gray-900 mb-1">Pilih Durasi</h3>
                    <p class="text-xs text-gray-400">Lama pengerjaan cucian</p>
                </div>
                <div class="grid grid-cols-2 gap-3 mt-3">
                    @php
                        $durConfig = [
                            'reguler' => ['label' => 'Reguler',   'desc' => '3 Hari',  'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>', 'color' => 'emerald'],
                            'express' => ['label' => 'Express',   'desc' => '1 Hari',  'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>', 'color' => 'amber'],
                        ];
                    @endphp
                    @foreach(['reguler', 'express'] as $duration)
                        @php
                            $dcfg = $durConfig[$duration];
                            $checked = old('laundry_duration') === $duration ? 'checked' : '';
                            $durId = 'duration-' . $duration;
                        @endphp
                        <label class="group relative cursor-pointer" for="{{ $durId }}">
                            <input type="radio" name="laundry_duration_display" value="{{ $duration }}" {{ $checked }}
    id="{{ $durId }}"
    class="laundry-duration-radio absolute opacity-0 pointer-events-none peer"
    data-duration="{{ $duration }}">
                            <div class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-100 bg-gray-50
                                peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:shadow-md
                                hover:border-gray-300 hover:bg-white hover:shadow-sm
                                transition-all duration-200">
                                <div class="w-9 h-9 rounded-full bg-{{ $dcfg['color'] }}/10 flex items-center justify-center text-{{ $dcfg['color'] }}">
                                    {!! $dcfg['icon'] !!}
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-gray-800">{{ $dcfg['label'] }}</span>
                                    <p class="text-[11px] text-gray-400">{{ $dcfg['desc'] }}</p>
                                </div>
                                @if($checked)
                                    <div class="ml-auto w-4 h-4 bg-indigo-500 rounded-full flex items-center justify-center">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Price Display Box --}}
            <div id="price-info" class="hidden bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-4 border border-indigo-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-indigo-500 font-medium">Harga per Kilogram</p>
                        <p class="text-xl font-bold text-indigo-700" id="selected-price-display">Rp 0</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[11px] text-gray-400" id="selected-desc-display">Pilih jenis & durasi</p>
                        <p class="text-xs text-orange-500 font-medium mt-0.5">⚠️ Harga bisa berubah setelah ditimbang</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Cleaning Type Selection --}}
@if($service->slug === 'cleaning' && $cleaningPricings->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-5">
        <div>
            <h3 class="font-bold text-gray-900 mb-1">Pilih Jenis Cleaning</h3>
            <p class="text-xs text-gray-400">Jenis layanan cleaning yang kamu inginkan</p>
        </div>

        <div class="grid grid-cols-3 gap-3">
            @php
                $cleaningIconConfig = [
                    'cleaning-regular' => [
                        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5m4.75-11.396a24.301 24.301 0 014.5 0M14.25 3.104v5.714c0 .597.237 1.17.659 1.591L19.8 15.3m0 0a48.11 48.11 0 00-14.8 0M19.8 15.3l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" /></svg>',
                        'color' => 'purple',
                    ],
                    'cleaning-deep' => [
                        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" /></svg>',
                        'color' => 'indigo',
                    ],
                    'cleaning-postmove' => [
                        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>',
                        'color' => 'orange',
                    ],
                ];
                $preselected = old('cleaning_type') ?: request('type');
            @endphp
            @foreach($cleaningPricings as $pricing)
                @php
                    $cfg = $cleaningIconConfig[$pricing->type] ?? ['icon' => '', 'color' => 'gray'];
                    $checked = $preselected === $pricing->type ? 'checked' : '';
                    $inputId = 'cleaning-' . $pricing->type;
                @endphp
                <label class="group relative cursor-pointer" for="{{ $inputId }}">
                    <input type="radio" name="cleaning_type_display" value="{{ $pricing->type }}"
                        data-price="{{ $pricing->price }}"
                        data-label="{{ $pricing->typeLabel() }}"
                        {{ $checked }} id="{{ $inputId }}"
                        class="cleaning-type-radio absolute opacity-0 pointer-events-none peer">
                    <div class="flex flex-col items-center gap-2 p-3 rounded-xl border-2 border-gray-100 bg-gray-50
                        peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:shadow-md
                        hover:border-gray-300 hover:bg-white hover:shadow-sm
                        transition-all duration-200">
                        <div class="w-10 h-10 rounded-full bg-{{ $cfg['color'] }}/10 flex items-center justify-center text-{{ $cfg['color'] }} group-hover:bg-{{ $cfg['color'] }}/20 transition-colors">
                            {!! $cfg['icon'] !!}
                        </div>
                        <span class="text-xs font-semibold text-gray-700 text-center leading-tight">{{ $pricing->typeLabel() }}</span>
                        @if($checked)
                            <div class="absolute top-1.5 right-1.5 w-4 h-4 bg-indigo-500 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                        @endif
                    </div>
                </label>
            @endforeach
        </div>

        {{-- Price Display Box --}}
        <div id="cleaning-price-info" class="hidden bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-4 border border-indigo-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-indigo-500 font-medium">Layanan Terpilih</p>
                    <p class="text-sm font-bold text-indigo-700" id="selected-cleaning-label">-</p>
                </div>
                <p class="text-xl font-bold text-indigo-700" id="selected-cleaning-price">Rp 0</p>
            </div>
        </div>
    </div>
@endif

{{-- AC Type Selection --}}
@if($service->slug === 'ac' && $acPricings->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-5">
        <div>
            <h3 class="font-bold text-gray-900 mb-1">Pilih Jenis Layanan AC</h3>
            <p class="text-xs text-gray-400">Jenis layanan AC yang kamu inginkan</p>
        </div>

        <div class="grid grid-cols-3 gap-3">
            @php
                $acIconConfig = [
                    'ac-cleaning' => [
                        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375" /></svg>',
                        'color' => 'cyan',
                    ],
                    'ac-refill' => [
                        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v20M2 12h20" /></svg>',
                        'color' => 'sky',
                    ],
                    'ac-repair' => [
                        'icon' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877" /></svg>',
                        'color' => 'blue',
                    ],
                ];
                $preselectedAc = old('ac_type') ?: request('type');
            @endphp
            @foreach($acPricings as $pricing)
                @php
                    $cfg = $acIconConfig[$pricing->type] ?? ['icon' => '', 'color' => 'gray'];
                    $checked = $preselectedAc === $pricing->type ? 'checked' : '';
                    $inputId = 'ac-' . $pricing->type;
                @endphp
                <label class="group relative cursor-pointer" for="{{ $inputId }}">
                    <input type="radio" name="ac_type_display" value="{{ $pricing->type }}"
                        data-price="{{ $pricing->price }}"
                        data-label="{{ $pricing->typeLabel() }}"
                        {{ $checked }} id="{{ $inputId }}"
                        class="ac-type-radio absolute opacity-0 pointer-events-none peer">
                    <div class="flex flex-col items-center gap-2 p-3 rounded-xl border-2 border-gray-100 bg-gray-50
                        peer-checked:border-indigo-500 peer-checked:bg-indigo-50 peer-checked:shadow-md
                        hover:border-gray-300 hover:bg-white hover:shadow-sm
                        transition-all duration-200">
                        <div class="w-10 h-10 rounded-full bg-{{ $cfg['color'] }}/10 flex items-center justify-center text-{{ $cfg['color'] }} group-hover:bg-{{ $cfg['color'] }}/20 transition-colors">
                            {!! $cfg['icon'] !!}
                        </div>
                        <span class="text-xs font-semibold text-gray-700 text-center leading-tight">{{ $pricing->typeLabel() }}</span>
                        @if($checked)
                            <div class="absolute top-1.5 right-1.5 w-4 h-4 bg-indigo-500 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                        @endif
                    </div>
                </label>
            @endforeach
        </div>

        {{-- Price Display Box --}}
        <div id="ac-price-info" class="hidden bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-4 border border-indigo-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-indigo-500 font-medium">Layanan Terpilih</p>
                    <p class="text-sm font-bold text-indigo-700" id="selected-ac-label">-</p>
                </div>
                <p class="text-xl font-bold text-indigo-700" id="selected-ac-price">Rp 0</p>
            </div>
        </div>
    </div>
@endif

    {{-- Form Pesanan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <h3 class="font-bold text-gray-900 mb-3">Buat Pesanan</h3>
        <form method="POST" action="{{ route('guest.service-requests.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            @if ($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                    <p class="font-medium mb-1">Silakan perbaiki kesalahan berikut:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="hidden" name="service_id" value="{{ $service->id }}">

            {{-- Laundry hidden fields --}}
            @if($service->slug === 'laundry')
                <input type="hidden" name="laundry_type" id="form-laundry-type" value="{{ old('laundry_type') }}">
                <input type="hidden" name="laundry_duration" id="form-laundry-duration" value="{{ old('laundry_duration') }}">
                <input type="hidden" name="snapshot_price_per_kg" id="form-price-per-kg" value="{{ old('snapshot_price_per_kg') }}">
            @endif

            {{-- Cleaning hidden fields --}}

@if($service->slug === 'cleaning')
    <input type="hidden" name="cleaning_type" id="form-cleaning-type" value="{{ old('cleaning_type') }}">
    <input type="hidden" name="snapshot_cleaning_price" id="form-cleaning-price" value="{{ old('snapshot_cleaning_price') }}">
@endif

{{-- AC hidden fields --}}
@if($service->slug === 'ac')
    <input type="hidden" name="ac_type" id="form-ac-type" value="{{ old('ac_type') }}">
    <input type="hidden" name="snapshot_ac_price" id="form-ac-price" value="{{ old('snapshot_ac_price') }}">
@endif

            <!-- Scheduled Date -->
            <div>
                <x-input-label for="scheduled_at" :value="__('Jadwal (Opsional)')" />
                <x-text-input id="scheduled_at" type="datetime-local" name="scheduled_at" :value="old('scheduled_at')" class="mt-1 block w-full" />
                <p class="mt-1 text-xs text-gray-500">Kosongkan untuk segera diproses</p>
            </div>

            <!-- Notes -->
            <div>
                <x-input-label for="notes" :value="__('Catatan')" />
                <textarea name="notes" id="notes" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5" placeholder="Contoh: unit A-1203, kunci di lobi, dsb.">{{ old('notes') }}</textarea>
                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
            </div>

            @if ($service->slug === 'maintenance-repair')
                <div class="border-t border-gray-200 pt-4 space-y-4">
                    <h3 class="font-medium text-gray-900">Detail Maintenance & Repair</h3>

                    <div>
                        <x-input-label for="damage_category" :value="__('Kategori Kerusakan') <span class=\"text-red-500\">*</span>" />
                        <select name="damage_category" id="damage_category"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 bg-white">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="cat_luntur">Cat Luntur / Rontok</option>
                            <option value="kebocoran">Kebocoran Air / Pipa</option>
                            <option value="listrik">Kelistrikan (lampu mati, saklar, stop kontak)</option>
                            <option value="ac">AC (tidak dingin, bocor, error)</option>
                            <option value="pintu_jendela">Pintu / Jendela (sulit dibuka, kaca pecah)</option>
                            <option value="furniture">Furnitur Bawaan (rak, lemari, meja rusak)</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                        <x-input-error :messages="$errors->get('damage_category')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="location" :value="__('Lokasi Kerusakan')" />
                        <x-text-input id="location" name="location" :value="old('location')" placeholder="Contoh: Kamar mandi, dapur, AC unit 1" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="urgency" :value="__('Tingkat Urgensi')" />
                        <select name="urgency" id="urgency" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 bg-white">
                            <option value="low">Rendah (bisa ditunda)</option>
                            <option value="medium" selected>Sedang (1-2 hari)</option>
                            <option value="high">Tinggi (segera / darurat)</option>
                        </select>
                        <x-input-error :messages="$errors->get('urgency')" class="mt-2" />
                    </div>

                    <h3 class="font-medium text-gray-900 pt-2">Foto Kerusakan (Opsional, max 5)</h3>
                    <div>
                        <input type="file" name="photos[]" id="photos" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                        <p class="mt-1 text-xs text-gray-500">Maksimal 5 foto, masing-masing max 2MB</p>
                    </div>
                </div>
            @endif

            @if($service->slug === 'laundry')
                <p class="text-xs text-orange-600 bg-orange-50 p-2.5 rounded-lg">
                    ⚠️ Harga final akan ditentukan setelah Worker menimbang pakaian Anda.
                </p>
            @endif

            <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition-colors text-sm">
                Ajukan Pesanan
            </button>
        </form>
    </div>

    {{-- Daftar Pesanan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold text-gray-900">Daftar Pesanan</h3>
            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">{{ $requests->count() }} pesanan</span>
        </div>

        @if ($requests->isEmpty())
            <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <p class="mt-2 text-sm">Belum ada pesanan {{ $service->name }}</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($requests as $request)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-500">Order #{{ str_pad($request->id, 7, '0', STR_PAD_LEFT) }}</p>
                            <p class="text-sm font-medium text-gray-900">{{ $request->service->name }}</p>
                            @if($request->laundry_type)
                                <p class="text-xs text-gray-400">
                                    {{ $request->laundry_type }} / {{ $request->laundry_duration }}
                                    @if($request->billable_weight) — {{ $request->billable_weight }} kg, Rp{{ number_format($request->total_price ?? 0, 0, ',', '.') }}
                                    @endif
                                </p>
                            @endif
                            <p class="text-xs font-medium status-{{ $request->status }}">
                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                            </p>
                        </div>
                        @if (in_array($request->status, ['pending', 'assigned']))
                            <form action="{{ route('guest.service-requests.destroy', $request) }}" method="POST" class="shrink-0"
                                  onsubmit="return confirm('Batalkan pesanan #{{ $request->id }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 text-xs font-medium bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors">
                                    Batalkan
                                </button>
                            </form>
                        @else
                            <span class="shrink-0 text-xs text-gray-400">
                                @if($request->status === 'completed') Selesai
                                @else {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                @endif
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    const typeRadios = document.querySelectorAll('.laundry-type-radio');
    const durationRadios = document.querySelectorAll('.laundry-duration-radio');
    const priceInfo = document.getElementById('price-info');
    const priceDisplay = document.getElementById('selected-price-display');
    const descDisplay = document.getElementById('selected-desc-display');
    const formType = document.getElementById('form-laundry-type');
    const formDuration = document.getElementById('form-laundry-duration');
    const formPrice = document.getElementById('form-price-per-kg');

    const pricingData = @json($laundryPricings);

    const typeLabels = {
        cuci: 'Cuci',
        cuci_setrika: 'Cuci + Setrika',
        setrika: 'Setrika'
    };

    const durLabels = {
        reguler: 'Reguler (3 Hari)',
        express: 'Express (1 Hari)'
    };

    function updatePrice() {
        if (!priceInfo || !formType || !formDuration || !formPrice) return;
        const type = document.querySelector('input[name="laundry_type_display"]:checked')?.value;
const duration = document.querySelector('input[name="laundry_duration_display"]:checked')?.value;

        if (!type || !duration) {
            priceInfo.classList.add('hidden');
            formType.value = '';
            formDuration.value = '';
            formPrice.value = '';
            return;
        }

        const match = pricingData.find(
            p => p.type === type && p.duration === duration
        );

        if (match) {
            priceInfo.classList.remove('hidden');
            priceDisplay.textContent =
                'Rp ' + Number(match.price_per_kg).toLocaleString('id-ID');

            descDisplay.textContent =
                typeLabels[type] + ' • ' + durLabels[duration];

            formType.value = type;
            formDuration.value = duration;
            formPrice.value = match.price_per_kg;
        } else {
            priceInfo.classList.add('hidden');
            formType.value = '';
            formDuration.value = '';
            formPrice.value = '';
        }
    }

    typeRadios.forEach(r => {
        r.addEventListener('change', updatePrice);
    });

    durationRadios.forEach(r => {
        r.addEventListener('change', updatePrice);
    });

    // Initialize laundry saat halaman dibuka
    updatePrice();


    // ==============================
    // Cleaning selection
    // ==============================

    const cleaningRadios = document.querySelectorAll('.cleaning-type-radio');
    const formCleaningType = document.getElementById('form-cleaning-type');
    const formCleaningPrice = document.getElementById('form-cleaning-price');

    const cleaningPriceInfo = document.getElementById('cleaning-price-info');
    const cleaningLabelDisplay = document.getElementById('selected-cleaning-label');
    const cleaningPriceDisplay = document.getElementById('selected-cleaning-price');

    function updateCleaningSelection() {
        const checked = document.querySelector(
            'input[name="cleaning_type_display"]:checked'
        );

        if (
            checked &&
            formCleaningType &&
            formCleaningPrice
        ) {
            formCleaningType.value = checked.value;
            formCleaningPrice.value = checked.dataset.price;

            if (
                cleaningPriceInfo &&
                cleaningLabelDisplay &&
                cleaningPriceDisplay
            ) {
                cleaningPriceInfo.classList.remove('hidden');

                cleaningLabelDisplay.textContent =
                    checked.dataset.label;

                cleaningPriceDisplay.textContent =
                    'Rp ' +
                    Number(checked.dataset.price).toLocaleString('id-ID');
            }
        } else {
            if (cleaningPriceInfo) {
                cleaningPriceInfo.classList.add('hidden');
            }

            if (formCleaningType) {
                formCleaningType.value = '';
            }

            if (formCleaningPrice) {
                formCleaningPrice.value = '';
            }
        }
    }

    cleaningRadios.forEach(r => {
        r.addEventListener('change', updateCleaningSelection);
    });

    // Initialize cleaning saat halaman dibuka
    // termasuk ketika menggunakan old() atau ?type=
    updateCleaningSelection();

    // ==============================
// AC selection
// ==============================

const acRadios = document.querySelectorAll('.ac-type-radio');
const formAcType = document.getElementById('form-ac-type');
const formAcPrice = document.getElementById('form-ac-price');

const acPriceInfo = document.getElementById('ac-price-info');
const acLabelDisplay = document.getElementById('selected-ac-label');
const acPriceDisplay = document.getElementById('selected-ac-price');

function updateAcSelection() {
    const checked = document.querySelector('input[name="ac_type_display"]:checked');

    if (checked && formAcType && formAcPrice) {
        formAcType.value = checked.value;
        formAcPrice.value = checked.dataset.price;

        if (acPriceInfo && acLabelDisplay && acPriceDisplay) {
            acPriceInfo.classList.remove('hidden');
            acLabelDisplay.textContent = checked.dataset.label;
            acPriceDisplay.textContent = 'Rp ' + Number(checked.dataset.price).toLocaleString('id-ID');
        }
    } else {
        if (acPriceInfo) acPriceInfo.classList.add('hidden');
        if (formAcType) formAcType.value = '';
        if (formAcPrice) formAcPrice.value = '';
    }
}

acRadios.forEach(r => {
    r.addEventListener('change', updateAcSelection);
});

updateAcSelection();
</script>
@endpush
