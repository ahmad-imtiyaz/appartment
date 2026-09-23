<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Setting Penarikan Saldo') }}</h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl mx-auto">

            @if (session('success'))
                <div class="mb-6 p-3 bg-green-50 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('admin.withdrawal-settings.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="min_amount" :value="__('Minimal Penarikan (Rp)')" />
                        <x-text-input id="min_amount" type="number" name="min_amount" min="1000" step="1000" required
                                      class="mt-1 block w-full" value="{{ old('min_amount', (int) $setting->min_amount) }}" />
                        <x-input-error :messages="$errors->get('min_amount')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="fee_type" :value="__('Jenis Biaya Admin')" />
                        <select name="fee_type" id="fee_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm px-4 py-2 bg-white">
                            <option value="flat" @selected(old('fee_type', $setting->fee_type) === 'flat')>Nominal tetap (Rp)</option>
                            <option value="percent" @selected(old('fee_type', $setting->fee_type) === 'percent')>Persentase (%)</option>
                        </select>
                        <x-input-error :messages="$errors->get('fee_type')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="fee_value" :value="__('Besar Biaya Admin')" />
                        <x-text-input id="fee_value" type="number" name="fee_value" min="0" step="0.01" required
                                      class="mt-1 block w-full" value="{{ old('fee_value', (float) $setting->fee_value) }}" />
                        <p class="mt-1 text-xs text-gray-500">Isi 0 kalau tidak ada biaya admin. Berlaku untuk pengajuan baru, pengajuan lama tidak berubah.</p>
                        <x-input-error :messages="$errors->get('fee_value')" class="mt-2" />
                    </div>

                    <x-primary-button>Simpan</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
