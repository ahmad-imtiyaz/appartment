<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Harga Cleaning') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg mx-auto">
            @if (session('success'))
                <div class="mb-6 p-3 bg-green-50 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <p class="text-sm text-gray-500 mb-4">
                    Cleaning pakai 1 tarif flat per jam yang berlaku untuk semua guest.
                </p>

                <form method="POST" action="{{ route('admin.cleaning-pricings.update') }}">
                    @csrf
                    @method('PUT')

                    <x-input-label for="price_per_hour" :value="__('Harga per Jam (Rp)')" />
                    <x-text-input id="price_per_hour" name="price_per_hour" type="number" step="0.01" min="0"
                        value="{{ old('price_per_hour', $pricing->price_per_hour ?? '') }}"
                        required class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('price_per_hour')" class="mt-2" />

                    <x-primary-button class="mt-6">
                        Simpan
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
