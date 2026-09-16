<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Metode Pembayaran') }}
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

            <!-- Add Payment Method Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
                <h3 class="font-semibold text-gray-900 mb-4">Tambah Metode Pembayaran</h3>
                <form method="POST" action="{{ route('admin.payment-methods.store') }}" enctype="multipart/form-data" class="space-y-4" id="payment-method-form">
                    @csrf
                    <div>
                        <x-input-label for="type" :value="__('Tipe') <span class=\"text-red-500\">*</span>" />
                        <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white" onchange="toggleFields(this.value)">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="display_name" :value="__('Nama Tampilan') <span class=\"text-red-500\">*</span>" />
                        <x-text-input id="display_name" name="display_name" required class="mt-1 block w-full" placeholder="Contoh: BCA - Apartemen" />
                        <x-input-error :messages="$errors->get('display_name')" class="mt-2" />
                    </div>

                    <!-- Bank Transfer Fields -->
                    <div id="bank-fields" class="hidden space-y-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="bank_name" :value="__('Nama Bank')" />
                            <x-text-input id="bank_name" name="bank_name" class="mt-1 block w-full" placeholder="Contoh: BCA" />
                            <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="account_number" :value="__('No. Rekening')" />
                            <x-text-input id="account_number" name="account_number" class="mt-1 block w-full" placeholder="Contoh: 1234567890" />
                            <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="account_holder_name" :value="__('Atas Nama')" />
                            <x-text-input id="account_holder_name" name="account_holder_name" class="mt-1 block w-full" placeholder="Contoh: PT Apartemen Sejahtera" />
                            <x-input-error :messages="$errors->get('account_holder_name')" class="mt-2" />
                        </div>
                    </div>

                    <!-- QRIS Fields -->
                    <div id="qris-fields" class="hidden space-y-4">
                        <div>
                            <x-input-label for="qr_image" :value="__('Gambar QR Code')" />
                            <input type="file" name="qr_image" id="qr_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('qr_image')" class="mt-2" />
                            <p class="mt-1 text-xs text-gray-500">Format: JPG/PNG, maksimal 2MB</p>
                        </div>
                        <div id="qr-preview" class="hidden">
                            <p class="text-sm text-gray-500">Preview:</p>
                            <img id="qr-preview-img" src="" alt="QR Preview" class="mt-2 max-w-xs rounded-lg border border-gray-200">
                        </div>
                    </div>

                    <div>
                        <x-primary-button>
                            Simpan Metode Pembayaran
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Payment Methods List -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @if ($paymentMethods->isEmpty())
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada metode pembayaran</td>
                                </tr>
                            @else
                                @foreach ($paymentMethods as $method)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-medium text-gray-900">{{ $method->display_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                @if($method->type === 'bank_transfer') bg-blue-100 text-blue-800
                                                @else bg-green-100 text-green-800 @endif">
                                                {{ $method->type === 'bank_transfer' ? 'Transfer Bank' : 'QRIS' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            @if ($method->type === 'bank_transfer')
                                                {{ $method->bank_name }} - {{ $method->account_number }}<br>
                                                a/n {{ $method->account_holder_name }}
                                            @else
                                                @if ($method->qr_image)
                                                    <img src="{{ Storage::url($method->qr_image) }}" alt="QR" class="w-20 h-20 object-cover rounded">
                                                @else
                                                    <span class="text-gray-400">Belum upload QR</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                @if($method->is_active) bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $method->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <button onclick="openEditModal({{ $method->id }}, '{{ $method->display_name }}', '{{ $method->type }}', '{{ $method->bank_name ?? '' }}', '{{ $method->account_number ?? '' }}', '{{ $method->account_holder_name ?? '' }}', '{{ $method->qr_image ? Storage::url($method->qr_image) : '' }}', {{ $method->is_active ? 'true' : 'false' }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                            <form method="POST" action="{{ route('admin.payment-methods.destroy', $method) }}" class="inline" onsubmit="return confirm('Yakin ingin menonaktifkan metode ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Nonaktifkan</button>
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

    <!-- Edit Modal -->
    <div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
            <h3 class="font-semibold text-lg text-gray-900 mb-4">Edit Metode Pembayaran</h3>
            <form method="POST" id="edit-form" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="payment_method_id" id="edit-id">
                
                <div>
                    <x-input-label for="edit_display_name" :value="__('Nama Tampilan') <span class=\"text-red-500\">*</span>" />
                    <x-text-input id="edit_display_name" name="display_name" required class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('display_name')" class="mt-2" />
                </div>

                <div id="edit-bank-fields" class="hidden space-y-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="edit_bank_name" :value="__('Nama Bank')" />
                        <x-text-input id="edit_bank_name" name="bank_name" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="edit_account_number" :value="__('No. Rekening')" />
                        <x-text-input id="edit_account_number" name="account_number" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="edit_account_holder_name" :value="__('Atas Nama')" />
                        <x-text-input id="edit_account_holder_name" name="account_holder_name" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('account_holder_name')" class="mt-2" />
                    </div>
                </div>

                <div id="edit-qris-fields" class="hidden space-y-4">
                    <div>
                        <x-input-label for="edit_qr_image" :value="__('Gambar QR Code') (kosongkan jika tidak diubah)" />
                        <input type="file" name="qr_image" id="edit_qr_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        <x-input-error :messages="$errors->get('qr_image')" class="mt-2" />
                    </div>
                    <div id="edit-qr-preview" class="hidden">
                        <p class="text-sm text-gray-500">Preview saat ini:</p>
                        <img id="edit-qr-preview-img" src="" alt="QR Preview" class="mt-2 max-w-xs rounded-lg border border-gray-200">
                    </div>
                </div>

                <div>
                    <x-input-label for="edit_is_active" :value="__('Status')" />
                    <select name="is_active" id="edit_is_active" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <x-secondary-button type="button" onclick="closeEditModal()">
                        Batal
                    </x-secondary-button>
                    <x-primary-button type="submit">
                        Simpan
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleFields(type) {
            const bankFields = document.getElementById('bank-fields');
            const qrisFields = document.getElementById('qris-fields');
            
            if (type === 'bank_transfer') {
                bankFields.classList.remove('hidden');
                qrisFields.classList.add('hidden');
                document.getElementById('bank_name').required = true;
                document.getElementById('account_number').required = true;
                document.getElementById('account_holder_name').required = true;
                document.getElementById('qr_image').required = false;
            } else if (type === 'qris') {
                bankFields.classList.add('hidden');
                qrisFields.classList.remove('hidden');
                document.getElementById('bank_name').required = false;
                document.getElementById('account_number').required = false;
                document.getElementById('account_holder_name').required = false;
                document.getElementById('qr_image').required = true;
            } else {
                bankFields.classList.add('hidden');
                qrisFields.classList.add('hidden');
            }
        }

        function openEditModal(id, displayName, type, bankName, accountNumber, accountHolderName, qrImage, isActive) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit_display_name').value = displayName;
            document.getElementById('edit_is_active').value = isActive ? '1' : '0';
            
            const editForm = document.getElementById('edit-form');
            editForm.action = `{{ route('admin.payment-methods.update', ':id') }}`.replace(':id', id);
            
            const bankFields = document.getElementById('edit-bank-fields');
            const qrisFields = document.getElementById('edit-qris-fields');
            
            if (type === 'bank_transfer') {
                bankFields.classList.remove('hidden');
                qrisFields.classList.add('hidden');
                document.getElementById('edit_bank_name').value = bankName;
                document.getElementById('edit_account_number').value = accountNumber;
                document.getElementById('edit_account_holder_name').value = accountHolderName;
            } else if (type === 'qris') {
                bankFields.classList.add('hidden');
                qrisFields.classList.remove('hidden');
                if (qrImage) {
                    document.getElementById('edit-qr-preview-img').src = qrImage;
                    document.getElementById('edit-qr-preview').classList.remove('hidden');
                } else {
                    document.getElementById('edit-qr-preview').classList.add('hidden');
                }
            }
            
            document.getElementById('edit-modal').classList.remove('hidden');
            document.getElementById('edit-modal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
            document.getElementById('edit-modal').classList.remove('flex');
        }

        // QR Preview for create form
        document.getElementById('qr_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('qr-preview');
            const img = document.getElementById('qr-preview-img');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
        });

        // Close modal on outside click
        document.getElementById('edit-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>
</x-app-layout>