<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Harga Laundry') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            @if (session('success'))
                <div class="mb-6 p-3 bg-green-50 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Konfigurasi Harga</h3>

                <form method="POST" action="{{ route('admin.laundry-pricings.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="type">
                            {{ __('Jenis Layanan') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="cuci">Cuci</option>
                            <option value="cuci_setrika">Cuci + Setrika</option>
                            <option value="setrika">Setrika</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="duration">
                            {{ __('Durasi Pengerjaan') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <select name="duration" id="duration" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">
                            <option value="">-- Pilih Durasi --</option>
                            <option value="reguler">Reguler (3 Hari)</option>
                            <option value="express">Express (1 Hari)</option>
                        </select>
                        <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="price_per_kg">
                            {{ __('Harga per Kilogram') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="price_per_kg" type="number" name="price_per_kg" min="0" step="1000" required class="mt-1 block w-full" placeholder="Contoh: 15000" />
                        <x-input-error :messages="$errors->get('price_per_kg')" class="mt-2" />
                        <p class="mt-1 text-xs text-gray-500">Harga per kg, misalnya 15000 untuk Rp 15.000/kg</p>
                    </div>

                    <div class="pt-4">
                        <x-primary-button type="submit" class="w-full">
                            Simpan Harga
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <a href="{{ route('admin.laundry-pricings.index') }}" class="inline-block mt-6 text-indigo-600 hover:underline">← Kembali ke Daftar</a>
        </div>
    </div>
</x-app-layout>
