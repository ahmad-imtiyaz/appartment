@extends('layouts.guest')

@section('title', 'Penukaran Koin')

@push('styles')
<style>
    :root{
        --red:#DC2626;
        --red-dark:#B91C1C;
        --pink-bg:#FDECEF;
        --pink-icon:#DB2777;
        --orange:#F97316;
        --border:#F1F1F1;
    }

    .header-card{
        background:#fff;
        border-radius:20px;
        border:1px solid var(--border);
        box-shadow:0 1px 3px rgba(0,0,0,0.04);
        padding:16px;
    }
    .brand-icon{
        width:36px;height:36px;
        background:var(--red);
        border-radius:10px;
        flex-shrink:0;
    }
    .balance-pill{
        background:linear-gradient(135deg, var(--red) 0%, var(--red-dark) 100%);
        border-radius:14px;
        padding:10px 14px;
        box-shadow:0 4px 12px rgba(220,38,38,0.25);
    }

    .tab-row{
        background:#fff;
        border-radius:20px;
        border:1px solid var(--border);
        box-shadow:0 1px 3px rgba(0,0,0,0.04);
        overflow:hidden;
    }
    .tab-pillbar{
        display:flex;
        justify-content:center;
        gap:8px;
        padding:12px 12px 0 12px;
        overflow-x:auto;
        scrollbar-width:none;
        -ms-overflow-style:none;
    }
    .tab-pillbar::-webkit-scrollbar{display:none;}
    .tab-btn{
        background:#F9FAFB;
        border:1px solid var(--border);
        color:#374151;
        font-size:13px;
        font-weight:600;
        padding:9px 16px;
        border-radius:999px 999px 0 0;
        white-space:nowrap;
        transition:background .15s ease, color .15s ease, border-color .15s ease;
        -webkit-tap-highlight-color:transparent;
        border-bottom:none;
    }
    .tab-btn.active{
        background:var(--red);
        border-color:var(--red);
        color:#fff;
    }
    .tab-panel-wrap{
        border-top:1px solid var(--border);
        padding:16px;
    }

    .product-card{
        background:#fff;
        border-radius:16px;
        border:1px solid var(--border);
        box-shadow:0 1px 3px rgba(0,0,0,0.04);
        overflow:hidden;
        display:flex;
        flex-direction:column;
        transition:transform .15s ease, box-shadow .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .product-card:active{
        transform:scale(0.98);
    }
    .product-thumb{
        width:100%;
        aspect-ratio:4/3;
        background:var(--pink-bg);
        display:flex;
        align-items:center;
        justify-content:center;
        overflow:hidden;
    }
    .product-thumb img{
        width:100%;height:100%;object-fit:cover;
    }
    .product-thumb svg{color:var(--pink-icon);}
    .product-price{color:var(--red);}
    .stock-badge{
        font-size:10px;
        font-weight:600;
        padding:2px 8px;
        border-radius:999px;
        display:inline-block;
        white-space:nowrap;
    }
    .stock-badge.in{background:#ECFDF5;color:#059669;}
    .stock-badge.out{background:var(--pink-bg);color:var(--red-dark);}

    .redeem-btn{
        background:var(--red);
        color:#fff;
        font-size:13px;
        font-weight:600;
        padding:9px 0;
        border-radius:10px;
        width:100%;
        transition:background .15s ease, transform .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .redeem-btn:active{background:var(--red-dark);transform:scale(0.97);}
    .redeem-btn:disabled{
        background:#E5E7EB;
        color:#9CA3AF;
    }

    .history-card{
        background:#fff;
        border-radius:16px;
        border:1px solid var(--border);
        box-shadow:0 1px 3px rgba(0,0,0,0.04);
        padding:14px;
    }
    .status-pill{
        font-size:10px;
        font-weight:600;
        padding:3px 10px;
        border-radius:999px;
        white-space:nowrap;
    }
    .status-processing{background:#FFF7ED;color:var(--orange);}
    .status-completed{background:#ECFDF5;color:#059669;}
    .status-cancelled{background:var(--pink-bg);color:var(--red-dark);}

    .history-thumb-fallback{
        background:var(--pink-bg);
    }
    .history-thumb-fallback svg{color:var(--pink-icon);}

    .cancel-btn{
        background:var(--pink-bg);
        color:var(--red-dark);
        font-size:11px;
        font-weight:600;
        padding:5px 10px;
        border-radius:8px;
        transition:background .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .cancel-btn:active{background:#FBD5E0;}

    .empty-state{
        text-align:center;
        padding:40px 16px;
        color:#6B7280;
        background:#F9FAFB;
        border-radius:14px;
        border:1px dashed #E5E7EB;
    }
</style>
@endpush

@section('header')
    <div class="flex items-center justify-between gap-3">
        <h2 class="font-bold text-lg text-gray-900">
            {{ __('Penukaran Koin') }}
        </h2>
        <div class="balance-pill flex items-center gap-1.5 shrink-0">
            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 3.5a1 1 0 011 1V7h.75a1 1 0 110 2H13v1h.5a2.5 2.5 0 010 5H13v.5a1 1 0 11-2 0V15h-.75a1 1 0 110-2H11v-1h-.5a2.5 2.5 0 010-5H11v-.5a1 1 0 011-1z"/>
            </svg>
            <span class="text-[11px] text-white/90">Koin Anda</span>
            <span class="font-bold text-sm text-white">{{ number_format(auth()->user()->coin_balance) }}</span>
        </div>
    </div>
@endsection

@section('content')
<div class="px-4 pt-4 pb-6 space-y-4">

    @if (session('success'))
        <div class="p-3 bg-green-50 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="p-3 bg-red-50 text-red-800 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    {{-- Tabs --}}
    <div class="tab-row">
        <nav class="tab-pillbar" aria-label="Tabs">
            <button id="tab-products" onclick="switchTab('products')"
                    class="tab-btn active" aria-selected="true">
                Produk Tersedia
            </button>
            <button id="tab-history" onclick="switchTab('history')"
                    class="tab-btn" aria-selected="false">
                Riwayat Penukaran
            </button>
        </nav>

        {{-- Tab Content: Products --}}
        <div id="content-products" class="tab-panel-wrap tab-content" role="tabpanel">
            @if ($products->isEmpty())
                <div class="empty-state">
                    <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <p class="mt-2 text-sm">Belum ada produk yang bisa ditukarkan</p>
                </div>
            @else
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($products as $product)
                        <div class="product-card">
                            <div class="product-thumb">
                                @if ($product->image)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                @else
                                    <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="p-3 flex flex-col flex-1">
                                <h3 class="font-semibold text-gray-900 text-[13px] leading-snug truncate">{{ $product->name }}</h3>
                                @if ($product->description)
                                    <p class="text-[12px] text-gray-500 mt-1 line-clamp-2">{{ $product->description }}</p>
                                @endif
                                <div class="flex items-center justify-between mt-2 gap-2">
                                    <span class="product-price font-bold text-[13px] whitespace-nowrap">{{ number_format($product->coin_cost) }} Koin</span>
                                    <span class="stock-badge {{ $product->stock > 0 ? 'in' : 'out' }}">
                                        Stok: {{ $product->stock }}
                                    </span>
                                </div>
                                <form method="POST" action="{{ route('guest.coin-redemptions.store') }}" class="mt-3"
                                      onsubmit="return confirm('Yakin ingin menukarkan {{ $product->coin_cost }} koin untuk {{ $product->name }}?')">
                                    @csrf
                                    <input type="hidden" name="coin_redemption_product_id" value="{{ $product->id }}">
                                    <button type="submit" class="redeem-btn"
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
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Tab Content: History --}}
        <div id="content-history" class="tab-panel-wrap tab-content hidden" role="tabpanel">
            @if ($redemptions->isEmpty())
                <div class="empty-state">
                    <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <p class="mt-2 text-sm">Belum ada riwayat penukaran</p>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                    @foreach ($redemptions as $redemption)
                        <div class="history-card">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    @if ($redemption->product->image)
                                        <img src="{{ $redemption->product->image_url }}" alt="{{ $redemption->product->name }}"
                                             class="h-11 w-11 object-cover rounded-lg shrink-0">
                                    @else
                                        <div class="history-thumb-fallback h-11 w-11 rounded-lg flex items-center justify-center shrink-0">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-900 text-[13px] truncate">{{ $redemption->product->name }}</p>
                                        <p class="text-[11px] text-gray-400">{{ $redemption->created_at->format('d M Y H:i') }}</p>
                                        <p class="product-price font-bold text-[12px] mt-0.5">{{ number_format($redemption->coin_cost) }} Koin</p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-1.5 shrink-0">
                                    @php
                                        $statusClasses = [
                                            'processing' => 'status-processing',
                                            'completed' => 'status-completed',
                                            'cancelled' => 'status-cancelled',
                                        ];
                                        $statusLabels = [
                                            'processing' => 'Sedang Proses',
                                            'completed' => 'Berhasil Ditukarkan',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span class="status-pill {{ $statusClasses[$redemption->status] ?? 'status-processing' }}">
                                        {{ $statusLabels[$redemption->status] ?? $redemption->status }}
                                    </span>
                                    @if ($redemption->canBeCancelledByGuest())
                                        <form method="POST" action="{{ route('guest.coin-redemptions.cancel', $redemption) }}"
                                              onsubmit="return confirm('Yakin ingin membatalkan penukaran ini? Koin akan dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="cancel-btn">
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            @if ($redemption->admin_notes)
                                <div class="mt-2 p-2 bg-gray-50 rounded-lg text-[11px] text-gray-600">
                                    Catatan: {{ $redemption->admin_notes }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $redemptions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function switchTab(tab) {
            const productsBtn = document.getElementById('tab-products');
            const historyBtn = document.getElementById('tab-history');
            const productsContent = document.getElementById('content-products');
            const historyContent = document.getElementById('content-history');

            if (tab === 'products') {
                productsBtn.classList.add('active');
                historyBtn.classList.remove('active');
                productsContent.classList.remove('hidden');
                historyContent.classList.add('hidden');
            } else {
                historyBtn.classList.add('active');
                productsBtn.classList.remove('active');
                historyContent.classList.remove('hidden');
                productsContent.classList.add('hidden');
            }
        }
    </script>
@endpush
@endsection
