<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Harga Repair') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Konfigurasi Harga</h3>

                <form method="POST" action="{{ route('admin.repair-pricings.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="category">
                            {{ __('Kategori Kerusakan') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <select name="category" id="category" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach (\App\Models\RepairPricing::CATEGORIES as $value => $label)
                                <option value="{{ $value }}" {{ old('category') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="severity">
                            {{ __('Tingkat Kerusakan') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <select name="severity" id="severity" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">
                            <option value="">-- Pilih Tingkat --</option>
                            @foreach (\App\Models\RepairPricing::SEVERITIES as $value => $label)
                                <option value="{{ $value }}" {{ old('severity') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('severity')" class="mt-2" />
                        <p class="mt-1 text-xs text-gray-500">Satu kategori hanya boleh punya satu harga per tingkat kerusakan.</p>
                    </div>

                    <div>
                        <x-input-label for="price">
                            {{ __('Harga') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="price" type="number" name="price" min="0" step="1000" required class="mt-1 block w-full" value="{{ old('price') }}" placeholder="Contoh: 150000" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Keterangan (Opsional)')" />
                        <textarea name="description" id="description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2" placeholder="Contoh: termasuk biaya jasa & material dasar">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div>
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="text-sm text-gray-700">Aktifkan harga ini</span>
                        </label>
                    </div>

                    <div class="pt-4">
                        <x-primary-button type="submit" class="w-full">
                            Simpan Harga
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <a href="{{ route('admin.repair-pricings.index') }}" class="inline-block mt-6 text-indigo-600 hover:underline">← Kembali ke Daftar</a>
        </div>
    </div>
</x-app-layout>
