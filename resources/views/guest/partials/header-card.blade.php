<style>
    /* ============ HERO ============ */
    .hx-hero{
        position:relative;
        overflow:hidden;
        padding:18px 18px 76px;
        color:#fff;
        background:linear-gradient(160deg,#7F1D1D 0%,#B91C1C 48%,#DC2626 100%);
        border-radius:0 0 32px 32px;
    }
    .hx-hero::before{
        content:"";
        position:absolute;
        width:280px;height:280px;
        right:-100px;top:-100px;
        border-radius:50%;
        background:radial-gradient(circle,rgba(255,255,255,.20),rgba(255,255,255,0) 70%);
    }
    .hx-hero::after{
        content:"";
        position:absolute;
        width:240px;height:240px;
        left:-90px;bottom:-120px;
        border-radius:50%;
        background:radial-gradient(circle,rgba(255,255,255,.12),rgba(255,255,255,0) 70%);
    }
    .hx-hero > *{position:relative;z-index:1;}

    .hx-top{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
    }
    .hx-brand{display:flex;align-items:center;gap:10px;min-width:0;}
    .hx-logo{
        width:40px;height:40px;
        border-radius:12px;
        background:rgba(255,255,255,.16);
        border:1px solid rgba(255,255,255,.28);
        display:flex;align-items:center;justify-content:center;
        flex-shrink:0;
        backdrop-filter:blur(6px);
        -webkit-backdrop-filter:blur(6px);
    }
    .hx-brand-name{
        font-size:15px;
        font-weight:800;
        letter-spacing:.08em;
        line-height:1.1;
    }
    .hx-brand-tag{
        font-size:10px;
        color:rgba(255,255,255,.75);
        line-height:1.2;
        margin-top:2px;
    }

    .hx-right{display:flex;align-items:center;gap:8px;flex-shrink:0;}

    /* Pilih bahasa */
    .hx-lang{
        display:flex;
        align-items:center;
        height:36px;
        padding:3px;
        box-sizing:border-box;
        background:rgba(255,255,255,.16);
        border:1px solid rgba(255,255,255,.25);
        border-radius:9999px;
    }
    .hx-lang a{
        display:flex;
        align-items:center;
        justify-content:center;
        min-width:32px;
        height:28px;
        padding:0 8px;
        border-radius:9999px;
        font-size:11px;
        font-weight:700;
        letter-spacing:.04em;
        color:rgba(255,255,255,.85);
        text-decoration:none;
        transition:background .15s ease,color .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .hx-lang a.active{
        background:#fff;
        color:#B91C1C;
        box-shadow:0 1px 3px rgba(0,0,0,.18);
    }

    /* Notifikasi */
    .hx-bell{
        position:relative;
        width:38px;height:38px;
        border-radius:9999px;
        background:rgba(255,255,255,.16);
        border:1px solid rgba(255,255,255,.25);
        display:flex;align-items:center;justify-content:center;
        flex-shrink:0;
        transition:background .15s ease;
    }
    .hx-bell:hover{background:rgba(255,255,255,.26);}
    .hx-badge{
        position:absolute;
        top:-5px;right:-5px;
        min-width:18px;height:18px;
        padding:0 4px;
        box-sizing:border-box;
        border-radius:9999px;
        background:#FBBF24;
        color:#7C2D12;
        font-size:10px;
        font-weight:800;
        line-height:1;
        display:flex;align-items:center;justify-content:center;
        border:2px solid #B91C1C;
    }

    .hx-greet{margin-top:22px;}
    .hx-greet small{
        display:block;
        font-size:13px;
        color:rgba(255,255,255,.78);
    }
    .hx-greet strong{
        display:block;
        margin-top:2px;
        font-size:24px;
        font-weight:800;
        line-height:1.2;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    /* ============ WALLET CARD ============ */
    .hx-wallet{
        position:relative;
        z-index:2;
        margin:-54px 16px 0;
        background:#fff;
        border:1px solid #F3F4F6;
        border-radius:22px;
        padding:16px;
        box-shadow:0 16px 32px -14px rgba(127,29,29,.40);
    }
    .hx-stats{
        display:grid;
        grid-template-columns:minmax(0,1fr) 1px minmax(0,1fr);
        align-items:center;
        gap:14px;
    }
    .hx-divider{height:34px;background:#E5E7EB;}
    .hx-stat-label{
        display:flex;
        align-items:center;
        gap:6px;
        font-size:11px;
        font-weight:600;
        color:#6B7280;
    }
    .hx-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
    .hx-stat-value{
        margin-top:4px;
        font-size:18px;
        font-weight:800;
        color:#111827;
        line-height:1.15;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }
    .hx-stat-value.points{color:#EA580C;}
    .hx-stat-value small{font-size:11px;font-weight:700;color:#9CA3AF;margin-left:2px;}

    .hx-actions{
        display:grid;
        grid-template-columns:minmax(0,1fr) minmax(0,1fr);
        gap:10px;
        margin-top:14px;
    }
    .hx-btn{
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        min-width:0;
        padding:11px 10px;
        border-radius:14px;
        font-size:13px;
        font-weight:700;
        text-decoration:none;
        transition:transform .15s ease,background .15s ease,box-shadow .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .hx-btn svg{width:18px;height:18px;flex-shrink:0;}
    .hx-btn span{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .hx-btn:active{transform:scale(.97);}
    .hx-btn--primary{
        background:linear-gradient(135deg,#DC2626,#B91C1C);
        color:#fff;
        box-shadow:0 6px 14px -4px rgba(220,38,38,.55);
    }
    .hx-btn--ghost{
        background:#FFF7ED;
        color:#C2410C;
        border:1px solid #FED7AA;
    }
    .hx-btn--ghost:active{background:#FFEDD5;}

        .hx-link{
        display:flex;
        align-items:center;
        justify-content:center;
        gap:6px;
        margin-top:12px;
        padding-top:12px;
        border-top:1px solid #F3F4F6;
        font-size:12.5px;
        font-weight:700;
        color:#DC2626;
        text-decoration:none;
        -webkit-tap-highlight-color:transparent;
    }
    .hx-link svg{width:15px;height:15px;flex-shrink:0;}
    .hx-link:active{opacity:.7;}

    @media (max-width:360px){
        .hx-greet strong{font-size:21px;}
        .hx-stat-value{font-size:16px;}
        .hx-btn{font-size:12px;gap:6px;}
    }
</style>

{{-- Hero --}}
<div class="hx-hero">

    <div class="hx-top">

        <div class="hx-brand">
            <div class="hx-logo">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.5L2 11h3v9h5v-6h4v6h5v-9h3L12 2.5z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="hx-brand-name">OREGONET</p>
                <p class="hx-brand-tag truncate">{{ __('guest.header.tagline') }}</p>
            </div>
        </div>

        <div class="hx-right">

            {{-- Pilih bahasa --}}
            <div class="hx-lang">
                <a href="{{ route('lang.switch', 'id') }}"
                   class="{{ app()->getLocale() === 'id' ? 'active' : '' }}"
                   title="{{ __('guest.lang.switch_to_id') }}"
                   aria-label="{{ __('guest.lang.switch_to_id') }}"
                   @if(app()->getLocale() === 'id') aria-current="true" @endif>ID</a>
                <a href="{{ route('lang.switch', 'en') }}"
                   class="{{ app()->getLocale() === 'en' ? 'active' : '' }}"
                   title="{{ __('guest.lang.switch_to_en') }}"
                   aria-label="{{ __('guest.lang.switch_to_en') }}"
                   @if(app()->getLocale() === 'en') aria-current="true" @endif>EN</a>
            </div>

            {{-- Notifikasi --}}
            <a href="{{ route('guest.balance') }}"
               class="hx-bell"
               aria-label="{{ __('guest.header.notifications') }}">
                <svg width="19" height="19" fill="none" stroke="#fff" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                @if (($notifCount ?? 0) > 0)
                    <span class="hx-badge">{{ $notifCount > 99 ? '99+' : $notifCount }}</span>
                @endif
            </a>

        </div>

    </div>

    <div class="hx-greet">
        <small>{{ __('guest.header.welcome') }}</small>
        <strong>{{ auth()->user()->name }}</strong>
    </div>

</div>

{{-- Wallet --}}
<div class="hx-wallet">

    <div class="hx-stats">

        <div class="min-w-0">
            <p class="hx-stat-label">
                <span class="hx-dot" style="background:#DC2626"></span>
                {{ __('guest.header.balance') }}
            </p>
            <p class="hx-stat-value">
                Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}
            </p>
        </div>

        <div class="hx-divider"></div>

        <div class="min-w-0">
            <p class="hx-stat-label">
                <span class="hx-dot" style="background:#F97316"></span>
                {{ __('guest.header.points') }}
            </p>
            <p class="hx-stat-value points">
                {{ auth()->user()->coin_balance }}<small>{{ __('guest.header.points_unit') }}</small>
            </p>
        </div>

    </div>

    <div class="hx-actions">

        <a href="{{ route('guest.topups.create') }}" class="hx-btn hx-btn--primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span>{{ __('guest.header.top_up') }}</span>
        </a>

        <a href="{{ route('guest.coin-redemptions.index') }}" class="hx-btn hx-btn--ghost">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
            </svg>
            <span>{{ __('guest.header.change_point') }}</span>
        </a>

    </div>

      <a href="{{ route('guest.withdrawals.create') }}" class="hx-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-5 5m5-5l5 5"/>
            </svg>
            {{ __('guest.withdraw.title') }}
        </a>

</div>
