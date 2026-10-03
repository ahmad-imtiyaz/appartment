<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Info Jual-Beli') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 p-3 bg-green-50 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-3 bg-red-50 text-red-800 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Add/Edit Listing Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8" id="listing-form-container">
                <h3 class="font-semibold text-gray-900 mb-4" id="form-title">Tambah Listing Baru</h3>
                <form method="POST" action="{{ route('admin.product-listings.store') }}" id="listing-form" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="listing_id" id="listing_id">
                    <input type="hidden" name="_method" id="form_method" value="POST">

                    <div>
                        <x-input-label for="title">Judul <span class="text-red-500">*</span></x-input-label>
                        <x-text-input id="title" name="title" required class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Deskripsi')" />
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2"></textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="price" :value="__('Harga / Harga Minimum')" />
                            <x-text-input id="price" type="number" name="price" min="0" step="1000" class="mt-1 block w-full" placeholder="Contoh: 100000000" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="price_max" :value="__('Harga Maksimum (opsional)')" />
                            <x-text-input id="price_max" type="number" name="price_max" min="0" step="1000" class="mt-1 block w-full" placeholder="Contoh: 200000000" />
                            <x-input-error :messages="$errors->get('price_max')" class="mt-2" />
                        </div>
                    </div>
                    <p class="-mt-2 text-xs text-gray-500">
                        Isi harga minimum saja untuk harga tunggal, isi keduanya untuk harga range (mis. 100.000.000 - 200.000.000). Kosongkan keduanya jika gratis/negotiable.
                    </p>

                    <div>
                        <x-input-label for="category" :value="__('Kategori')" />
                        <x-text-input id="category" name="category" class="mt-1 block w-full" placeholder="Contoh: Furniture, Elektronik, Kendaraan" />
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="contact_info">Kontak <span class="text-red-500">*</span></x-input-label>
                        <x-text-input id="contact_info" name="contact_info" required class="mt-1 block w-full" placeholder="No. WA/Telepon/Email" />
                        <x-input-error :messages="$errors->get('contact_info')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="image" :value="__('Gambar')" />
                        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        <p class="mt-1 text-xs text-gray-500">Format: JPG/PNG, maksimal 2MB</p>
                    </div>
                    <div id="image-preview" class="hidden">
                        <p class="text-sm text-gray-500">Preview saat ini:</p>
                        <img id="preview-img" src="" alt="Preview" class="mt-2 max-w-xs rounded-lg border border-gray-200">
                    </div>

                    <div>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-sm text-gray-700">Aktif (ditampilkan ke publik)</span>
                        </label>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <x-secondary-button type="button" onclick="resetForm()" id="cancel-btn" class="hidden">
                            Batal
                        </x-secondary-button>
                        <x-primary-button type="submit" id="submit-btn">
                            Simpan
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Listings Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @if ($listings->isEmpty())
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada info jual-beli</td>
                                </tr>
                            @else
                                @foreach ($listings as $listing)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($listing->image)
                                                <img src="{{ Storage::url($listing->image) }}" alt="{{ $listing->title }}" class="w-16 h-16 object-cover rounded">
                                            @else
                                                <div class="w-16 h-16 bg-gray-100 rounded flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $listing->title }}</div>
                                            @if ($listing->description)
                                                <div class="text-sm text-gray-500 line-clamp-1">{{ $listing->description }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($listing->category)
                                                <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">{{ $listing->category }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($listing->price_label)
                                                <span class="font-medium text-indigo-600">{{ $listing->price_label }}</span>
                                            @else
                                                <span class="text-gray-400">Gratis/Negotiable</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $listing->contact_info }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                                @if($listing->is_active) bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $listing->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <button type="button"
                                                onclick="editListing({{ Js::from([
                                                    'id' => $listing->id,
                                                    'title' => $listing->title,
                                                    'description' => $listing->description,
                                                    'price' => $listing->price ? (int) $listing->price : null,
                                                    'price_max' => $listing->price_max ? (int) $listing->price_max : null,
                                                    'category' => $listing->category,
                                                    'contact_info' => $listing->contact_info,
                                                    'image' => $listing->image ? Storage::url($listing->image) : '',
                                                    'is_active' => (bool) $listing->is_active,
                                                ]) }})"
                                                class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                            <form method="POST" action="{{ route('admin.product-listings.destroy', $listing) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus listing ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editListing(d) {
            document.getElementById('listing_id').value = d.id;
            document.getElementById('title').value = d.title ?? '';
            document.getElementById('description').value = d.description ?? '';
            document.getElementById('price').value = d.price ?? '';
            document.getElementById('price_max').value = d.price_max ?? '';
            document.getElementById('category').value = d.category ?? '';
            document.getElementById('contact_info').value = d.contact_info ?? '';
            document.getElementById('is_active').checked = d.is_active;
            document.getElementById('form_method').value = 'PUT';
            document.getElementById('form-title').textContent = 'Edit Listing';
            document.getElementById('submit-btn').textContent = 'Update';
            document.getElementById('cancel-btn').classList.remove('hidden');

            const form = document.getElementById('listing-form');
            form.action = `{{ route('admin.product-listings.update', ':id') }}`.replace(':id', d.id);

            const preview = document.getElementById('image-preview');
            const img = document.getElementById('preview-img');
            if (d.image) {
                img.src = d.image;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }

            document.getElementById('listing-form-container').scrollIntoView({ behavior: 'smooth' });
        }

        function resetForm() {
            document.getElementById('listing-form').reset();
            document.getElementById('listing_id').value = '';
            document.getElementById('form_method').value = 'POST';
            document.getElementById('form-title').textContent = 'Tambah Listing Baru';
            document.getElementById('submit-btn').textContent = 'Simpan';
            document.getElementById('cancel-btn').classList.add('hidden');
            document.getElementById('image-preview').classList.add('hidden');
            document.getElementById('listing-form').action = '{{ route('admin.product-listings.store') }}';
        }

        // Image preview for create/edit
        document.getElementById('image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById('image-preview');
            const img = document.getElementById('preview-img');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (ev) {
                    img.src = ev.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
