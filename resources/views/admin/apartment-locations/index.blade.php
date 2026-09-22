<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Lokasi Unit & Tower') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 p-3 bg-green-50 text-green-800 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-3 bg-red-50 text-red-800 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Add Location Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 mb-8">
                <h3 class="font-semibold text-gray-900 mb-4">Tambah Lokasi Unit Baru</h3>
                <form method="POST" action="{{ route('admin.apartment-locations.store') }}" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    <div class="flex-1">
                        <x-input-label for="name" :value="__('Nama Lokasi (mis. Apartemen Sudirman Park)')" />
                        <x-text-input id="name" name="name" required class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="sm:self-end">
                        <x-primary-button class="w-full sm:w-auto justify-center">
                            Tambah Lokasi
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Locations & Towers -->
            <div class="space-y-6">
                @forelse ($locations as $location)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6">
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $location->name }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $location->towers->count() }} tower</p>
                            </div>
                            <form method="POST" action="{{ route('admin.apartment-locations.destroy', $location) }}"
                                  onsubmit="return confirm('Hapus lokasi ini beserta semua towernya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">
                                    Hapus Lokasi
                                </button>
                            </form>
                        </div>

                        <!-- Tower list -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            @forelse ($location->towers as $tower)
                                <span class="inline-flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-full pl-3 pr-1.5 py-1 text-xs text-gray-700">
                                    {{ $tower->name }}
                                    <form method="POST" action="{{ route('admin.apartment-towers.destroy', $tower) }}"
                                          onsubmit="return confirm('Hapus tower {{ $tower->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-4 h-4 flex items-center justify-center rounded-full hover:bg-red-100 text-gray-400 hover:text-red-600">
                                            &times;
                                        </button>
                                    </form>
                                </span>
                            @empty
                                <p class="text-xs text-gray-400">Belum ada tower.</p>
                            @endforelse
                        </div>

                        <!-- Add Tower Form -->
                        <form method="POST" action="{{ route('admin.apartment-locations.towers.store', $location) }}" class="flex gap-2">
                            @csrf
                            <input type="text" name="name" placeholder="Nama tower baru (mis. Tower Garnet)" required
                                   class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-3 py-2" />
                            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-gray-900">
                                Tambah Tower
                            </button>
                        </form>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center text-gray-500">
                        Belum ada data lokasi unit
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
