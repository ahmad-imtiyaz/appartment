@once
<style>
    .tp-balance{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        box-shadow:0 16px 32px -14px rgba(127,29,29,.40);
    }
    .tp-balance-label{font-size:12px;font-weight:600;color:#6B7280;}
    .tp-balance-value{
        margin-top:4px;
        font-size:24px;
        font-weight:800;
        color:#111827;
        line-height:1.15;
    }

    .tp-panel{
        background:#F9FAFB;
        border:1px solid #F1F1F1;
        border-radius:16px;
        padding:14px;
    }
    .tp-panel-title{font-size:12px;font-weight:800;color:#1F2937;margin-bottom:4px;}
    .tp-panel-hint{font-size:11px;color:#6B7280;line-height:1.5;margin-top:10px;}
    .tp-qr{
        display:inline-block;
        background:#fff;
        padding:12px;
        border-radius:16px;
        border:1px solid #F1F1F1;
    }
    .tp-qr img{width:192px;height:192px;object-fit:contain;display:block;}

    .tp-money{position:relative;}
    .tp-money > span{
        position:absolute;
        left:13px;top:50%;
        transform:translateY(-50%);
        font-size:13px;
        font-weight:700;
        color:#6B7280;
        pointer-events:none;
    }
    .tp-money .ui-input{padding-left:38px;}

    .tp-chips{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px;}
    .tp-chip{
        padding:6px 12px;
        border-radius:9999px;
        border:1px solid #FECACA;
        background:#FEF2F2;
        color:#B91C1C;
        font-size:11.5px;
        font-weight:700;
        cursor:pointer;
        transition:transform .15s ease,background .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .tp-chip:hover{background:#FEE2E2;}
    .tp-chip:active{transform:scale(.96);}

    .tp-amount-row{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        margin-top:12px;
        padding-top:12px;
        border-top:1px solid #F3F4F6;
    }
    .tp-amount-label{font-size:11px;color:#6B7280;}
    .tp-amount{font-size:16px;font-weight:800;color:#059669;}
</style>
@endonce

<div class="ui-card tp-balance ui-rise">

    <div class="min-w-0">
        <p class="tp-balance-label">{{ __('guest.topup.current_balance') }}</p>
        <p class="tp-balance-value">Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
    </div>

    <span class="ui-ico tone-red" style="width:46px;height:46px;border-radius:14px">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </span>

</div>
