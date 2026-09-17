<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Service Request') }}
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

            @php
                $statusBadgeClass = match($serviceRequest->status) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'assigned' => 'bg-blue-100 text-blue-800',
                    'in_progress' => 'bg-purple-100 text-purple-800',
                    'completed' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800',
                };
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900 text-lg">{{ $serviceRequest->service->name }}</h3>
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $statusBadgeClass }}">
                        {{ ucfirst(str_replace('_', ' ', $serviceRequest->status)) }}
                    </span>
                </div>

                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500">Guest</dt>
                        <dd class="font-medium">{{ $serviceRequest->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Email</dt>
                        <dd class="font-medium">{{ $serviceRequest->user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Telepon</dt>
                        <dd class="font-medium">{{ $serviceRequest->user->phone ?? '-' }}</dd>
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
                    @if ($serviceRequest->assigned_at)
                        <div>
                            <dt class="text-gray-500">Di-assign</dt>
                            <dd class="font-medium">{{ $serviceRequest->assigned_at->format('d M Y H:i') }}</dd>
                        </div>
                    @endif
                    @if ($serviceRequest->accepted_at)
                        <div>
                            <dt class="text-gray-500">Diterima pekerja</dt>
                            <dd class="font-medium">{{ $serviceRequest->accepted_at->format('d M Y H:i') }}</dd>
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
                    <div class="md:col-span-2 mt-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Detail Laundry</h4>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <dt class="text-blue-600">Jenis</dt>
                                <dd class="font-medium">{{ $serviceRequest->laundry_type }}</dd>
                            </div>
                            <div>
                                <dt class="text-blue-600">Durasi</dt>
                                <dd class="font-medium">{{ $serviceRequest->laundry_duration === 'reguler' ? 'Reguler (3 Hari)' : 'Express (1 Hari)' }}</dd>
                            </div>
                            <div>
                                <dt class="text-blue-600">Harga / Kg</dt>
                                <dd class="font-medium">Rp{{ number_format($serviceRequest->snapshot_price_per_kg ?? 0, 0, ',', '.') }}</dd>
                            </div>
                            @if($serviceRequest->billable_weight)
                                <div>
                                    <dt class="text-blue-600">Berat</dt>
                                    <dd class="font-medium">{{ $serviceRequest->billable_weight }} kg</dd>
                                </div>
                                <div>
                                    <dt class="text-blue-600">Total</dt>
                                    <dd class="font-bold text-green-700">Rp{{ number_format($serviceRequest->total_price, 0, ',', '.') }}</dd>
                                </div>
                            @else
                                <div>
                                    <dt class="text-blue-600">Berat</dt>
                                    <dd class="text-orange-600">Belum ditimbang</dd>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
                @if ($serviceRequest->isAc())
    <div class="md:col-span-2 mt-4">
        <h4 class="font-semibold text-gray-900 mb-2">Detail AC</h4>
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div>
                <dt class="text-blue-600">Tipe AC</dt>
                <dd class="font-medium">{{ $serviceRequest->ac_type ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-blue-600">Harga</dt>
                <dd class="font-medium">Rp{{ number_format($serviceRequest->snapshot_ac_price ?? 0, 0, ',', '.') }}</dd>
            </div>
        </div>
    </div>
@endif

@if ($serviceRequest->isCleaning())
    <div class="md:col-span-2 mt-4">
        <h4 class="font-semibold text-gray-900 mb-2">Detail Cleaning</h4>
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div>
                <dt class="text-blue-600">Tipe Cleaning</dt>
                <dd class="font-medium">{{ $serviceRequest->cleaning_type ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-blue-600">Harga</dt>
                <dd class="font-medium">Rp{{ number_format($serviceRequest->snapshot_cleaning_price ?? 0, 0, ',', '.') }}</dd>
            </div>
        </div>
    </div>
@endif

                @if ($serviceRequest->notes)
                    <div class="mt-4">
                        <dt class="text-gray-500 text-sm">Catatan Guest</dt>
                        <dd class="mt-1 p-3 bg-gray-50 rounded-lg text-sm">{{ $serviceRequest->notes }}</dd>
                    </div>
                @endif

                @if ($serviceRequest->worker_notes)
                    <div class="mt-4">
                        <dt class="text-gray-500 text-sm">Catatan Pekerja</dt>
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
                                @php
                                    $urgencyBadgeClass = match($serviceRequest->maintenanceDetail->urgency) {
                                        'high' => 'bg-red-100 text-red-800',
                                        'medium' => 'bg-yellow-100 text-yellow-800',
                                        default => 'bg-green-100 text-green-800',
                                    };
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $urgencyBadgeClass }}">
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

            <!-- Photos -->
            @if ($serviceRequest->photos->isNotEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Foto</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($serviceRequest->photos as $photo)
                            <div>
                                <p class="text-xs text-gray-500 capitalize mb-1">{{ $photo->type }}</p>
                                <a href="{{ Storage::url($photo->photo_path) }}" target="_blank">
                                    <img src="{{ Storage::url($photo->photo_path) }}" alt="{{ $photo->type }}" class="w-full h-40 object-cover rounded-lg border border-gray-200">
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

            <!-- Assign Worker Form (only for pending status) -->
            @if ($serviceRequest->status === 'pending')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Assign Pekerja</h3>
                    <form method="POST" action="{{ route('admin.service-requests.assign', $serviceRequest) }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="worker_id" :value="__('Pilih Pekerja')" />
                            <span class="text-red-500">*</span>
                            <select name="worker_id" id="worker_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">
                                <option value="">-- Pilih Pekerja --</option>
                                @foreach ($workers as $worker)
                                    <option value="{{ $worker->id }}">{{ $worker->name }} ({{ $worker->phone ?? 'no phone' }})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('worker_id')" class="mt-2" />
                        </div>
                        <x-primary-button>
                            Assign Pekerja
                        </x-primary-button>
                    </form>
                </div>
            @elseif ($serviceRequest->status === 'assigned' && $serviceRequest->worker)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Pekerja Sudah Di-assign</h3>
                    <p class="text-gray-600">Menunggu pekerja menerima tugas (ACC).</p>
                    <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                        <p class="font-medium text-blue-800">{{ $serviceRequest->worker->name }}</p>
                        <p class="text-sm text-blue-600">{{ $serviceRequest->worker->phone }}</p>
                        @if ($serviceRequest->notified_at)
                            <p class="text-xs text-blue-500 mt-1">Notifikasi terkirim: {{ $serviceRequest->notified_at->format('d M Y H:i') }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <a href="{{ route('admin.service-requests.index') }}" class="inline-block mt-6 text-indigo-600 hover:underline">← Kembali ke Daftar</a>
        </div>
    </div>
</x-app-layout>
