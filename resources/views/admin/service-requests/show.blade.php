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
                    'waiting_approval' => 'bg-orange-100 text-orange-800',
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
                    @if ($serviceRequest->worker)
                        <div>
                            <dt class="text-gray-500">Pekerja</dt>
                            <dd class="font-medium">{{ $serviceRequest->worker->name }}</dd>
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
                            @if (!$serviceRequest->requiresSurveyPricing())
                                <div>
                                    <dt class="text-blue-600">Harga</dt>
                                    <dd class="font-medium">Rp{{ number_format($serviceRequest->snapshot_ac_price ?? 0, 0, ',', '.') }}</dd>
                                </div>
                            @endif
                        </div>

                        @if ($serviceRequest->requiresSurveyPricing())
                            @if ($serviceRequest->survey_reported_at)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <dt class="text-gray-500 text-sm">Survey Teknisi</dt>
                                    <dd class="mt-1 text-sm text-gray-700">Dilaporkan: {{ $serviceRequest->survey_reported_at->format('d M Y H:i') }}</dd>
                                    @if ($serviceRequest->survey_notes)
                                        <dd class="mt-2 p-3 bg-blue-50 rounded-lg text-sm">{{ $serviceRequest->survey_notes }}</dd>
                                    @endif
                                </div>
                            @else
                                <p class="mt-3 text-sm text-amber-600">Menunggu teknisi melakukan survey unit.</p>
                            @endif

                            @if ($serviceRequest->total_price)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <dt class="text-gray-500 text-sm mb-2">Harga</dt>
                                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                        <div>
                                            <dt class="text-gray-500">Harga Final</dt>
                                            <dd class="font-bold text-green-700">Rp{{ number_format($serviceRequest->total_price, 0, ',', '.') }}</dd>
                                        </div>
                                        @if ($serviceRequest->price_change_note)
                                            <div class="md:col-span-2">
                                                <dt class="text-gray-500">Catatan</dt>
                                                <dd class="mt-1 p-3 bg-amber-50 rounded-lg text-sm">{{ $serviceRequest->price_change_note }}</dd>
                                            </div>
                                        @endif
                                        @if ($serviceRequest->price_approved_at)
                                            <div>
                                                <dt class="text-gray-500">Disetujui Guest</dt>
                                                <dd class="font-medium text-green-700">{{ $serviceRequest->price_approved_at->format('d M Y H:i') }}</dd>
                                            </div>
                                        @elseif ($serviceRequest->status === 'waiting_approval')
                                            <div>
                                                <dt class="text-gray-500">Status</dt>
                                                <dd class="font-medium text-orange-600">Menunggu persetujuan guest</dd>
                                            </div>
                                        @endif
                                    </dl>
                                </div>
                            @endif
                        @endif
                    </div>
                @endif

                @if ($serviceRequest->isCleaning())
                    <div class="md:col-span-2 mt-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Detail Cleaning</h4>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <dt class="text-blue-600">Durasi</dt>
                                <dd class="font-medium">{{ $serviceRequest->cleaning_duration_hours ?? '-' }} jam</dd>
                            </div>
                            <div>
                                <dt class="text-blue-600">Harga / Jam</dt>
                                <dd class="font-medium">Rp{{ number_format($serviceRequest->snapshot_cleaning_price_per_hour ?? 0, 0, ',', '.') }}</dd>
                            </div>

                            @if ($serviceRequest->cleaningAddons->isNotEmpty())
                                <div class="md:col-span-2">
                                    <dt class="text-blue-600">Pekerjaan Tambahan</dt>
                                    <dd class="font-medium">
                                        {{ $serviceRequest->cleaningAddons->map(fn ($a) => $a->name . ' (Rp' . number_format($a->pivot->snapshot_price, 0, ',', '.') . ')')->join(', ') }}
                                    </dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-blue-600">Total Harga</dt>
                                <dd class="font-bold text-green-700">Rp{{ number_format($serviceRequest->total_price ?? 0, 0, ',', '.') }}</dd>
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
                            <dd class="font-medium">{{ \App\Models\RepairPricing::CATEGORIES[$serviceRequest->maintenanceDetail->damage_category] ?? 'Lainnya' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Tingkat Kerusakan</dt>
                            <dd class="font-medium">{{ $serviceRequest->maintenanceDetail->severity ? $serviceRequest->maintenanceDetail->severityLabel() : '-' }}</dd>
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

                    @if ($serviceRequest->survey_reported_at)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <dt class="text-gray-500 text-sm">Survey Pekerja</dt>
                            <dd class="mt-1 text-sm text-gray-700">Dilaporkan: {{ $serviceRequest->survey_reported_at->format('d M Y H:i') }}</dd>
                            @if ($serviceRequest->survey_notes)
                                <dd class="mt-2 p-3 bg-blue-50 rounded-lg text-sm">{{ $serviceRequest->survey_notes }}</dd>
                            @endif
                        </div>
                    @endif

                    @if ($serviceRequest->total_price)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <dt class="text-gray-500 text-sm mb-2">Harga</dt>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                <div>
                                    <dt class="text-gray-500">Harga Final</dt>
                                    <dd class="font-bold text-green-700">Rp{{ number_format($serviceRequest->total_price, 0, ',', '.') }}</dd>
                                </div>
                                @if ($serviceRequest->price_change_note)
                                    <div class="md:col-span-2">
                                        <dt class="text-gray-500">Alasan Perubahan Harga</dt>
                                        <dd class="mt-1 p-3 bg-amber-50 rounded-lg text-sm">{{ $serviceRequest->price_change_note }}</dd>
                                    </div>
                                @endif
                                @if ($serviceRequest->price_approved_at)
                                    <div>
                                        <dt class="text-gray-500">Disetujui Guest</dt>
                                        <dd class="font-medium text-green-700">{{ $serviceRequest->price_approved_at->format('d M Y H:i') }}</dd>
                                    </div>
                                @elseif ($serviceRequest->status === 'waiting_approval')
                                    <div>
                                        <dt class="text-gray-500">Status</dt>
                                        <dd class="font-medium text-orange-600">Menunggu persetujuan guest</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    @endif
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
                    <h3 class="font-semibold text-gray-900 mb-1">Assign Pekerja</h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Pilih satu atau lebih pekerja. Jika memilih lebih dari satu, pekerja yang pertama menekan ACC akan mendapat tugas ini.
                    </p>

                    <form method="POST" action="{{ route('admin.service-requests.assign', $serviceRequest) }}" class="space-y-4"
                          x-data="{ selected: {{ Js::from(old('worker_ids', [])) }}, total: {{ $workers->count() }},
                                    toggleAll(e) { this.selected = e.target.checked ? {{ Js::from($workers->pluck('id')->map(fn ($id) => (string) $id)->values()) }} : [] } }">
                        @csrf

                        <div>
                            <x-input-label :value="__('Pilih Pekerja')" />
                            <span class="text-red-500">*</span>

                            @if ($workers->isEmpty())
                                <p class="mt-2 text-sm text-amber-600">Belum ada pekerja yang menangani jasa ini.</p>
                            @else
                                <label class="mt-2 flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 bg-gray-50 rounded-md cursor-pointer">
                                    <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                           :checked="selected.length === total" @change="toggleAll($event)">
                                    Pilih semua pekerja
                                </label>

                                <div class="mt-2 space-y-2 max-h-72 overflow-y-auto">
                                    @foreach ($workers as $worker)
                                        <label class="flex items-center gap-3 px-3 py-2 border border-gray-200 rounded-md cursor-pointer hover:bg-gray-50">
                                            <input type="checkbox" name="worker_ids[]" value="{{ $worker->id }}"
                                                   x-model="selected"
                                                   class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            <span class="text-sm">
                                                <span class="font-medium text-gray-900">{{ $worker->name }}</span>
                                                <span class="text-gray-500">({{ $worker->phone ?? 'no phone' }})</span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                            <x-input-error :messages="$errors->get('worker_ids')" class="mt-2" />
                            <x-input-error :messages="$errors->get('worker_ids.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-3">
                            <x-primary-button x-bind:disabled="selected.length === 0">
                                Assign Pekerja
                            </x-primary-button>
                            <span class="text-sm text-gray-500" x-show="selected.length > 1" x-cloak>
                                <span x-text="selected.length"></span> pekerja dipilih — siapa cepat ACC dia yang dapat
                            </span>
                        </div>
                    </form>
                </div>

            @elseif ($serviceRequest->requiresSurveyPricing() && $serviceRequest->status === 'in_progress' && $serviceRequest->survey_reported_at && !$serviceRequest->total_price)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">
                        Set Harga {{ $serviceRequest->isMaintenance() ? 'Perbaikan' : 'AC Service' }}
                    </h3>

                    <p class="text-sm text-gray-600 mb-4">
                        Tidak ada harga acuan — tentukan harga final berdasarkan catatan survey
                        {{ $serviceRequest->isMaintenance() ? 'pekerja' : 'teknisi' }} di atas
                        ({{ $serviceRequest->isMaintenance() ? 'material & jasa' : 'sparepart & jasa' }}).
                    </p>

                    <form method="POST" action="{{ route('admin.service-requests.set-price', $serviceRequest) }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="price">
                                {{ __('Harga Final') }} <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="price" type="number" name="price" min="0" step="1000" required class="mt-1 block w-full"
                                          value="{{ old('price') }}" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="price_change_note" :value="__('Catatan Harga (rincian material/sparepart & jasa, opsional)')" />
                            <textarea name="price_change_note" id="price_change_note" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2"
                                      placeholder="Contoh: 1x kapasitor AC Rp150.000 + jasa Rp100.000">{{ old('price_change_note') }}</textarea>
                            <x-input-error :messages="$errors->get('price_change_note')" class="mt-2" />
                        </div>
                        <x-primary-button>
                            Kirim Harga ke Guest
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

            @elseif ($serviceRequest->isOpenOffer())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-1">Ditawarkan ke {{ $serviceRequest->candidates->count() }} Pekerja</h3>
                    <p class="text-gray-600 text-sm">Menunggu salah satu pekerja menekan ACC. Yang tercepat akan mendapat tugas ini.</p>

                    <div class="mt-4 space-y-2">
                        @foreach ($serviceRequest->candidates as $candidate)
                            <div class="p-3 bg-blue-50 rounded-lg">
                                <p class="font-medium text-blue-800">{{ $candidate->name }}</p>
                                <p class="text-sm text-blue-600">{{ $candidate->phone ?? 'no phone' }}</p>
                            </div>
                        @endforeach
                    </div>

                    @if ($serviceRequest->notified_at)
                        <p class="text-xs text-blue-500 mt-3">Notifikasi terkirim: {{ $serviceRequest->notified_at->format('d M Y H:i') }}</p>
                    @endif
                </div>
            @endif

            <a href="{{ route('admin.service-requests.index') }}" class="inline-block mt-6 text-indigo-600 hover:underline">← Kembali ke Daftar</a>
        </div>
    </div>
</x-app-layout>
