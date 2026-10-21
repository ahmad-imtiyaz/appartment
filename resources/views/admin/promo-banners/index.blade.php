<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Banner Promosi') }}
        </h2>
    </x-slot>

    @php
        $sizeLabel = \App\Models\PromoBanner::WIDTH . ' × ' . \App\Models\PromoBanner::HEIGHT . ' px';
    @endphp

    <style>[x-cloak]{display:none !important;}</style>

    <div class="py-8 px-4 sm:px-6 lg:px-8" x-data="{ edit: null }">
        <div class="max-w-5xl mx-auto">

            @if (session('success'))
                <div class="mb-6 p-3 bg-green-50 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-6 p-3 bg-red-50 text-red-800 rounded-lg text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Tambah Banner -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
                <h3 class="font-semibold text-gray-900">Tambah Banner</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Banner tampil di beranda guest, setelah bagian Jual & Beli.
                    Ukuran gambar wajib <strong>{{ $sizeLabel }}</strong> (rasio 3:1), maks. 2 MB.
                </p>

                <form method="POST" action="{{ route('admin.promo-banners.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="title">Judul <span class="text-red-500">*</span></x-input-label>
                        <x-text-input id="title" name="title" required class="mt-1 block w-full" :value="old('title')" placeholder="Contoh: Promo Cuci AC Oktober" />
                        <p class="mt-1 text-xs text-gray-500">Untuk penanda di admin, tidak tampil di gambar.</p>
                    </div>

                    <div>
                        <x-input-label for="image">Gambar ({{ $sizeLabel }}) <span class="text-red-500">*</span></x-input-label>
                        <input type="file" name="image" id="image" accept="image/*" required
                               class="mt-1 block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:bg-gray-100 file:text-gray-700">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <x-input-label for="link_url" :value="__('Link saat diklik (opsional)')" />
                            <x-text-input id="link_url" name="link_url" type="url" class="mt-1 block w-full" :value="old('link_url')" placeholder="https://wa.me/628123456789" />
                        </div>
                        <div>
                            <x-input-label for="sort_order" :value="__('Urutan')" />
                            <x-text-input id="sort_order" name="sort_order" type="number" min="0" class="mt-1 block w-full" :value="old('sort_order', 0)" />
                        </div>
                    </div>

                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        Tampilkan di beranda
                    </label>

                    <div>
                        <x-primary-button>Simpan Banner</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Daftar Banner -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Daftar Banner ({{ $banners->count() }})</h3>

                @forelse ($banners as $banner)
                    <div class="py-4 flex flex-col md:flex-row gap-4 {{ $loop->first ? '' : 'border-t border-gray-100' }}">
                        <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}"
                             class="w-full md:w-72 aspect-[3/1] object-cover rounded-lg border border-gray-100 {{ $banner->is_active ? '' : 'opacity-50' }}">

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <p class="font-medium text-gray-900 truncate">{{ $banner->title }}</p>
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $banner->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $banner->is_active ? 'Tampil' : 'Disembunyikan' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Urutan: {{ $banner->sort_order }}</p>
                            @if ($banner->link_url)
                                <a href="{{ $banner->link_url }}" target="_blank" class="text-sm text-indigo-600 hover:underline break-all">{{ $banner->link_url }}</a>
                            @else
                                <p class="text-sm text-gray-400">Tanpa link</p>
                            @endif

                            <div class="mt-3 flex gap-4 text-sm">
                                <button type="button" class="text-indigo-600 hover:text-indigo-900 font-medium"
                                        @click="edit = {{ Js::from([
                                            'action' => route('admin.promo-banners.update', $banner),
                                            'title' => $banner->title,
                                            'link_url' => $banner->link_url,
                                            'sort_order' => $banner->sort_order,
                                            'is_active' => $banner->is_active,
                                        ]) }}">
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('admin.promo-banners.destroy', $banner) }}"
                                      onsubmit="return confirm('Hapus banner ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="py-6 text-center text-gray-500">Belum ada banner promosi.</p>
                @endforelse
            </div>
        </div>

        <!-- Modal Edit -->
        <template x-if="edit">
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4"
             @keydown.escape.window="edit = null">
            <div class="bg-white rounded-xl p-6 w-full max-w-lg" @click.outside="edit = null">
                <h3 class="font-semibold text-lg text-gray-900 mb-4">Edit Banner</h3>

                <form method="POST" :action="edit?.action" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="edit_title">Judul <span class="text-red-500">*</span></x-input-label>
                        <input id="edit_title" name="title" required x-model="edit.title"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm px-4 py-2">
                    </div>

                    <div>
                        <x-input-label for="edit_image">Ganti Gambar ({{ $sizeLabel }}, opsional)</x-input-label>
                        <input type="file" name="image" id="edit_image" accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:bg-gray-100 file:text-gray-700">
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <x-input-label for="edit_link_url" :value="__('Link (opsional)')" />
                            <input id="edit_link_url" name="link_url" type="url" x-model="edit.link_url"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm px-4 py-2">
                        </div>
                        <div>
                            <x-input-label for="edit_sort_order" :value="__('Urutan')" />
                            <input id="edit_sort_order" name="sort_order" type="number" min="0" x-model="edit.sort_order"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm px-4 py-2">
                        </div>
                    </div>

                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="is_active" value="1" x-model="edit.is_active" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        Tampilkan di beranda
                    </label>

                    <div class="flex justify-end gap-3">
                        <x-secondary-button type="button" @click="edit = null">Batal</x-secondary-button>
                        <x-primary-button>Simpan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
        </template>
    </div>
</x-app-layout>
