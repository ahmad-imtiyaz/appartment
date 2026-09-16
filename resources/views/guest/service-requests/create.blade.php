@extends('layouts.guest')

@section('title', 'Ajukan Jasa Baru')

@section('header')
    <h2 class="font-semibold text-lg text-gray-800">
        {{ __('Ajukan Jasa Baru') }}
    </h2>
@endsection

@section('content')
    <div class="py-4 px-4">
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

        <form method="POST" action="{{ route('guest.service-requests.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Service Selection -->
            <div>
                <x-input-label for="service_id" :value="__('Jenis Jasa')" />
                <select name="service_id" id="service_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">
                    <option value="">-- Pilih Jasa --</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" data-slug="{{ $service->slug }}" data-price="{{ $service->base_price }}">
                            {{ $service->name }} @if($service->base_price) - Rp{{ number_format($service->base_price, 0, ',', '.') }} @else - Harga custom @endif
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('service_id')" class="mt-2" />
            </div>

            <!-- Scheduled Date -->
            <div>
                <x-input-label for="scheduled_at" :value="__('Jadwal (Opsional')" />
                <x-text-input id="scheduled_at" type="datetime-local" name="scheduled_at" :value="old('scheduled_at')" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500">Kosongkan untuk segera diproses</p>
            </div>

            <!-- Notes -->
            <div>
                <x-input-label for="notes" :value="__('Catatan')" />
                <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2" placeholder="Contoh: unit A-1203, kunci di lobi, dsb.">{{ old('notes') }}</textarea>
                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
            </div>

            <!-- Maintenance & Repair Specific Fields (hidden by default) -->
            <div id="maintenance-fields" class="hidden space-y-4 border-t border-gray-200 pt-4">
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
            </div>

            <!-- Photos Upload (for maintenance before photos) -->
            <div id="photos-fields" class="hidden space-y-4 border-t border-gray-200 pt-4">
                <h3 class="font-medium text-gray-900">Foto Kerusakan (Opsional, max 5)</h3>
                <div>
                    <input type="file" name="photos[]" id="photos" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                    <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                    <p class="mt-1 text-xs text-gray-500">Maksimal 5 foto, masing-masing max 2MB</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                    Ajukan Permintaan
                </button>
            </div>
        </form>
    </div>

    <script>
        const serviceSelect = document.getElementById('service_id');
        const maintenanceFields = document.getElementById('maintenance-fields');
        const photosFields = document.getElementById('photos-fields');
        const damageCategory = document.getElementById('damage_category');

        serviceSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const slug = selectedOption.dataset.slug;
            const isMaintenance = slug === 'maintenance-repair';

            maintenanceFields.classList.toggle('hidden', !isMaintenance);
            photosFields.classList.toggle('hidden', !isMaintenance);

            damageCategory.required = isMaintenance;
        });
    </script>
@endsection
