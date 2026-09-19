@extends('layouts.guest')

@section('title', __('guest.market.title'))

@push('styles')
<style>
    :root{
        --red:#DC2626;
        --red-dark:#B91C1C;
        --pink-bg:#FDECEF;
        --pink-icon:#DB2777;
        --orange:#F97316;
        --border:#F1F1F1;
        --wa-green:#25D366;
        --wa-green-dark:#1DA851;
    }

    .jb-wrapper{
        width: 100%;
        overflow-x: hidden;
    }

    /* Hero header */
    .jb-hero{
        background:linear-gradient(135deg, var(--red) 0%, #EF4444 55%, var(--orange) 130%);
        padding:20px 16px 40px;
        position:relative;
        overflow:hidden;
    }
    .jb-hero::before{
        content:"";
        position:absolute;
        top:-40px; right:-40px;
        width:160px; height:160px;
        border-radius:50%;
        background:rgba(255,255,255,0.08);
    }
    .jb-hero::after{
        content:"";
        position:absolute;
        bottom:-60px; left:-20px;
        width:140px; height:140px;
        border-radius:50%;
        background:rgba(255,255,255,0.06);
    }
    .jb-hero-icon{
        width:44px;height:44px;
        background:rgba(255,255,255,0.18);
        border:1px solid rgba(255,255,255,0.25);
        border-radius:13px;
        flex-shrink:0;
    }
    .jb-hero-title{
        color:#fff;
        letter-spacing:-0.01em;
    }
    .jb-hero-subtitle{
        color:rgba(255,255,255,0.85);
    }
    .jb-hero-tagline{
        color:rgba(255,255,255,0.92);
    }
    .jb-stat{
        background:rgba(255,255,255,0.14);
        border:1px solid rgba(255,255,255,0.2);
        border-radius:12px;
        padding:9px 12px;
        flex:1;
    }
    .jb-stat-value{
        color:#fff;
        font-weight:800;
        line-height:1;
    }
    .jb-stat-label{
        color:rgba(255,255,255,0.8);
    }

    /* Panel that overlaps the hero for a layered app feel */
    .jb-panel{
        background:#F9FAFB;
        border-radius:22px 22px 0 0;
        margin-top:-24px;
        position:relative;
        z-index:1;
        padding:18px 16px 24px;
    }

    .category-pill{
        background:#fff;
        border:1px solid var(--border);
        color:#374151;
        font-size:12px;
        font-weight:600;
        padding:7px 14px;
        border-radius:999px;
        white-space:nowrap;
        transition:background .15s ease, color .15s ease, border-color .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .category-pill.active,
    .category-pill:active{
        background:var(--red);
        border-color:var(--red);
        color:#fff;
    }
    .category-scroll{
        overflow-x:auto;
        scrollbar-width:none;
        -ms-overflow-style:none;
    }
    .category-scroll::-webkit-scrollbar{display:none;}

    .product-card{
        background:#fff;
        border-radius:16px;
        border:1px solid var(--border);
        box-shadow:0 1px 3px rgba(0,0,0,0.04);
        overflow:hidden;
        transition:transform .15s ease, box-shadow .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .product-card:active{
        transform:scale(0.97);
        box-shadow:0 1px 2px rgba(0,0,0,0.04);
    }
    .product-thumb{
        width:100%;
        aspect-ratio:1/1;
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
    .product-badge{
        background:var(--pink-bg);
        color:var(--pink-icon);
        font-size:10px;
        font-weight:600;
        padding:2px 8px;
        border-radius:999px;
        display:inline-block;
    }

    .wa-btn{
        background:var(--wa-green);
        color:#fff;
        font-size:11px;
        font-weight:600;
        padding:6px 0;
        border-radius:8px;
        display:flex;
        align-items:center;
        justify-content:center;
        gap:4px;
        margin-top:8px;
        transition:background .15s ease, transform .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .wa-btn:active{
        background:var(--wa-green-dark);
        transform:scale(0.97);
    }
    .wa-btn svg{width:13px;height:13px;flex-shrink:0;}
    .wa-btn-disabled{
        background:#E5E7EB;
        color:#9CA3AF;
        pointer-events:none;
    }

    .fab-jual{
        background:var(--red);
        box-shadow:0 4px 12px rgba(220,38,38,0.35);
        transition:transform .15s ease, background .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .fab-jual:active{transform:scale(0.94);background:var(--red-dark);}
</style>
@endpush

@section('content')
<div class="jb-wrapper">

    {{-- Hero header --}}
    <div class="jb-hero">
        <div class="flex items-center gap-2.5 mb-4">
            <div class="jb-hero-icon flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v11.25a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25V7.5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5.25V4.5a3 3 0 016 0v.75M9 12h6m-6 3.75h4.5" />
                </svg>
            </div>
            <div class="min-w-0">
                <p class="jb-hero-title font-bold text-[17px] leading-tight">{{ __('guest.market.title') }}</p>
                <p class="jb-hero-subtitle text-[11px] leading-tight italic">{{ __('guest.market.subtitle') }}</p>
            </div>
        </div>
        <p class="jb-hero-tagline text-[13px] leading-snug max-w-[320px]">{{ __('guest.market.tagline') }}</p>

        <div class="flex gap-2.5 mt-4">
            <div class="jb-stat">
                <p class="jb-stat-value text-[18px]">{{ $listings->total() }}</p>
                <p class="jb-stat-label text-[10px] mt-0.5">{{ __('guest.market.active_items') }}</p>
            </div>
            @if (isset($categories) && $categories->isNotEmpty())
                <div class="jb-stat">
                    <p class="jb-stat-value text-[18px]">{{ $categories->count() }}</p>
                    <p class="jb-stat-label text-[10px] mt-0.5">{{ __('guest.market.categories') }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Overlapping content panel --}}
    <div class="jb-panel space-y-5">

        @if (session('success'))
            <div class="p-3 bg-green-50 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="p-3 bg-red-50 text-red-800 rounded-lg text-sm">{{ session('error') }}</div>
        @endif

        {{-- Filter kategori (opsional, tampil jika ada kategori) --}}
        @if (isset($categories) && $categories->isNotEmpty())
            <div class="category-scroll flex items-center gap-2">
                <a href="{{ route('product-listings.index') }}"
                   class="category-pill {{ request('category') ? '' : 'active' }}">{{ __('guest.market.all') }}</a>
                @foreach ($categories as $cat)
                    <a href="{{ route('product-listings.index', ['category' => $cat]) }}"
                       class="category-pill {{ request('category') === $cat ? 'active' : '' }}">{{ ucfirst($cat) }}</a>
                @endforeach
            </div>
        @endif

        {{-- Grid produk --}}
        <div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-gray-900 text-[16px]">{{ __('guest.market.section_title') }}</h3>
                <span class="text-xs text-gray-500 whitespace-nowrap">{{ __('guest.common.items_count', ['count' => $listings->total()]) }}</span>
            </div>

            @if ($listings->isEmpty())
                <div class="text-center py-10 text-gray-500 bg-white rounded-xl border border-dashed border-gray-200">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v11.25a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25V7.5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5.25V4.5a3 3 0 016 0v.75M9 12h6m-6 3.75h4.5" />
                    </svg>
                    <p class="mt-2 text-sm">{{ __('guest.market.empty') }}</p>
                </div>
            @else
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($listings as $listing)
                        <div class="product-card">
                            <div class="product-thumb">
                                @if ($listing->image)
                                    <img src="{{ asset('storage/' . $listing->image) }}" alt="{{ $listing->title }}">
                                @else
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 3h18v18H3V3z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="p-2.5">
                                @if ($listing->category)
                                    <span class="product-badge mb-1.5">{{ ucfirst($listing->category) }}</span>
                                @endif
                                <h4 class="text-[13px] font-semibold text-gray-900 leading-snug mt-1 line-clamp-2">{{ $listing->title }}</h4>
                                @if ($listing->price)
                                    <p class="product-price text-[13px] font-bold mt-1">Rp{{ number_format($listing->price, 0, ',', '.') }}</p>
                                @else
                                    <p class="text-[12px] text-gray-500 mt-1">{{ __('guest.market.negotiable') }}</p>
                                @endif
                                @if ($listing->contact_info)
                                    <p class="text-[10px] text-gray-400 mt-1 truncate">{{ $listing->contact_info }}</p>
                                @endif

                                {{-- Tombol chat WhatsApp --}}
                                @if ($listing->whatsapp_url)
                                    <a href="{{ $listing->whatsapp_url }}" target="_blank" rel="noopener" class="wa-btn">
                                        <svg viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.26-1.38a9.9 9.9 0 004.78 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.85 9.85 0 0012.04 2zm5.8 14.11c-.24.68-1.4 1.3-1.94 1.38-.5.08-1.12.11-1.81-.11-.42-.13-.95-.31-1.64-.6-2.9-1.25-4.79-4.17-4.94-4.36-.14-.2-1.18-1.57-1.18-3 0-1.42.75-2.12 1.01-2.41.27-.29.58-.36.77-.36l.55.01c.18.01.42-.07.65.5.24.58.82 2 .89 2.15.07.15.12.32.02.52-.1.19-.14.31-.28.48-.14.17-.29.37-.42.5-.14.14-.28.29-.12.57.16.28.71 1.17 1.52 1.9 1.05.94 1.93 1.23 2.21 1.37.28.14.44.12.61-.07.17-.19.72-.84.91-1.13.19-.29.38-.24.63-.14.26.09 1.63.77 1.91.91.28.14.47.21.54.33.07.12.07.68-.17 1.36z"/>
                                        </svg>
                                        {{ __('guest.market.chat_wa') }}
                                    </a>
                                @else
                                    <div class="wa-btn wa-btn-disabled">
                                        {{ __('guest.market.invalid_contact') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $listings->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
