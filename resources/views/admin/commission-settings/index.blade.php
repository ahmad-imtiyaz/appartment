<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Setting Potongan Admin') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            @if (session('success'))
                <div class="mb-6 p-3 bg-green-50 text-green-800 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6"
                 x-data="{ percent: {{ (float) old('percentage', $setting->percentage) }} }">
                <h3 class="font-semibold text-gray-900 mb-1">Potongan dari Pendapatan Pekerja</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Persentase ini dipotong dari total setiap tugas yang selesai. Sisanya adalah bagian pekerja
                    yang nanti ditransfer admin. Perubahan hanya berlaku untuk tugas yang selesai setelah disimpan,
                    tugas yang sudah selesai tidak berubah.
                </p>

                <form method="POST" action="{{ route('admin.commission-settings.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="percentage">
                            {{ __('Persentase Potongan (%)') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <div class="mt-1 flex items-center gap-2">
                            <x-text-input id="percentage" type="number" name="percentage" min="0" max="100" step="0.01" required
                                          x-model="percent" class="block w-full" />
                            <span class="text-gray-500 font-medium">%</span>
                        </div>
                        <x-input-error :messages="$errors->get('percentage')" class="mt-2" />
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 text-sm">
                        <p class="text-gray-500 mb-2">Simulasi dari tugas Rp100.000:</p>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Potongan admin (<span x-text="percent || 0"></span>%)</span>
                            <span class="font-medium text-red-600">- Rp<span x-text="(100000 * (percent || 0) / 100).toLocaleString('id-ID')"></span></span>
                        </div>
                        <div class="flex justify-between mt-1 pt-2 border-t border-gray-200">
                            <span class="text-gray-600">Diterima pekerja</span>
                            <span class="font-bold text-green-700">Rp<span x-text="(100000 - 100000 * (percent || 0) / 100).toLocaleString('id-ID')"></span></span>
                        </div>
                    </div>

                    <x-primary-button>Simpan Potongan</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
