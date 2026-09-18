<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Penukaran Koin') }}
            </h2>
            <a href="{{ route('admin.coin-redemptions.index') }}"
               class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-50 text-green-800 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3 bg-red-50 text-red-800 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
                <!-- Guest Info -->
                <div class="border-b border-gray-100 pb-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Informasi Guest</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500">Nama</dt>
                            <dd class="font-medium text-gray-900">{{ $coinRedemption->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Email</dt>
                            <dd class="font-medium text-gray-900">{{ $coinRedemption->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Unit</dt>
                            <dd class="font-medium text-gray-900">{{ $coinRedemption->user->apartment_unit_number ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Koin Saat Ini</dt>
                            <dd class="font-medium text-indigo-600">{{ number_format($coinRedemption->user->coin_balance) }} Koin</dd>
                        </div>
                    </dl>
                </div>

                <!-- Product Info -->
                <div class="border-b border-gray-100 pb-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Produk Ditukar</h3>
                    <div class="flex items-center gap-4">
                        @if ($coinRedemption->product->image)
                            <img src="{{ $coinRedemption->product->image_url }}" alt="{{ $coinRedemption->product->name }}"
                                 class="h-20 w-20 object-cover rounded-lg">
                        @else
                            <div class="h-20 w-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-900">{{ $coinRedemption->product->name }}</p>
                            @if ($coinRedemption->product->description)
                                <p class="text-sm text-gray-500">{{ $coinRedemption->product->description }}</p>
                            @endif
                            <p class="text-indigo-600 font-medium mt-1">{{ number_format($coinRedemption->coin_cost) }} Koin</p>
                        </div>
                    </div>
                </div>

                <!-- Redemption Details -->
                <div class="border-b border-gray-100 pb-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Detail Penukaran</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500">Status</dt>
                            <dd class="font-medium">
                                @php
                                    $statusColors = [
                                        'processing' => 'bg-yellow-100 text-yellow-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusLabels = [
                                        'processing' => 'Sedang Proses',
                                        'completed' => 'Berhasil',
                                        'cancelled' => 'Dibatalkan',
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$coinRedemption->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$coinRedemption->status] ?? $coinRedemption->status }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Tanggal Request</dt>
                            <dd class="font-medium text-gray-900">{{ $coinRedemption->created_at->format('d M Y H:i') }}</dd>
                        </div>
                        @if ($coinRedemption->processed_at)
                            <div>
                                <dt class="text-gray-500">Tanggal Diproses</dt>
                                <dd class="font-medium text-gray-900">{{ $coinRedemption->processed_at->format('d M Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Diproses Oleh</dt>
                                <dd class="font-medium text-gray-900">{{ $coinRedemption->processor->name ?? '-' }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Admin Notes -->
                @if ($coinRedemption->admin_notes)
                    <div class="border-b border-gray-100 pb-6">
                        <h3 class="font-semibold text-gray-900 mb-3">Catatan Admin</h3>
                        <p class="text-gray-700 bg-gray-50 p-4 rounded-lg">{{ $coinRedemption->admin_notes }}</p>
                    </div>
                @endif

                <!-- Actions -->
                @if ($coinRedemption->isProcessing())
                    <div class="flex gap-4">
                        <form method="POST" action="{{ route('admin.coin-redemptions.approve', $coinRedemption) }}">
                            @csrf
                            <div class="flex-1">
                                <label for="approve_notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                                <textarea name="admin_notes" id="approve_notes" rows="2"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                            </div>
                            <button type="submit"
                                    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors self-end"
                                    onclick="return confirm('Approve penukaran ini?')">
                                Approve
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.coin-redemptions.reject', $coinRedemption) }}">
                            @csrf
                            <div class="flex-1">
                                <label for="reject_notes" class="block text-sm font-medium text-gray-700 mb-1">Alasan Reject</label>
                                <textarea name="admin_notes" id="reject_notes" rows="2" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                            </div>
                            <button type="submit"
                                    class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors self-end"
                                    onclick="return confirm('Reject penukaran ini? Koin akan dikembalikan ke guest.')">
                                Reject
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>