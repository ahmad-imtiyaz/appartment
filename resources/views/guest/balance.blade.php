@extends('layouts.guest')

@section('title', __('guest.balance.title'))

@push('styles')
<style>
    :root{
        --red:#DC2626;
        --red-dark:#B91C1C;
        --pink-bg:#FDECEF;
        --pink-icon:#DB2777;
        --orange:#F97316;
        --green:#059669;
        --border:#F1F1F1;
    }

    /* ---------- Kartu saldo & koin ---------- */
    .wallet-card{
        background:linear-gradient(135deg, var(--red) 0%, var(--red-dark) 100%);
        border-radius:20px;
        padding:18px;
        color:#fff;
        box-shadow:0 8px 20px rgba(220,38,38,0.25);
    }
    .wallet-grid{
        display:grid;
        grid-template-columns:minmax(0,1fr) minmax(0,1fr);
        gap:12px;
    }
    .wallet-item{
        min-width:0;
        background:rgba(255,255,255,0.14);
        border-radius:14px;
        padding:12px 14px;
    }
    .wallet-label{
        display:flex;
        align-items:center;
        gap:6px;
        font-size:11.5px;
        color:rgba(255,255,255,0.85);
    }
    .wallet-label svg{width:14px;height:14px;flex-shrink:0;}
    .wallet-value{
        margin-top:6px;
        font-size:20px;
        font-weight:800;
        line-height:1.2;
        overflow:hidden;
        text-overflow:ellipsis;
        white-space:nowrap;
    }
    .wallet-value small{
        font-size:12px;
        font-weight:600;
        opacity:.9;
    }
    @media (max-width:360px){
        .wallet-value{font-size:17px;}
        .wallet-card{padding:14px;}
    }

    /* ---------- Tab filter ---------- */
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
    }
    .tab-btn{
        display:inline-flex;
        align-items:center;
        gap:6px;
        background:#F9FAFB;
        border:1px solid var(--border);
        border-bottom:none;
        color:#374151;
        font-size:13px;
        font-weight:600;
        padding:9px 18px;
        border-radius:999px 999px 0 0;
        white-space:nowrap;
        text-decoration:none;
        transition:background .15s ease, color .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .tab-btn svg{width:14px;height:14px;}
    .tab-btn.active{
        background:var(--red);
        border-color:var(--red);
        color:#fff;
    }
    .tab-panel-wrap{
        border-top:1px solid var(--border);
        padding:16px;
    }

    /* ---------- Kartu mutasi ---------- */
    .mutation-list{
        display:flex;
        flex-direction:column;
        gap:12px;
    }
    .mutation-card{
        position:relative;
        background:#fff;
        border-radius:16px;
        border:1px solid var(--border);
        box-shadow:0 1px 3px rgba(0,0,0,0.04);
        overflow:hidden;
    }
    .mutation-card::before{
        content:'';
        position:absolute;
        left:0;top:0;bottom:0;
        width:4px;
        background:var(--red);
    }
    .mutation-card.is-credit::before,
    .mutation-card.is-completed::before{background:var(--green);}
    .mutation-card.is-processing::before{background:var(--orange);}
    .mutation-card.is-cancelled::before{background:#9CA3AF;}

    .mutation-main{
        display:flex;
        align-items:center;
        gap:12px;
        padding:14px 14px 12px 18px;
        min-width:0;
    }
    .mutation-icon{
        width:42px;height:42px;
        min-width:42px;
        border-radius:12px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:var(--pink-bg);
        color:var(--red);
    }
    .mutation-icon svg{width:20px;height:20px;}
    .mutation-icon.credit{background:#ECFDF5;color:var(--green);}
    .mutation-icon.coin{background:#FFF7ED;color:var(--orange);}
    .mutation-icon.cancelled{background:#F3F4F6;color:#6B7280;}

    .mutation-info{
        flex:1 1 auto;
        min-width:0;
    }
    .mutation-title{
        font-size:14px;
        font-weight:700;
        color:#111827;
        line-height:1.3;
        overflow:hidden;
        display:-webkit-box;
        -webkit-line-clamp:2;
        -webkit-box-orient:vertical;
        word-break:break-word;
    }
    .mutation-sub{
        margin-top:3px;
        font-size:11.5px;
        color:#6B7280;
        display:flex;
        align-items:center;
        gap:4px;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }
    .mutation-sub svg{width:13px;height:13px;flex-shrink:0;}
    .mutation-amount{
        flex-shrink:0;
        text-align:right;
        font-size:15px;
        font-weight:800;
        white-space:nowrap;
    }
    .amount-debit{color:var(--red);}
    .amount-credit{color:var(--green);}
    .amount-cancelled{color:#9CA3AF;text-decoration:line-through;}

    .mutation-footer{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:8px;
        padding:10px 14px 12px 18px;
        border-top:1px dashed #EEE;
        background:#FCFCFD;
    }
    .type-pill{
        display:inline-flex;
        align-items:center;
        gap:5px;
        font-size:11px;
        font-weight:600;
        padding:4px 10px 4px 8px;
        border-radius:999px;
        white-space:nowrap;
    }
    .type-pill svg{width:14px;height:14px;flex-shrink:0;}
    .pill-debit{background:var(--pink-bg);color:var(--red-dark);}
    .pill-credit{background:#ECFDF5;color:var(--green);}
    .pill-processing{background:#FFF7ED;color:var(--orange);}
    .pill-cancelled{background:#F3F4F6;color:#6B7280;}

    .mutation-balance{
        font-size:11.5px;
        color:#9CA3AF;
        text-align:right;
        white-space:nowrap;
    }
    .mutation-balance strong{color:#6B7280;font-weight:600;}

    .empty-state{
        text-align:center;
        padding:40px 16px;
        color:#6B7280;
        background:#F9FAFB;
        border-radius:14px;
        border:1px dashed #E5E7EB;
    }

    @media (max-width:360px){
        .mutation-main{gap:10px;padding:12px 12px 10px 16px;}
        .mutation-footer{padding:10px 12px 12px 16px;}
        .mutation-icon{width:36px;height:36px;min-width:36px;}
        .mutation-amount{font-size:14px;}
    }
</style>
@endpush

@section('header')
    <h2 class="font-bold text-lg text-gray-900">
        {{ __('guest.balance.title') }}
    </h2>
@endsection

@section('content')
@php
    $filter = in_array($filter ?? request('filter'), ['saldo', 'koin']) ? ($filter ?? request('filter')) : 'all';

    $iconCoin  = 'M12 2a10 10 0 100 20 10 10 0 000-20zm0 3.5a1 1 0 011 1V7h.75a1 1 0 110 2H13v1h.5a2.5 2.5 0 010 5H13v.5a1 1 0 11-2 0V15h-.75a1 1 0 110-2H11v-1h-.5a2.5 2.5 0 010-5H11v-.5a1 1 0 011-1z';
    $iconWallet = 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z';
    $iconOut   = 'M7 17L17 7m0 0H8m9 0v9';
    $iconIn    = 'M17 7L7 17m0 0h9m-9 0V8';
    $iconClock = 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
    $iconAll   = 'M4 6h16M4 12h16M4 18h16';
@endphp

<div class="px-4 pt-4 pb-6 space-y-4">

    @if (session('success'))
        <div class="p-3 bg-green-50 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="p-3 bg-red-50 text-red-800 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    {{-- Saldo & Koin --}}
    <div class="wallet-card">
        <div class="wallet-grid">
            <div class="wallet-item">
                <div class="wallet-label">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconWallet }}"/>
                    </svg>
                    {{ __('guest.balance.current_balance') }}
                </div>
                <div class="wallet-value">Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}</div>
            </div>
            <div class="wallet-item">
                <div class="wallet-label">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="{{ $iconCoin }}"/>
                    </svg>
                    {{ __('guest.balance.your_coins') }}
                </div>
                <div class="wallet-value">
                    {{ number_format(auth()->user()->coin_balance) }} <small>{{ __('guest.balance.coin_unit') }}</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter + daftar --}}
   {{-- Filter + daftar --}}
<div class="tab-row">
    <nav class="tab-pillbar" aria-label="{{ __('guest.balance.filter_aria') }}">
        <a href="{{ route('guest.balance', ['filter' => 'all']) }}"
           class="tab-btn {{ $filter === 'all' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconAll }}"/>
            </svg>
            {{ __('guest.balance.tab_all') }}
        </a>
        <a href="{{ route('guest.balance', ['filter' => 'saldo']) }}"
           class="tab-btn {{ $filter === 'saldo' ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconWallet }}"/>
            </svg>
            {{ __('guest.balance.tab_balance') }}
        </a>
        <a href="{{ route('guest.balance', ['filter' => 'koin']) }}"
           class="tab-btn {{ $filter === 'koin' ? 'active' : '' }}">
            <svg fill="currentColor" viewBox="0 0 24 24">
                <path d="{{ $iconCoin }}"/>
            </svg>
            {{ __('guest.balance.tab_coin') }}
        </a>
    </nav>

    <div class="tab-panel-wrap">
        @if ($mutations->isEmpty())
            <div class="empty-state">
                <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="mt-2 text-sm">
                    @if ($filter === 'saldo') {{ __('guest.balance.empty_balance') }}
                    @elseif ($filter === 'koin') {{ __('guest.balance.empty_coin') }}
                    @else {{ __('guest.balance.empty_all') }}
                    @endif
                </p>
            </div>
        @else
            <div class="mutation-list">
                @foreach ($mutations as $mutation)
                    @php
                        $isCredit = $mutation->direction === 'in';
                        $isCoin = $mutation->kind === 'koin';
                        $unitLabel = $isCoin ? __('guest.balance.unit_coin') : __('guest.balance.unit_balance');
                    @endphp
                    <div class="mutation-card {{ $isCredit ? 'is-credit' : 'is-debit' }}">
                        <div class="mutation-main">
                            <div class="mutation-icon {{ $isCredit ? 'credit' : '' }} {{ $isCoin ? 'coin' : '' }}">
                                @if ($isCoin)
                                    <svg fill="currentColor" viewBox="0 0 24 24">
                                        <path d="{{ $iconCoin }}"/>
                                    </svg>
                                @else
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $isCredit ? $iconIn : $iconOut }}"/>
                                    </svg>
                                @endif
                            </div>

                            <div class="mutation-info">
                                <p class="mutation-title">{{ $mutation->description }}</p>
                                <p class="mutation-sub">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconClock }}"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($mutation->created_at)->format('d M Y, H:i') }}
                                </p>
                            </div>

                            <div class="mutation-amount {{ $isCredit ? 'amount-credit' : 'amount-debit' }}">
                                {{ $isCredit ? '+' : '-' }}{{ $isCoin ? number_format($mutation->amount) . ' ' . __('guest.balance.coin_unit') : 'Rp' . number_format($mutation->amount, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="mutation-footer">
                            <span class="type-pill {{ $isCredit ? 'pill-credit' : 'pill-debit' }}">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" aria-hidden="true">
                                    @if ($isCoin)
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="{{ $iconCoin }}"/>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $isCredit ? $iconIn : $iconOut }}"/>
                                    @endif
                                </svg>
                                {{ $isCredit ? __('guest.balance.in') : __('guest.balance.out') }} &middot; {{ $unitLabel }}
                                @if ($mutation->reference_type)
                                    <span style="opacity:.75;font-weight:500;">&middot; {{ class_basename($mutation->reference_type) }} #{{ $mutation->reference_id }}</span>
                                @endif
                            </span>
                            <span class="mutation-balance">
                                {{ $unitLabel }}: <strong>{{ $isCoin ? number_format($mutation->balance_after) : 'Rp' . number_format($mutation->balance_after, 0, ',', '.') }}</strong>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $mutations->links() }}
            </div>
        @endif
    </div>
</div>
</div>
@endsection
