@extends('layouts.guest')

@section('title', 'Detail Permintaan')

@section('header')
    <h2 class="font-semibold text-lg text-gray-800">
        {{ __('Detail Permintaan') }}
    </h2>
@endsection

@section('content')
    <div class="py-4 px-4">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-800 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-gray-900">{{ $serviceRequest->service->name }}</h3>
                <span class="px-2 py-1 text-xs font-medium rounded-full
                    @if($serviceRequest->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($serviceRequest->status === 'assigned') bg-blue-100 text-blue-800
                    @elseif($serviceRequest->status === 'in_progress') bg-purple-100 text-purple-800
                    @elseif($serviceRequest->status === 'waiting_approval') bg-orange-100 text-orange-800
                    @elseif($serviceRequest->status === 'completed') bg-green-100 text-green-800
                    @elseif($serviceRequest->status === 'rejected') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst(str_replace('_', ' ', $serviceRequest->status)) }}
                </span>
            </div>

            <dl class="space-y-3 text-sm">
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
                @if ($serviceRequest->worker)
                    <div>
                        <dt class="text-gray-500">Pekerja</dt>
                        <dd class="font-medium">{{ $serviceRequest->worker->name }} ({{ $serviceRequest->worker->phone }})</dd>
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
                @if ($serviceRequest->total_price)
                    <div>
                        <dt class="text-gray-500">Biaya</dt>
                         <dd class="font-medium text-indigo-600">Rp{{ number_format($serviceRequest->total_price, 0, ',', '.') }}</dd>
                    </div>
                @endif
            </dl>

            @if ($serviceRequest->notes)
                <div class="mt-4">
                    <dt class="text-gray-500 text-sm">Catatan Anda</dt>
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-4">
                <h3 class="font-semibold text-gray-900 mb-3">Detail Maintenance & Repair</h3>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500">Kategori Kerusakan</dt>
                        <dd class="font-medium">{{ \App\Models\RepairPricing::CATEGORIES[$serviceRequest->maintenanceDetail->damage_category] ?? 'Lainnya' }}</dd>
                     </div>
                    </div>
                    @if ($serviceRequest->maintenanceDetail->location)
                        <div>
                            <dt class="text-gray-500">Lokasi</dt>
                            <dd class="font-medium">{{ $serviceRequest->maintenanceDetail->location }}</dd>
                        </div>
                    @endif
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
                </dl>
            </div>
        @endif

 <!-- Price Approval (MnR, waiting_approval) -->
        @if ($serviceRequest->status === 'waiting_approval')
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-4">
                <h3 class="font-semibold text-gray-900 mb-3">Persetujuan Harga</h3>

                @if (session('error'))
                    <div class="mb-3 p-3 bg-red-50 text-red-800 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-orange-50 rounded-lg p-4 mb-4">
                    <p class="text-sm text-gray-600 mb-1">Pekerja sudah melakukan survey dan admin menetapkan biaya perbaikan:</p>
                    <p class="text-2xl font-bold text-orange-700">Rp{{ number_format($serviceRequest->total_price, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500 mt-1">Saldo Anda saat ini: Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
                </div>

                <div class="flex gap-3">
                    <form method="POST" action="{{ route('guest.service-requests.approve-price', $serviceRequest) }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                            Setujui & Bayar
                        </button>
                    </form>
                    <form method="POST" action="{{ route('guest.service-requests.reject-price', $serviceRequest) }}" class="flex-1"
                          onsubmit="return confirm('Tolak harga ini? Permintaan akan dibatalkan dan Anda perlu mengajukan ulang.')">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 bg-white border border-red-300 text-red-600 rounded-lg font-medium hover:bg-red-50 transition-colors">
                            Tolak
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Photos -->
        @if ($serviceRequest->photos->isNotEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-4">
                <h3 class="font-semibold text-gray-900 mb-3">Foto</h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($serviceRequest->photos as $photo)
                        <div>
                            <p class="text-xs text-gray-500 capitalize mb-1">{{ $photo->type }}</p>
                            <a href="{{ Storage::url($photo->photo_path) }}" target="_blank">
                                <img src="{{ Storage::url($photo->photo_path) }}" alt="{{ $photo->type }}" class="w-full h-32 object-cover rounded-lg">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Feedback Section -->
        @if ($serviceRequest->status === 'completed')
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-4" id="feedback">
                <h3 class="font-semibold text-gray-900 mb-3">Feedback untuk Pekerja</h3>

                @if ($serviceRequest->feedback)
                    <div class="p-3 bg-green-50 rounded-lg">
                        <p class="font-medium text-green-800">Terima kasih sudah memberikan feedback!</p>
                        <div class="mt-2 flex items-center gap-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 @if($i <= $serviceRequest->feedback->rating) text-yellow-400 @else text-gray-300 @endif" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        @if ($serviceRequest->feedback->comment)
                            <p class="mt-2 text-sm text-gray-700">"{{ $serviceRequest->feedback->comment }}"</p>
                        @endif
                    </div>
                @else
                    <form method="POST" action="{{ route('guest.service-requests.feedback', $serviceRequest) }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="rating">{{ __('Rating') }} <span class="text-red-500">*</span></x-input-label>
                            <div class="mt-1 flex items-center gap-2" role="radiogroup" aria-label="Rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}" required class="sr-only peer" {{ old('rating') == $i ? 'checked' : '' }}>
                                        <svg class="w-8 h-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="comment" :value="__('Komentar (Opsional')" />
                            <textarea name="comment" id="comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2" placeholder="Tulis pengalaman Anda...">{{ old('comment') }}</textarea>
                            <x-input-error :messages="$errors->get('comment')" class="mt-2" />
                        </div>

                        <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                            Kirim Feedback
                        </button>
                    </form>
                @endif
            </div>
        @endif

        <a href="{{ route('guest.service-requests.index') }}" class="block text-center text-indigo-600 hover:underline">← Kembali ke Daftar</a>
    </div>
@endsection
