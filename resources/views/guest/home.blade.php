@extends('layouts.guest')

@section('title', __('guest.nav.home'))

@push('styles')
<style>
    :root{
        --red:#DC2626;
        --red-dark:#B91C1C;
        --ink:#111827;
        --muted:#6B7280;
        --line:#F1F1F1;
    }

    .hm-page{
        max-width:480px;
        margin-left:auto;
        margin-right:auto;
        width:100%;
        min-height:100vh;
        overflow-x:hidden;
        background:#F8F9FB;
        padding-bottom:24px;
    }
    .hm-body{padding:22px 16px 0;}
    .hm-section + .hm-section{margin-top:26px;}

    .hm-heading{
        font-size:16px;
        font-weight:800;
        color:var(--ink);
        line-height:1.2;
    }
    .hm-sub{
        font-size:12px;
        color:var(--muted);
        margin-top:3px;
    }

    /* ============ SERVICES ============ */
    .hm-grid{
        display:grid;
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:12px;
        margin-top:14px;
    }
    .hm-svc{
        --tint:#FEE2E2;
        --ink-c:#DC2626;
        position:relative;
        display:flex;
        flex-direction:column;
        gap:10px;
        padding:14px;
        background:#fff;
        border:1px solid var(--line);
        border-radius:20px;
        text-decoration:none;
        box-shadow:0 1px 2px rgba(17,24,39,.04);
        transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .hm-svc:hover{
        box-shadow:0 12px 24px -12px rgba(17,24,39,.22);
        border-color:#E5E7EB;
        transform:translateY(-2px);
    }
    .hm-svc:active{transform:scale(.97);}

    .hm-svc--rose {--tint:#FFE4E6;--ink-c:#E11D48;}
    .hm-svc--sky  {--tint:#E0F2FE;--ink-c:#0284C7;}
    .hm-svc--amber{--tint:#FEF3C7;--ink-c:#D97706;}
    .hm-svc--teal {--tint:#CCFBF1;--ink-c:#0D9488;}

    .hm-svc-icon{
        width:46px;height:46px;
        border-radius:14px;
        background:var(--tint);
        color:var(--ink-c);
        display:flex;align-items:center;justify-content:center;
    }
    .hm-svc-icon svg{width:24px;height:24px;}
    .hm-svc-title{
        font-size:14px;
        font-weight:800;
        color:var(--ink);
        line-height:1.2;
    }
    .hm-svc-desc{
        font-size:11px;
        color:var(--muted);
        line-height:1.4;
        margin-top:-6px;
    }
    .hm-svc-arrow{
        position:absolute;
        top:14px;right:14px;
        width:26px;height:26px;
        border-radius:50%;
        background:#F3F4F6;
        color:#9CA3AF;
        display:flex;align-items:center;justify-content:center;
        transition:background .15s ease, transform .15s ease;
    }
    .hm-svc:hover .hm-svc-arrow{background:var(--ink-c);color:#fff;}
    .hm-svc-arrow svg{width:13px;height:13px;}

    /* ============ CTA ============ */
    .hm-cta{
        position:relative;
        overflow:hidden;
        padding:20px;
        border-radius:24px;
        color:#fff;
        background:linear-gradient(135deg,#111827 0%,#1F2937 55%,#3B0A0A 100%);
        box-shadow:0 18px 30px -18px rgba(17,24,39,.6);
    }
    .hm-cta::before{
        content:"";
        position:absolute;
        width:190px;height:190px;
        right:-60px;top:-70px;
        border-radius:50%;
        background:radial-gradient(circle,rgba(220,38,38,.55),rgba(220,38,38,0) 70%);
    }
    .hm-cta > *{position:relative;z-index:1;}
    .hm-cta-small{
        font-size:12px;
        font-weight:600;
        color:rgba(255,255,255,.65);
    }
    .hm-cta-title{
        margin-top:4px;
        max-width:230px;
        font-size:19px;
        font-weight:800;
        line-height:1.25;
    }
    .hm-cta-btn{
        margin-top:16px;
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:12px 18px;
        border-radius:14px;
        background:#fff;
        color:var(--red-dark);
        font-size:13px;
        font-weight:800;
        text-decoration:none;
        transition:transform .15s ease,box-shadow .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .hm-cta-btn:hover{box-shadow:0 8px 18px -6px rgba(255,255,255,.35);}
    .hm-cta-btn:active{transform:scale(.97);}
    .hm-cta-btn svg{width:16px;height:16px;}

/* ============ MARKETPLACE SLIDER ============ */

.hm-slider{
    display:flex;
    gap:12px;
    margin-top:14px;
    overflow-x:auto;
    scroll-snap-type:x mandatory;
    -webkit-overflow-scrolling:touch;
    padding:2px 2px 6px;
}

.hm-slider::-webkit-scrollbar{
    display:none;
}

.hm-slide{
    position:relative;
    scroll-snap-align:start;
    flex:0 0 68%;
    background:#fff;
    border:1px solid var(--line);
    border-radius:20px;
    overflow:hidden;
    text-decoration:none;
    box-shadow:0 2px 6px rgba(17,24,39,.05);
    transition:
        transform .18s ease,
        box-shadow .18s ease,
        border-color .18s ease;
    -webkit-tap-highlight-color:transparent;
}

.hm-slide:hover{
    transform:translateY(-2px);
    border-color:#E5E7EB;
    box-shadow:0 12px 24px -14px rgba(17,24,39,.25);
}

.hm-slide:active{
    transform:scale(.98);
}

/* Gambar */

.hm-slide-img-wrap{
    position:relative;
    width:100%;
    aspect-ratio:4/3;
    background:#F3F4F6;
    overflow:hidden;
}

.hm-slide-img-wrap img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
    transition:transform .3s ease;
}

.hm-slide:hover .hm-slide-img-wrap img{
    transform:scale(1.03);
}

/* Badge kategori */

.hm-slide-category{
    position:absolute;
    left:10px;
    bottom:10px;
    display:inline-flex;
    align-items:center;
    max-width:calc(100% - 20px);
    padding:5px 9px;
    border-radius:999px;
    background:rgba(17,24,39,.78);
    color:#fff;
    font-size:9.5px;
    font-weight:700;
    line-height:1;
    backdrop-filter:blur(6px);
    -webkit-backdrop-filter:blur(6px);
}

/* Body */

.hm-slide-body{
    padding:12px 13px 13px;
}

/* Judul */

.hm-slide-title{
    font-size:13px;
    font-weight:800;
    color:var(--ink);
    line-height:1.35;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

/* Deskripsi */

.hm-slide-desc{
    margin-top:5px;
    font-size:10.5px;
    color:var(--muted);
    line-height:1.45;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

/* Bagian bawah */

.hm-slide-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    margin-top:11px;
    padding-top:10px;
    border-top:1px solid #F3F4F6;
}

/* Harga */

.hm-slide-price{
    margin:0;
    font-size:13px;
    font-weight:800;
    color:var(--red);
    line-height:1.2;
}

/* Kalau tidak ada harga */

.hm-slide-price-muted{
    font-size:10px;
    font-weight:600;
    color:#9CA3AF;
}

/* WhatsApp */

.hm-slide-wa{
    flex-shrink:0;
    width:30px;
    height:30px;
    border-radius:50%;
    background:#22C55E;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    box-shadow:0 4px 10px -4px rgba(34,197,94,.55);
    transition:
        background .15s ease,
        transform .15s ease,
        box-shadow .15s ease;
}

.hm-slide-wa:hover{
    background:#16A34A;
    box-shadow:0 6px 14px -5px rgba(34,197,94,.65);
}

.hm-slide-wa:active{
    transform:scale(.92);
}

.hm-slide-wa svg{
    width:15px;
    height:15px;
}

    /* ============ STEPS ============ */
    .hm-steps{
        display:grid;
        grid-template-columns:repeat(3,minmax(0,1fr));
        gap:10px;
        margin-top:14px;
    }
    .hm-step{
        background:#fff;
        border:1px solid var(--line);
        border-radius:18px;
        padding:14px 10px;
        text-align:center;
        box-shadow:0 1px 2px rgba(17,24,39,.04);
    }
    .hm-step-num{
        width:30px;height:30px;
        margin:0 auto 8px;
        border-radius:50%;
        display:flex;align-items:center;justify-content:center;
        font-size:13px;
        font-weight:800;
        color:#fff;
        background:linear-gradient(135deg,#DC2626,#B91C1C);
        box-shadow:0 6px 12px -4px rgba(220,38,38,.5);
    }
    .hm-step-title{
        font-size:11.5px;
        font-weight:800;
        color:var(--ink);
        line-height:1.25;
    }
    .hm-step-desc{
        margin-top:4px;
        font-size:10px;
        color:var(--muted);
        line-height:1.4;
    }

    /* ============ TRUST ============ */
    .hm-trust{
        display:grid;
        grid-template-columns:repeat(3,minmax(0,1fr));
        gap:6px;
        background:#fff;
        border:1px solid var(--line);
        border-radius:20px;
        padding:14px 8px;
        box-shadow:0 1px 2px rgba(17,24,39,.04);
    }
    .hm-trust-item{
        display:flex;
        flex-direction:column;
        align-items:center;
        gap:7px;
        text-align:center;
    }
    .hm-trust-icon{
        width:38px;height:38px;
        border-radius:12px;
        background:#FEF2F2;
        color:var(--red);
        display:flex;align-items:center;justify-content:center;
    }
    .hm-trust-icon svg{width:20px;height:20px;}
    .hm-trust-label{
        font-size:10.5px;
        font-weight:700;
        color:#374151;
        line-height:1.25;
    }

    /* ============ ANIMASI MASUK ============ */
    @keyframes hm-rise{
        from{opacity:0;transform:translateY(12px);}
        to{opacity:1;transform:translateY(0);}
    }
    .hm-rise{animation:hm-rise .45s ease both;}
    @media (prefers-reduced-motion:reduce){
        .hm-rise{animation:none;}
        .hm-svc,.hm-cta-btn,.hm-btn{transition:none;}
    }
</style>
@endpush

@section('content')
<div class="hm-page">

    @include('guest.partials.header-card')

        <div class="hm-body">

    <div style="margin-bottom:18px">
        @include('guest.partials.topup-pending')
    </div>

    {{-- Layanan --}}
        <section class="hm-section hm-rise" style="animation-delay:.05s">

            <h3 class="hm-heading">{{ __('guest.home.our_services') }}</h3>
            <p class="hm-sub">{{ __('guest.home.services_subtitle') }}</p>

            <div class="hm-grid">

                {{-- Laundry --}}
                <a href="{{ route('guest.services.show', 'laundry') }}" class="hm-svc hm-svc--sky">
                    <span class="hm-svc-arrow">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                    <span class="hm-svc-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                            <rect x="4" y="2.5" width="16" height="19" rx="3"/>
                            <circle cx="12" cy="14" r="4"/>
                            <path stroke-linecap="round" d="M7.5 6h.01M11 6h2"/>
                        </svg>
                    </span>
                    <span class="hm-svc-title">{{ __('guest.home.laundry') }}</span>
                    <span class="hm-svc-desc">{{ __('guest.home.laundry_desc') }}</span>
                </a>

                {{-- Kebersihan --}}
                <a href="{{ route('guest.services.show', 'cleaning') }}" class="hm-svc hm-svc--teal">
                    <span class="hm-svc-arrow">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                    <span class="hm-svc-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/>
                        </svg>
                    </span>
                    <span class="hm-svc-title">{{ __('guest.home.cleaning') }}</span>
                    <span class="hm-svc-desc">{{ __('guest.home.cleaning_desc') }}</span>
                </a>

                {{-- Perbaikan & Perawatan --}}
                <a href="{{ route('guest.services.show', 'maintenance-repair') }}" class="hm-svc hm-svc--amber">
                    <span class="hm-svc-arrow">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                    <span class="hm-svc-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.909 4.909m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>
                        </svg>
                    </span>
                    <span class="hm-svc-title">{{ __('guest.home.repair_maintenance') }}</span>
                    <span class="hm-svc-desc">{{ __('guest.home.repair_desc') }}</span>
                </a>

                {{-- AC --}}
                <a href="{{ route('guest.service-requests.category', 'ac') }}" class="hm-svc hm-svc--rose">
                    <span class="hm-svc-arrow">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                    <span class="hm-svc-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M4.2 7.5l15.6 9M4.2 16.5l15.6-9M9.5 4.5L12 6.5l2.5-2M9.5 19.5l2.5-2 2.5 2"/>
                        </svg>
                    </span>
                    <span class="hm-svc-title">{{ __('guest.home.ac') }}</span>
                    <span class="hm-svc-desc">{{ __('guest.home.ac_desc') }}</span>
                </a>

            </div>

        </section>


        {{-- Jual/Beli Slider --}}
@if ($listings->isNotEmpty())
    <section class="hm-section hm-rise" style="animation-delay:.12s">

        <div class="flex items-center justify-between">
            <div>
                <h3 class="hm-heading">{{ __('guest.home.marketplace_title') }}</h3>
                <p class="hm-sub">{{ __('guest.home.marketplace_subtitle') }}</p>
            </div>
            <a href="{{ route('product-listings.index') }}" class="text-xs font-semibold text-red-600">
                {{ __('guest.home.see_all') }}
            </a>
        </div>

       <div class="hm-slider">
    @foreach ($listings as $listing)

    <a href="{{ route('product-listings.index') }}" class="hm-slide">

        {{-- Gambar --}}
        <div class="hm-slide-img-wrap">

            @if ($listing->image)

                <img
                    src="{{ Storage::url($listing->image) }}"
                    alt="{{ $listing->title }}"
                    loading="lazy"
                >

            @else

                <div class="w-full h-full flex items-center justify-center">

                    <svg
                        class="w-10 h-10 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                    </svg>

                </div>

            @endif

            {{-- Kategori --}}
            @if ($listing->category)
                <span class="hm-slide-category">
                    {{ $listing->category }}
                </span>
            @endif

        </div>

        {{-- Isi Card --}}
        <div class="hm-slide-body">

            {{-- Judul --}}
            <p class="hm-slide-title">
                {{ $listing->title }}
            </p>

            {{-- Deskripsi --}}
            @if ($listing->description)
                <p class="hm-slide-desc">
                    {{ $listing->description }}
                </p>
            @endif

            {{-- Footer --}}
            <div class="hm-slide-footer">

                {{-- Harga --}}
                <div>
                    @if ($listing->price)
                        <p class="hm-slide-price">
                            Rp{{ number_format($listing->price, 0, ',', '.') }}
                        </p>
                    @else
                        <span class="hm-slide-price-muted">
                            Hubungi penjual
                        </span>
                    @endif
                </div>

                {{-- WhatsApp --}}
                @if ($listing->whatsapp_url)

                    <span
                        class="hm-slide-wa"
                        role="button"
                        tabindex="0"
                        aria-label="Chat WhatsApp tentang {{ $listing->title }}"
                        onclick="event.preventDefault(); event.stopPropagation(); window.open('{{ $listing->whatsapp_url }}', '_blank');"
                        onkeydown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); event.stopPropagation(); window.open('{{ $listing->whatsapp_url }}', '_blank'); }"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.149.198-.298.198-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </span>

                @endif

            </div>

        </div>

    </a>

@endforeach
</div>

    </section>
@endif


        {{-- Cara Kerja --}}
        <section class="hm-section hm-rise" style="animation-delay:.19s">

            <h3 class="hm-heading">{{ __('guest.home.how_title') }}</h3>

            <div class="hm-steps">

                <div class="hm-step">
                    <div class="hm-step-num">1</div>
                    <p class="hm-step-title">{{ __('guest.home.step1_title') }}</p>
                    <p class="hm-step-desc">{{ __('guest.home.step1_desc') }}</p>
                </div>

                <div class="hm-step">
                    <div class="hm-step-num">2</div>
                    <p class="hm-step-title">{{ __('guest.home.step2_title') }}</p>
                    <p class="hm-step-desc">{{ __('guest.home.step2_desc') }}</p>
                </div>

                <div class="hm-step">
                    <div class="hm-step-num">3</div>
                    <p class="hm-step-title">{{ __('guest.home.step3_title') }}</p>
                    <p class="hm-step-desc">{{ __('guest.home.step3_desc') }}</p>
                </div>

            </div>

        </section>


        {{-- Keunggulan --}}
        <section class="hm-section hm-rise" style="animation-delay:.26s">

            <div class="hm-trust">

                <div class="hm-trust-item">
                    <span class="hm-trust-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                        </svg>
                    </span>
                    <span class="hm-trust-label">{{ __('guest.home.trust_pro') }}</span>
                </div>

                <div class="hm-trust-item">
                    <span class="hm-trust-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>
                        </svg>
                    </span>
                    <span class="hm-trust-label">{{ __('guest.home.trust_fast') }}</span>
                </div>

                <div class="hm-trust-item">
                    <span class="hm-trust-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                        </svg>
                    </span>
                    <span class="hm-trust-label">{{ __('guest.home.trust_safe') }}</span>
                </div>

            </div>

        </section>

    </div>

</div>
@endsection
