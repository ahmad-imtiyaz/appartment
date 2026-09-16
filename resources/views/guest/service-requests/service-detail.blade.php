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
            <a href="{{ route('guest.services.show', $service->slug) }}" class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg text-sm font-medium hover:bg-white/30 transition-colors">
                + Pesan Sekarang
            </a>
        </div>
    </div>

    {{-- Success / Error messages --}}
    @if (session('success'))
        <div class="p-3 bg-green-50 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="p-3 bg-red-50 text-red-800 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    {{-- Form Pesanan --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <h3 class="font-semibold text-gray-900 mb-3">Buat Pesanan Baru</h3>
        <form method="POST" action="{{ route('guest.service-requests.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <input type="hidden" name="service_id" value="{{ $service->id }}">

            <!-- Scheduled Date -->
            <div>
                <x-input-label for="scheduled_at" :value="__('Jadwal (Opsional)')" />
                <x-text-input id="scheduled_at" type="datetime-local" name="scheduled_at" :value="old('scheduled_at')" class="mt-1 block w-full" />
                <p class="mt-1 text-xs text-gray-500">Kosongkan untuk segera diproses</p>
            </div>

            <!-- Notes -->
            <div>
                <x-input-label for="notes" :value="__('Catatan')" />
                <textarea name="notes" id="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2" placeholder="Contoh: unit A-1203, kunci di lobi, dsb.">{{ old('notes') }}</textarea>
                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
            </div>

            @if ($service->slug === 'maintenance-repair')
                <div class="border-t border-gray-200 pt-4 space-y-4">
                    <h3 class="font-medium text-gray-900">Detail Maintenance & Repair</h3>

                    <div>
                        <x-input-label for="damage_category" :value="__('Kategori Kerusakan') <span class=\"text-red-500\">*</span>" />
                        <select name="damage_category" id="damage_category"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">
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
                        <select name="urgency" id="urgency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">
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

            <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                Ajukan Pesanan
            </button>
        </form>
    </div>

    {{-- Daftar Pesanan --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold text-gray-900">Daftar Pesanan</h3>
            <span class="text-xs text-gray-500">{{ $requests->count() }} pesanan</span>
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
