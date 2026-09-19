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
        transition:background .18s ease,color .18s ease;
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


        {{-- CTA --}}
        <section class="hm-section hm-rise" style="animation-delay:.12s">

            <div class="hm-cta">

                <p class="hm-cta-small">{{ __('guest.home.promo_small') }}</p>

                <p class="hm-cta-title">{{ __('guest.home.promo_headline') }}</p>

                <a href="{{ route('guest.service-requests.create') }}" class="hm-cta-btn">
                    {{ __('guest.home.request_service') }}
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>

            </div>

        </section>


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
