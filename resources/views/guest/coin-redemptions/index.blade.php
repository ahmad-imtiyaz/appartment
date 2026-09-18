@extends('layouts.guest')

@section('title', 'Penukaran Koin')

@section('header')
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-lg text-gray-800">
            {{ __('Penukaran Koin') }}
        </h2>
        <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white px-4 py-2 rounded-xl">
            <span class="text-sm">Koin Anda: </span>
            <span class="font-bold text-lg">{{ number_format(auth()->user()->coin_balance) }}</span>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-4 px-4">
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

        <!-- Tabs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
            <div class="border-b border-gray-100">
                <nav class="flex gap-1 px-2" aria-label="Tabs">
                    <button id="tab-products" onclick="switchTab('products')"
                            class="tab-btn py-3 px-4 text-sm font-medium rounded-t-lg border-b-2 border-transparent
                                   text-indigo-600 border-indigo-600 bg-indigo-50"
                            aria-selected="true">
                        Produk Tersedia
                    </button>
                    <button id="tab-history" onclick="switchTab('history')"
                            class="tab-btn py-3 px-4 text-sm font-medium rounded-t-lg border-b-2 border-transparent
                                   text-gray-500 hover:text-gray-700"
                            aria-selected="false">
                        Riwayat Penukaran
                    </button>
                </nav>
            </div>

            <!-- Tab Content: Products -->
            <div id="content-products" class="tab-content p-4" role="tabpanel">
                @if ($products->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <p class="mt-2 text-gray-500">Belum ada produk yang bisa ditukarkan</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($products as $product)
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 hover:border-indigo-200 transition-colors">
                                <div class="flex gap-3">
                                    @if ($product->image)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                             class="h-20 w-20 object-cover rounded-lg flex-shrink-0">
                                    @else
                                        <div class="h-20 w-20 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                                        @if ($product->description)
                                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $product->description }}</p>
                                        @endif
                                        <div class="flex items-center justify-between mt-2">
                                            <span class="text-indigo-600 font-bold text-lg">{{ number_format($product->coin_cost) }} Koin</span>
                                            <span class="text-xs {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                                                Stok: {{ $product->stock }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('guest.coin-redemptions.store') }}" class="mt-3"
                                      onsubmit="return confirm('Yakin ingin menukarkan {{ $product->coin_cost }} koin untuk {{ $product->name }}?')">
                                    @csrf
                                    <input type="hidden" name="coin_redemption_product_id" value="{{ $product->id }}">
                                    <button type="submit"
                                            class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors
                                                   {{ !$product->canBeRedeemed() || auth()->user()->coin_balance < $product->coin_cost ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ !$product->canBeRedeemed() || auth()->user()->coin_balance < $product->coin_cost ? 'disabled' : '' }}>
                                        @if (!$product->canBeRedeemed())
                                            Stok Habis
                                        @elseif (auth()->user()->coin_balance < $product->coin_cost)
                                            Koin Tidak Cukup
                                        @else
                                            Tukar Sekarang
                                        @endif
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Tab Content: History -->
            <div id="content-history" class="tab-content p-4 hidden" role="tabpanel">
                @if ($redemptions->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <p class="mt-2 text-gray-500">Belum ada riwayat penukaran</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($redemptions as $redemption)
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            @if ($redemption->product->image)
                                                <img src="{{ $redemption->product->image_url }}" alt="{{ $redemption->product->name }}"
                                                     class="h-10 w-10 object-cover rounded-lg">
                                            @else
                                                <div class="h-10 w-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $redemption->product->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $redemption->created_at->format('d M Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <p class="text-indigo-600 font-medium">{{ number_format($redemption->coin_cost) }} Koin</p>
                                    </div>
                                    <div class="flex flex-col items-end gap-1">
                                        @php
                                            $statusColors = [
                                                'processing' => 'bg-yellow-100 text-yellow-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusLabels = [
                                                'processing' => 'Sedang Proses',
                                                'completed' => 'Berhasil Ditukarkan',
                                                'cancelled' => 'Dibatalkan',
                                            ];
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$redemption->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusLabels[$redemption->status] ?? $redemption->status }}
                                        </span>
                                        @if ($redemption->canBeCancelledByGuest())
                                            <form method="POST" action="{{ route('guest.coin-redemptions.cancel', $redemption) }}"
                                                  onsubmit="return confirm('Yakin ingin membatalkan penukaran ini? Koin akan dikembalikan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-800 text-xs font-medium px-2 py-1 bg-red-50 rounded-lg">
                                                    Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                @if ($redemption->admin_notes)
                                    <div class="mt-2 p-2 bg-gray-50 rounded-lg text-xs text-gray-600">
                                        Catatan: {{ $redemption->admin_notes }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $redemptions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function switchTab(tab) {
            // Update buttons
            document.getElementById('tab-products').classList.toggle('text-indigo-600 border-indigo-600 bg-indigo-50', tab === 'products');
            document.getElementById('tab-products').classList.toggle('text-gray-500', tab !== 'products');
            document.getElementById('tab-history').classList.toggle('text-indigo-600 border-indigo-600 bg-indigo-50', tab === 'history');
            document.getElementById('tab-history').classList.toggle('text-gray-500', tab !== 'history');

            // Update content
            document.getElementById('content-products').classList.toggle('hidden', tab !== 'products');
            document.getElementById('content-history').classList.toggle('hidden', tab !== 'history');
        }
    </script>
@endpush
@endsection