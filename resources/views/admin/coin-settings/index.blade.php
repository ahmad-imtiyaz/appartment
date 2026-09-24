<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Setting Poin') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            @if (session('success'))
                <div class="mb-6 p-3 bg-green-50 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <p class="text-sm text-gray-500 mb-5">
                Setiap kelipatan nominal di bawah ini memberi guest sejumlah poin,
                dihitung otomatis setelah semua layanan yang dipilih selesai.
            </p>

            <form action="{{ route('admin.coin-settings.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelipatan Pengeluaran (Rp)</label>
                    <input type="number" name="increment_amount" value="{{ old('increment_amount', $setting->increment_amount) }}" step="1" min="1"
                           class="w-full rounded-lg border-gray-300 shadow-sm" required>
                    <p class="text-xs text-gray-400 mt-1">Contoh: 50.000 berarti tiap kelipatan Rp50rb dari total jasa.</p>
                    @error('increment_amount')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Poin per Kelipatan</label>
                    <input type="number" name="points_per_increment" value="{{ old('points_per_increment', $setting->points_per_increment) }}" min="1"
                           class="w-full rounded-lg border-gray-300 shadow-sm" required>
                    @error('points_per_increment')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
