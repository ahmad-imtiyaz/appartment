<style>
    .hc-top{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:16px}
    .hc-brand{display:flex;align-items:center;gap:8px;min-width:0}
    .notif-btn{position:relative;width:38px;height:38px;border-radius:9999px;background:#F9FAFB;border:1px solid #F1F1F1;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .notif-btn:hover{background:#F3F4F6}
    .notif-badge{position:absolute;top:-5px;right:-5px;min-width:18px;height:18px;padding:0 4px;border-radius:9999px;background:#DC2626;color:#fff;font-size:10px;font-weight:700;line-height:1;display:flex;align-items:center;justify-content:center;border:2px solid #fff;box-sizing:border-box}

    /* ---------- Tombol Top Up & Change Point ---------- */
    .hc-actions{
        display:grid;
        grid-template-columns:minmax(0,1fr) minmax(0,1fr);
        gap:10px;
        margin-top:14px;
        padding-top:14px;
        border-top:1px dashed #E5E7EB;
    }
    .hc-action{
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        min-width:0;
        background:#fff;
        border:1px solid #F1F1F1;
        border-radius:12px;
        padding:9px 10px;
        text-decoration:none;
        box-shadow:0 1px 3px rgba(0,0,0,0.05);
        transition:transform .15s ease, background .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .hc-action:active{transform:scale(0.97);background:#F9FAFB;}
    .hc-action-icon{
        width:30px;height:30px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        flex-shrink:0;
        color:#fff;
    }
    .hc-action-icon svg{width:16px;height:16px;}
    .hc-action-icon.orange{background:#F97316;}
    .hc-action-icon.red{background:#DC2626;}
    .hc-action-label{
        font-size:13px;
        font-weight:700;
        color:#1F2937;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }
    @media (max-width:360px){
        .hc-action{gap:6px;padding:8px 6px;}
        .hc-action-icon{width:26px;height:26px;}
        .hc-action-label{font-size:12px;}
    }
</style>

<div class="header-card p-4">
    <div class="hc-top">
        <div class="hc-brand">
            <div class="brand-icon flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.5L2 11h3v9h5v-6h4v6h5v-9h3L12 2.5z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="font-bold text-gray-900 leading-tight text-sm truncate">OREGONET</p>
                <p class="text-[10px] text-gray-500 leading-tight italic truncate">Apartment Services</p>
            </div>
        </div>

        <a href="{{ route('guest.balance') }}" class="notif-btn" aria-label="Notifikasi">
            <svg width="20" height="20" fill="none" stroke="#4B5563" viewBox="0 0 24 24" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
            @if(($notifCount ?? 0) > 0)
                <span class="notif-badge">{{ $notifCount > 99 ? '99+' : $notifCount }}</span>
            @endif
        </a>
    </div>

    <div class="flex items-center justify-between gap-2">
        <p class="text-gray-800 text-sm min-w-0">
            {{ __('Welcome,') }}<br>
            <span class="text-[19px] font-extrabold text-gray-900 block truncate">{{ auth()->user()->name }}</span>
        </p>

        <div class="house-badge flex items-center justify-center shrink-0">
            <svg class="w-16 h-16 text-white" viewBox="0 0 64 64" fill="none">
                <path d="M32 8L12 24v28h14V38h12v14h14V24L32 8z" fill="white"/>
                <path d="M14 46c-2 1-4 3-4 6 0 2 1.5 3.5 3.5 3.5h37c2 0 3.5-1.5 3.5-3.5 0-3-2-5-4-6" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M14 46c1.5-2.5 3.5-4 6-4h24c2.5 0 4.5 1.5 6 4" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round"/>
            </svg>
        </div>
    </div>

    <div class="balance-strip mt-4 p-4">
        <div class="min-w-0">
            <p class="text-sm text-gray-700 truncate">
                Balance : <span class="font-bold text-gray-900">Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}</span>
            </p>
            <p class="text-sm text-gray-700 mt-1 truncate">
                Oregonet Point : <span class="font-bold text-orange-500">{{ auth()->user()->coin_balance }} point</span>
            </p>
        </div>

        <div class="hc-actions">
            <a href="{{ route('guest.topups.create') }}" class="hc-action">
                <span class="hc-action-icon orange">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </span>
                <span class="hc-action-label">Top Up</span>
            </a>
            <a href="{{ route('guest.coin-redemptions.index') }}" class="hc-action">
                <span class="hc-action-icon red">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                <span class="hc-action-label">Change Point</span>
            </a>
        </div>
    </div>
</div>
