<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Area Cleaning') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('admin.cleaning-areas.store') }}">
                    @csrf

                    <x-input-label for="name" :value="__('Nama Area (mis. Cleaning Room, Kitchen)')" />
                    <x-text-input id="name" name="name" value="{{ old('name') }}" required class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />

                    <label class="flex items-center gap-2 mt-4">
                        <input type="checkbox" name="is_active" value="1" checked
                               class="rounded border-gray-300 text-indigo-600 shadow-sm">
                        <span class="text-sm text-gray-700">Aktif</span>
                    </label>

                    <div class="flex items-center gap-3 mt-6">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('admin.cleaning-areas.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
