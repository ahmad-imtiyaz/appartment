@once
<style>
    :root{
        --red:#DC2626;
        --red-dark:#B91C1C;
        --ink:#111827;
        --muted:#6B7280;
        --line:#F1F1F1;
    }

    /* ============ LAYOUT ============ */
    .ui-page{
        max-width:480px;
        margin-left:auto;
        margin-right:auto;
        width:100%;
        min-height:100vh;
        overflow-x:hidden;
        background:#F8F9FB;
        padding-bottom:28px;
    }
    @media (min-width:481px){
        .ui-page{box-shadow:0 0 0 1px rgba(0,0,0,.04);}
    }
    .ui-body{padding:0 16px;}
    .ui-body--top{padding-top:22px;}
    .ui-stack > * + *{margin-top:16px;}
    .ui-form > * + *{margin-top:14px;}
    .ui-pull{position:relative;z-index:2;margin-top:-44px;}

    /* ============ HERO ============ */
    .ui-hero{
        position:relative;
        overflow:hidden;
        padding:16px 18px 64px;
        color:#fff;
        background:linear-gradient(160deg,#7F1D1D 0%,#B91C1C 48%,#DC2626 100%);
        border-radius:0 0 32px 32px;
    }
    .ui-hero::before{
        content:"";
        position:absolute;
        width:260px;height:260px;
        right:-90px;top:-100px;
        border-radius:50%;
        background:radial-gradient(circle,rgba(255,255,255,.20),rgba(255,255,255,0) 70%);
    }
    .ui-hero::after{
        content:"";
        position:absolute;
        width:220px;height:220px;
        left:-90px;bottom:-120px;
        border-radius:50%;
        background:radial-gradient(circle,rgba(255,255,255,.12),rgba(255,255,255,0) 70%);
    }
    .ui-hero > *{position:relative;z-index:1;}
    .ui-hero-row{display:flex;align-items:center;gap:12px;}
    .ui-back{
        width:38px;height:38px;
        border-radius:9999px;
        background:rgba(255,255,255,.16);
        border:1px solid rgba(255,255,255,.25);
        display:flex;align-items:center;justify-content:center;
        color:#fff;
        flex-shrink:0;
        text-decoration:none;
        transition:background .15s ease;
    }
    .ui-back:hover{background:rgba(255,255,255,.26);}
    .ui-hero-icon{
        width:46px;height:46px;
        border-radius:14px;
        background:rgba(255,255,255,.16);
        border:1px solid rgba(255,255,255,.28);
        display:flex;align-items:center;justify-content:center;
        flex-shrink:0;
    }
    .ui-hero-icon svg{width:24px;height:24px;}
    .ui-hero-title{
        font-size:20px;
        font-weight:800;
        line-height:1.2;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }
    .ui-hero-sub{
        margin-top:3px;
        font-size:12px;
        line-height:1.4;
        color:rgba(255,255,255,.78);
        display:-webkit-box;
        -webkit-line-clamp:2;
        -webkit-box-orient:vertical;
        overflow:hidden;
    }
    .ui-chip{
        display:inline-flex;
        align-items:center;
        gap:6px;
        margin-top:14px;
        padding:7px 12px;
        border-radius:9999px;
        background:rgba(255,255,255,.16);
        border:1px solid rgba(255,255,255,.25);
        font-size:12px;
        font-weight:600;
    }
    .ui-chip b{font-weight:800;}

    /* ============ CARD & TEXT ============ */
    .ui-card{
        background:#fff;
        border:1px solid var(--line);
        border-radius:20px;
        padding:16px;
        box-shadow:0 1px 2px rgba(17,24,39,.04);
    }
    .ui-heading{font-size:15px;font-weight:800;color:var(--ink);line-height:1.25;}
    .ui-sub{font-size:12px;color:var(--muted);margin-top:3px;}
    .ui-sec-head{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:12px;}
    .ui-count{
        background:#FEF2F2;
        color:var(--red-dark);
        font-size:11px;
        font-weight:800;
        padding:4px 10px;
        border-radius:9999px;
        white-space:nowrap;
    }
    .ui-divider{border-top:1px solid #F3F4F6;margin-top:16px;padding-top:16px;}

    /* ============ ALERT ============ */
    .ui-alert{border-radius:14px;padding:11px 13px;font-size:12.5px;line-height:1.45;border:1px solid;}
    .ui-alert--success{background:#F0FDF4;border-color:#BBF7D0;color:#166534;}
    .ui-alert--error{background:#FEF2F2;border-color:#FECACA;color:#991B1B;}
    .ui-alert--warn{background:#FFF7ED;border-color:#FED7AA;color:#9A3412;}
    .ui-alert ul{list-style:disc;padding-left:18px;margin-top:4px;}

    /* ============ FORM ============ */
    .ui-label{display:block;font-size:12px;font-weight:700;color:#374151;margin-bottom:6px;}
    .ui-input{
        display:block;
        width:100%;
        box-sizing:border-box;
        border:1px solid #E5E7EB;
        border-radius:12px;
        padding:11px 13px;
        font-size:13px;
        color:var(--ink);
        background:#fff;
        outline:none;
        transition:border-color .15s ease,box-shadow .15s ease;
    }
    .ui-input:focus{border-color:var(--red);box-shadow:0 0 0 3px rgba(220,38,38,.10);}
    .ui-hint{font-size:11px;color:#9CA3AF;margin-top:5px;}
    .ui-upload{border:1px dashed #D1D5DB;border-radius:14px;padding:12px;background:#FAFAFA;}

    /* ============ BUTTON ============ */
    .ui-btn{
        display:flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        width:100%;
        box-sizing:border-box;
        padding:13px 14px;
        border-radius:14px;
        border:1px solid transparent;
        font-size:13px;
        font-weight:800;
        text-decoration:none;
        cursor:pointer;
        transition:transform .15s ease,box-shadow .15s ease,background .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .ui-btn:active{transform:scale(.98);}
    .ui-btn--primary{
        background:linear-gradient(135deg,#DC2626,#B91C1C);
        color:#fff;
        box-shadow:0 8px 16px -6px rgba(220,38,38,.55);
    }
    .ui-btn--outline{background:#fff;color:var(--red-dark);border-color:#FECACA;}
    .ui-btn--outline:hover{background:#FEF2F2;}
    .ui-btn--soft{background:#FEF2F2;color:var(--red-dark);}
    .ui-btn--soft:hover{background:#FEE2E2;}
    .ui-btn--sm{width:auto;padding:7px 12px;font-size:11.5px;border-radius:10px;}
    .ui-btn svg{width:16px;height:16px;}

    /* ============ ICON TONES ============ */
    .ui-ico{
        width:40px;height:40px;
        border-radius:12px;
        background:var(--tint,#FEE2E2);
        color:var(--ink-c,#DC2626);
        display:flex;align-items:center;justify-content:center;
        flex-shrink:0;
    }
    .ui-ico svg{width:22px;height:22px;}
    .tone-red{--tint:#FEE2E2;--ink-c:#DC2626;}
    .tone-rose{--tint:#FFE4E6;--ink-c:#E11D48;}
    .tone-sky{--tint:#E0F2FE;--ink-c:#0284C7;}
    .tone-blue{--tint:#DBEAFE;--ink-c:#2563EB;}
    .tone-cyan{--tint:#CFFAFE;--ink-c:#0891B2;}
    .tone-teal{--tint:#CCFBF1;--ink-c:#0D9488;}
    .tone-emerald{--tint:#D1FAE5;--ink-c:#059669;}
    .tone-amber{--tint:#FEF3C7;--ink-c:#D97706;}
    .tone-orange{--tint:#FFEDD5;--ink-c:#EA580C;}
    .tone-indigo{--tint:#E0E7FF;--ink-c:#4F46E5;}
    .tone-purple{--tint:#F3E8FF;--ink-c:#9333EA;}

    /* ============ SERVICE TILE (index) ============ */
    .ui-grid2{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;}
    .ui-svc{
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
    .ui-svc:hover{box-shadow:0 12px 24px -12px rgba(17,24,39,.22);border-color:#E5E7EB;transform:translateY(-2px);}
    .ui-svc:active{transform:scale(.97);}
    .ui-svc .ui-ico{width:46px;height:46px;border-radius:14px;}
    .ui-svc .ui-ico svg{width:24px;height:24px;}
    .ui-svc-title{font-size:14px;font-weight:800;color:var(--ink);line-height:1.2;}
    .ui-svc-desc{font-size:11px;color:var(--muted);line-height:1.4;margin-top:-6px;}
    .ui-svc-arrow{
        position:absolute;
        top:14px;right:14px;
        width:26px;height:26px;
        border-radius:50%;
        background:#F3F4F6;
        color:#9CA3AF;
        display:flex;align-items:center;justify-content:center;
        transition:background .18s ease,color .18s ease;
    }
    .ui-svc-arrow svg{width:13px;height:13px;}
    .ui-svc:hover .ui-svc-arrow{background:var(--ink-c,#DC2626);color:#fff;}

    /* ============ OPTION TILE (radio & link) ============ */
    .ui-opts{display:grid;gap:10px;margin-top:12px;}
    .ui-opts--3{grid-template-columns:repeat(3,minmax(0,1fr));}
    .ui-opts--2{grid-template-columns:repeat(2,minmax(0,1fr));}

    .ui-opt{position:relative;display:block;cursor:pointer;-webkit-tap-highlight-color:transparent;}
    .ui-opt input{position:absolute;opacity:0;pointer-events:none;}
    .ui-opt-box,
    .ui-tile{
        position:relative;
        display:flex;
        flex-direction:column;
        align-items:center;
        gap:8px;
        padding:12px 6px;
        text-align:center;
        border-radius:16px;
        border:2px solid #F3F4F6;
        background:#F9FAFB;
        text-decoration:none;
        transition:border-color .18s ease,background .18s ease,box-shadow .18s ease,transform .15s ease;
    }
    .ui-opt-box--row{flex-direction:row;text-align:left;padding:12px;gap:10px;}
    .ui-opt:hover .ui-opt-box,
    .ui-tile:hover{border-color:#FECACA;background:#fff;}
    .ui-tile:active{transform:scale(.97);}
    .ui-opt input:checked + .ui-opt-box{
        border-color:var(--red);
        background:#FEF2F2;
        box-shadow:0 8px 16px -10px rgba(220,38,38,.55);
    }
    .ui-opt input:checked + .ui-opt-box::after{
        content:"";
        position:absolute;
        top:6px;right:6px;
        width:16px;height:16px;
        border-radius:50%;
        background:var(--red) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='white'%3E%3Cpath d='M7.7 14.3L3.4 10l1.4-1.4 2.9 2.9 7.5-7.5 1.4 1.4z'/%3E%3C/svg%3E") center/11px no-repeat;
    }
    .ui-opt input:focus-visible + .ui-opt-box{outline:2px solid var(--red);outline-offset:2px;}
    .ui-opt-name{font-size:11.5px;font-weight:700;color:#374151;line-height:1.25;}
    .ui-opt-desc{font-size:10px;color:#9CA3AF;margin-top:1px;}
    .ui-tile-ico{
        width:46px;height:46px;
        border-radius:14px;
        display:flex;align-items:center;justify-content:center;
        flex-shrink:0;
    }

    /* ============ PRICE BOX ============ */
    .ui-price{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        padding:14px;
        border-radius:16px;
        background:linear-gradient(135deg,#FEF2F2,#FFF7ED);
        border:1px solid #FECACA;
    }
    .ui-price-label{font-size:11px;font-weight:700;color:var(--red-dark);}
    .ui-price-name{font-size:13px;font-weight:800;color:#991B1B;}
    .ui-price-value{font-size:20px;font-weight:800;color:#991B1B;line-height:1.1;}
    .ui-price-note{font-size:10.5px;color:#9CA3AF;}
    .ui-price-warn{font-size:10.5px;font-weight:600;color:#EA580C;margin-top:2px;}

    /* ============ PILL, ROW, EMPTY ============ */
    .ui-pill{
        display:inline-flex;
        align-items:center;
        padding:4px 10px;
        border-radius:9999px;
        font-size:10px;
        font-weight:800;
        white-space:nowrap;
        background:#F3F4F6;
        color:#374151;
        flex-shrink:0;
    }
    .ui-pill--pending{background:#FEF9C3;color:#854D0E;}
    .ui-pill--assigned{background:#DBEAFE;color:#1E40AF;}
    .ui-pill--in_progress{background:#F3E8FF;color:#6B21A8;}
    .ui-pill--waiting_approval{background:#FFEDD5;color:#9A3412;}
    .ui-pill--completed{background:#DCFCE7;color:#166534;}
    .ui-pill--rejected{background:#FEE2E2;color:#991B1B;}

    .ui-row{
        display:block;
        padding:12px;
        background:#fff;
        border:1px solid var(--line);
        border-radius:16px;
        text-decoration:none;
        color:inherit;
        box-shadow:0 1px 2px rgba(17,24,39,.04);
        transition:transform .15s ease,box-shadow .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    a.ui-row:hover{box-shadow:0 10px 20px -12px rgba(17,24,39,.25);}
    a.ui-row:active{transform:scale(.98);}
    .ui-row-main{display:flex;align-items:center;gap:12px;}
    .ui-row-title{font-size:13.5px;font-weight:800;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .ui-row-meta{font-size:11px;color:var(--muted);margin-top:2px;}
    .ui-row-foot{margin-top:10px;padding-top:10px;border-top:1px solid #F3F4F6;font-size:12px;font-weight:700;color:var(--red);}

    .ui-empty{
        text-align:center;
        padding:28px 16px;
        border:1px dashed #D1D5DB;
        border-radius:16px;
        background:#fff;
        color:var(--muted);
        font-size:12.5px;
    }
    .ui-empty svg{width:40px;height:40px;margin:0 auto 8px;color:#D1D5DB;display:block;}

    /* ============ KEY-VALUE ============ */
    .ui-kv-item{
        display:flex;
        justify-content:space-between;
        gap:16px;
        padding:11px 0;
        border-bottom:1px solid #F3F4F6;
        font-size:12.5px;
    }
    .ui-kv-item:last-child{border-bottom:0;padding-bottom:0;}
    .ui-kv-item dt{color:var(--muted);flex-shrink:0;}
    .ui-kv-item dd{font-weight:700;color:var(--ink);text-align:right;min-width:0;word-break:break-word;}
    .ui-kv-item dd.is-price{color:var(--red);font-size:14px;}
    .ui-note{margin-top:14px;padding:12px;border-radius:14px;font-size:12.5px;line-height:1.5;background:#F9FAFB;color:#374151;}
    .ui-note--info{background:#EFF6FF;color:#1E40AF;}
    .ui-note-title{display:block;font-size:11px;font-weight:700;color:var(--muted);margin-bottom:4px;}
    .ui-note--info .ui-note-title{color:#3B82F6;}

    /* ============ RATING ============ */
    .ui-rate{position:relative;display:flex;flex-direction:row-reverse;justify-content:flex-end;gap:4px;}
    .ui-rate input{position:absolute;opacity:0;pointer-events:none;}
    .ui-rate label{cursor:pointer;color:#E5E7EB;line-height:0;transition:color .15s ease,transform .15s ease;}
    .ui-rate label svg{width:34px;height:34px;}
    .ui-rate label:active{transform:scale(.9);}
    .ui-rate input:checked ~ label,
    .ui-rate label:hover,
    .ui-rate label:hover ~ label{color:#FBBF24;}
    .ui-rate input:focus-visible + label{outline:2px solid var(--red);border-radius:6px;}
    .ui-stars{display:flex;gap:3px;}
    .ui-stars svg{width:20px;height:20px;color:#E5E7EB;}
    .ui-stars svg.on{color:#FBBF24;}

    /* ============ ANIMASI ============ */
    @keyframes ui-rise{
        from{opacity:0;transform:translateY(12px);}
        to{opacity:1;transform:translateY(0);}
    }
    .ui-rise{animation:ui-rise .45s ease both;}
    @media (prefers-reduced-motion:reduce){
        .ui-rise{animation:none;}
        .ui-svc,.ui-btn,.ui-row,.ui-tile,.ui-opt-box{transition:none;}
    }
</style>
@endonce
