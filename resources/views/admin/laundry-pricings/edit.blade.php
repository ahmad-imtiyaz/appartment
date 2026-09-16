<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Harga Laundry') }}
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
                <h3 class="font-semibold text-gray-900 mb-4">Edit Harga: {{ $pricing->label() }}</h3>

                <form method="POST" action="{{ route('admin.laundry-pricings.update', $pricing) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="price_per_kg">
                            {{ __('Harga per Kilogram') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="price_per_kg" type="number" name="price_per_kg" min="0" step="1000" required class="mt-1 block w-full" value="{{ $pricing->price_per_kg }}" />
                        <x-input-error :messages="$errors->get('price_per_kg')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="is_active" :value="__('Status')" />
                        <select name="is_active" id="is_active" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">
                            <option value="1" {{ $pricing->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$pricing->is_active ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
                    </div>

                    <div class="pt-4">
                        <x-primary-button type="submit" class="w-full">
                            Simpan Perubahan
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <a href="{{ route('admin.laundry-pricings.index') }}" class="inline-block mt-6 text-indigo-600 hover:underline">← Kembali ke Daftar</a>
        </div>
    </div>
</x-app-layout>
