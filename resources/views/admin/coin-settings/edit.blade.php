<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Tier Reward Koin') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('admin.coin-settings.update', $setting) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Minimal Pengeluaran (Rp)</label>
                    <input type="number" name="min_amount" value="{{ old('min_amount', $setting->min_amount) }}" step="0.01" min="0"
                           class="w-full rounded-lg border-gray-300 shadow-sm" required>
                    @error('min_amount')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reward Koin</label>
                    <input type="number" name="coin_reward" value="{{ old('coin_reward', $setting->coin_reward) }}" min="1"
                           class="w-full rounded-lg border-gray-300 shadow-sm" required>
                    @error('coin_reward')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $setting->is_active)) id="is_active"
                           class="rounded border-gray-300">
                    <label for="is_active" class="text-sm text-gray-700">Aktif</label>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">
                        Perbarui
                    </button>
                    <a href="{{ route('admin.coin-settings.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
