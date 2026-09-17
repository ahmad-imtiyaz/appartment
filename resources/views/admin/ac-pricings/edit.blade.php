<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Harga AC Service') }}
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

                <form method="POST" action="{{ route('admin.ac-pricings.update', $pricing) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="type">
                            {{ __('Jenis AC Service') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <select name="type" id="type" disabled class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm sm:text-sm px-4 py-2 text-gray-700">
                            <option value="{{ $pricing->type }}" selected>{{ $pricing->typeLabel() }}</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Jenis tidak bisa diubah. Ubah harga atau statusnya saja.</p>
                    </div>

                    <div>
                        <x-input-label for="price">
                            {{ __('Harga per Sesi') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="price" type="number" name="price" min="0" step="1000" required class="mt-1 block w-full" placeholder="Contoh: 150000" value="{{ old('price', $pricing->price) }}" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        <p class="mt-1 text-xs text-gray-500">Harga per sesi, misalnya 150000 untuk Rp 150.000/sesi</p>
                    </div>

                    <div>
                        <label for="is_active" class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="is_active" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                   @checked(old('is_active', $pricing->is_active))>
                            <span class="text-sm font-medium text-gray-700">Harga aktif</span>
                        </label>
                        <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
                    </div>

                    <div class="pt-4">
                        <x-primary-button type="submit" class="w-full">
                            Simpan Perubahan
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <a href="{{ route('admin.ac-pricings.index') }}" class="inline-block mt-6 text-indigo-600 hover:underline">← Kembali ke Daftar</a>
        </div>
    </div>
</x-app-layout>
