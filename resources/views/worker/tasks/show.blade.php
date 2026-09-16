<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Tugas') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
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

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900 text-lg">{{ $serviceRequest->service->name }}</h3>
                    <span class="px-3 py-1 text-sm font-medium rounded-full
                        @if($serviceRequest->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($serviceRequest->status === 'assigned') bg-blue-100 text-blue-800
                        @elseif($serviceRequest->status === 'in_progress') bg-purple-100 text-purple-800
                        @elseif($serviceRequest->status === 'completed') bg-green-100 text-green-800
                        @elseif($serviceRequest->status === 'rejected') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $serviceRequest->status)) }}
                    </span>
                </div>

                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-4">
                    <div>
                        <dt class="text-gray-500">Guest</dt>
                        <dd class="font-medium">{{ $serviceRequest->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Telepon</dt>
                        <dd class="font-medium">{{ $serviceRequest->user->phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Unit</dt>
                        <dd class="font-medium">{{ $serviceRequest->user->apartment_unit_number ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Diajukan</dt>
                        <dd class="font-medium">{{ $serviceRequest->created_at->format('d M Y H:i') }}</dd>
                    </div>
                    @if ($serviceRequest->scheduled_at)
                        <div>
                            <dt class="text-gray-500">Dijadwalkan</dt>
                            <dd class="font-medium">{{ $serviceRequest->scheduled_at->format('d M Y H:i') }}</dd>
                        </div>
                    @endif
                    @if ($serviceRequest->accepted_at)
                        <div>
                            <dt class="text-gray-500">Diterima</dt>
                            <dd class="font-medium">{{ $serviceRequest->accepted_at->format('d M Y H:i') }}</dd>
                        </div>
                    @endif
                    @if ($serviceRequest->collected_at)
                        <div>
                            <dt class="text-gray-500">Diambil</dt>
                            <dd class="font-medium">{{ $serviceRequest->collected_at->format('d M Y H:i') }}</dd>
                        </div>
                    @endif
                    @if ($serviceRequest->weighed_at)
                        <div>
                            <dt class="text-gray-500">Ditimbang</dt>
                            <dd class="font-medium">{{ $serviceRequest->weighed_at->format('d M Y H:i') }}</dd>
                        </div>
                    @endif
                    @if ($serviceRequest->completed_at)
                        <div>
                            <dt class="text-gray-500">Selesai</dt>
                            <dd class="font-medium">{{ $serviceRequest->completed_at->format('d M Y H:i') }}</dd>
                        </div>
                    @endif
                    @if ($serviceRequest->cost)
                        <div>
                            <dt class="text-gray-500">Biaya</dt>
                            <dd class="font-medium text-indigo-600">Rp{{ number_format($serviceRequest->cost, 0, ',', '.') }}</dd>
                        </div>
                    @endif
                </dl>

                @if ($serviceRequest->isLaundry())
                    <div class="mb-4 bg-blue-50 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-900 mb-2">Detail Laundry</h4>
                        <dl class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <dt class="text-blue-600">Jenis</dt>
                                <dd class="font-medium text-blue-900">{{ $serviceRequest->laundry_type }}</dd>
                            </div>
                            <div>
                                <dt class="text-blue-600">Durasi</dt>
                                <dd class="font-medium text-blue-900">{{ $serviceRequest->laundry_duration === 'reguler' ? 'Reguler (3 Hari)' : 'Express (1 Hari)' }}</dd>
                            </div>
                            <div>
                                <dt class="text-blue-600">Harga / Kg</dt>
                                <dd class="font-medium text-blue-900">Rp{{ number_format($serviceRequest->snapshot_price_per_kg ?? 0, 0, ',', '.') }}</dd>
                            </div>
                            @if($serviceRequest->billable_weight)
                                <div>
                                    <dt class="text-blue-600">Berat</dt>
                                    <dd class="font-medium text-blue-900">{{ $serviceRequest->billable_weight }} kg</dd>
                                </div>
                                <div>
                                    <dt class="text-blue-600">Total Harga</dt>
                                    <dd class="font-bold text-green-900 text-lg">Rp{{ number_format($serviceRequest->total_price ?? 0, 0, ',', '.') }}</dd>
                                </div>
                            @else
                                <div>
                                    <dt class="text-blue-600">Berat</dt>
                                    <dd class="text-orange-600">Belum ditimbang</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                @endif

                @if ($serviceRequest->notes)
                    <div class="mb-4">
                        <dt class="text-gray-500 text-sm">Catatan Guest</dt>
                        <dd class="mt-1 p-3 bg-gray-50 rounded-lg text-sm">{{ $serviceRequest->notes }}</dd>
                    </div>
                @endif

                @if ($serviceRequest->worker_notes)
                    <div class="mb-4">
                        <dt class="text-gray-500 text-sm">Catatan Anda</dt>
                        <dd class="mt-1 p-3 bg-blue-50 rounded-lg text-sm">{{ $serviceRequest->worker_notes }}</dd>
                    </div>
                @endif
            </div>

            <!-- Maintenance Details -->
            @if ($serviceRequest->maintenanceDetail)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Detail Maintenance & Repair</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500">Kategori Kerusakan</dt>
                            <dd class="font-medium">{{ $serviceRequest->maintenanceDetail->damage_category }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Lokasi</dt>
                            <dd class="font-medium">{{ $serviceRequest->maintenanceDetail->location ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Urgensi</dt>
                            <dd class="font-medium">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($serviceRequest->maintenanceDetail->urgency === 'high') bg-red-100 text-red-800
                                    @elseif($serviceRequest->maintenanceDetail->urgency === 'medium') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($serviceRequest->maintenanceDetail->urgency) }}
                                </span>
                            </dd>
                        </div>
                        @if ($serviceRequest->maintenanceDetail->description)
                            <div class="md:col-span-2">
                                <dt class="text-gray-500">Deskripsi</dt>
                                <dd class="mt-1 p-3 bg-gray-50 rounded-lg text-sm">{{ $serviceRequest->maintenanceDetail->description }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif

            <!-- Photos (Before) -->
            @if ($serviceRequest->beforePhotos->isNotEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Foto Sebelum (dari Guest)</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($serviceRequest->beforePhotos as $photo)
                            <div>
                                <a href="{{ Storage::url($photo->photo_path) }}" target="_blank">
                                    <img src="{{ Storage::url($photo->photo_path) }}" alt="Before" class="w-full h-40 object-cover rounded-lg border border-gray-200">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- ACC Button (for assigned status) -->
            @if ($serviceRequest->status === 'assigned')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <form method="POST" action="{{ route('worker.tasks.accept', $serviceRequest) }}" class="text-center">
                        @csrf
                        <p class="text-gray-600 mb-4">Tugas ini menunggu Anda menerima (ACC)</p>
                        <x-primary-button type="submit" class="w-full sm:w-auto">
                            Terima Tugas (ACC)
                        </x-primary-button>
                    </form>
                </div>
            @endif

            <!-- Weigh Form (for laundry tasks that haven't been weighed yet) -->
            @if($serviceRequest->isLaundry() && $serviceRequest->status === 'in_progress' && !$serviceRequest->weighed_at)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Timbang Pakaian</h3>
                    <form method="POST" action="{{ route('worker.tasks.weigh', $serviceRequest) }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="billable_weight" :value="__('Berat Aktual (kg)') <span class=\"text-red-500\">*</span>" />
                            <x-text-input id="billable_weight" type="number" name="billable_weight" step="0.01" min="0.01" required class="mt-1 block w-full" placeholder="Contoh: 0.5, 1.0, 2.5" />
                            <x-input-error :messages="$errors->get('billable_weight')" class="mt-2" />
                            <p class="mt-1 text-xs text-gray-500">Berat minimum dihitung sebagai 1 kg</p>
                        </div>
                        <x-primary-button type="submit" class="w-full">
                            Catat Berat & Hitung Total
                        </x-primary-button>
                    </form>
                </div>
            @endif

            <!-- Complete Form (for in_progress status) -->
            @if ($serviceRequest->status === 'in_progress')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Tandai Selesai</h3>
                    <form method="POST" action="{{ route('worker.tasks.complete', $serviceRequest) }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        @if($serviceRequest->isLaundry() && $serviceRequest->billable_weight && $serviceRequest->total_price)
                            <div class="bg-green-50 rounded-lg p-3 mb-4">
                                <p class="font-medium text-green-900">
                                    Total Harga: Rp{{ number_format($serviceRequest->total_price, 0, ',', '.') }}
                                    ({{ $serviceRequest->billable_weight }} kg × Rp{{ number_format($serviceRequest->snapshot_price_per_kg, 0, ',', '.') }}/kg)
                                </p>
                            </div>
                        @endif

                        <div>
                            <x-input-label for="worker_notes" :value="__('Catatan Pekerja')" />
                            <textarea name="worker_notes" id="worker_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2" placeholder="Catatan hasil kerjaan...">{{ old('worker_notes') }}</textarea>
                            <x-input-error :messages="$errors->get('worker_notes')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="photos" :value="__('Foto Hasil (Opsional, max 5)')" />
                            <input type="file" name="photos[]" id="photos" accept="image/*" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                            <p class="mt-1 text-xs text-gray-500">Maksimal 5 foto, masing-masing max 2MB</p>
                        </div>

                        <x-danger-button type="submit" class="w-full sm:w-auto">
                            Tandai Selesai
                        </x-danger-button>
                    </form>
                </div>
            @endif

            <!-- Photos (After) -->
            @if ($serviceRequest->afterPhotos->isNotEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Foto Hasil Kerjaan</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($serviceRequest->afterPhotos as $photo)
                            <div>
                                <a href="{{ Storage::url($photo->photo_path) }}" target="_blank">
                                    <img src="{{ Storage::url($photo->photo_path) }}" alt="After" class="w-full h-40 object-cover rounded-lg border border-gray-200">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Feedback -->
            @if ($serviceRequest->feedback)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Feedback dari Guest</h3>
                    <div class="flex items-center gap-2 mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-6 h-6 @if($i <= $serviceRequest->feedback->rating) text-yellow-400 @else text-gray-300 @endif" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    @if ($serviceRequest->feedback->comment)
                        <p class="text-gray-700">"{{ $serviceRequest->feedback->comment }}"</p>
                    @endif
                </div>
            @endif

            <a href="{{ route('worker.tasks.index') }}" class="inline-block text-indigo-600 hover:underline">← Kembali ke Daftar Tugas</a>
        </div>
    </div>
</x-app-layout>
