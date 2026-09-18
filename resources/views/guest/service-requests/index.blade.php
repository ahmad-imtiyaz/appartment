@extends('layouts.guest')

@section('title', 'Layanan Jasa')

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

    /* Wrapper supaya tampilan mobile-app tetap rapi di layar lebar */
    .jasa-wrapper{
        max-width: 480px;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        overflow-x: hidden;
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
    .house-badge{
        width:92px;height:92px;
        background:var(--red);
        border-radius:20px;
        flex-shrink:0;
    }
    .balance-strip{
        background:#F9FAFB;
        border-radius:14px;
    }
    .action-circle{
        width:42px;height:42px;border-radius:50%;
        box-shadow:0 2px 4px rgba(0,0,0,0.08);
        transition:transform .15s ease;
        flex-shrink:0;
    }
    .action-circle:active{transform:scale(0.92);}
    .action-circle.orange{background:var(--orange);}
    .action-circle.red{background:var(--red);}

    .service-card{
        background:#fff;
        border:1px solid #F1F1F1;
        border-radius:18px;
        padding:16px 10px 14px;
        box-shadow:0 2px 8px rgba(0,0,0,0.04);
        transition:transform .15s ease, box-shadow .15s ease, border-color .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .service-card:active{
        transform:scale(0.96);
        box-shadow:0 1px 4px rgba(0,0,0,0.06);
    }
    .service-icon{
        width:52px;height:52px;
        background:linear-gradient(155deg,#FDECEF 0%,#FBD9E1 100%);
        border-radius:14px;
        transition:background .15s ease;
        margin-left:auto;
        margin-right:auto;
    }
    .service-card:active .service-icon{background:#FBD5E0;}
    .service-icon svg{color:var(--pink-icon);stroke-width:1.6;}
    .service-label{
        font-size:12px;
        font-weight:600;
        color:#374151;
        text-align:center;
        line-height:1.25;
        margin-top:10px;
    }

    .order-card{
        background:#fff;
        border-radius:16px;
        box-shadow:0 1px 3px rgba(0,0,0,0.05);
        transition:transform .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .order-card:active{transform:scale(0.98);}
    .order-icon{
        width:44px;height:44px;
        background:#F3F4F6;
        border-radius:10px;
        flex-shrink:0;
    }
    .status-completed{color:#16A34A;}
    .status-pending{color:#CA8A04;}
    .status-assigned{color:#2563EB;}
    .status-in_progress{color:#9333EA;}
    .status-rejected{color:#DC2626;}

    .orders-section{
        background:var(--pink-bg);
        border-radius:20px;
        padding:16px;
    }

    /* Layar sangat sempit (<360px) */
    @media (max-width: 360px){
        .balance-strip{
            flex-direction:column;
            align-items:stretch;
            gap:12px;
        }
        .balance-strip > .flex.items-center.gap-3{
            justify-content:flex-end;
        }
    }

    /* Layar lebih lebar (tablet/desktop) — beri sedikit ruang & bayangan supaya tidak menempel tepi */
    @media (min-width: 481px){
        .jasa-wrapper{
            box-shadow: 0 0 0 1px rgba(0,0,0,0.04);
            min-height: 100vh;
        }
    }
</style>
@endpush

@section('content')
<div class="jasa-wrapper px-4 pt-4 pb-6 space-y-5">

    {{-- Header card (disamakan dengan tampilan Home) --}}
    <div class="header-card p-4">
        <div class="flex items-center gap-2 mb-4">
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

        <div class="balance-strip mt-4 p-4 flex items-center justify-between gap-2">
            <div class="min-w-0">
                <p class="text-sm text-gray-700 truncate">
                    Balance : <span class="font-bold text-gray-900">Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}</span>
                </p>
                <p class="text-sm text-gray-700 mt-1 truncate">
                    Oregonet Point : <span class="font-bold text-orange-500">{{ auth()->user()->points ?? 0 }} point</span>
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('guest.topups.create') }}" class="flex flex-col items-center gap-1">
                    <div class="action-circle orange flex items-center justify-center">
                        <svg class="w-[19px] h-[19px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-[10px] text-gray-600 whitespace-nowrap">Top Up</span>
                </a>
                <a href="{{ route('guest.balance') }}" class="flex flex-col items-center gap-1">
                    <div class="action-circle red flex items-center justify-center">
                        <svg class="w-[19px] h-[19px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-[10px] text-gray-600 text-center leading-tight whitespace-nowrap">Change<br>Point</span>
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="p-3 bg-green-50 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="p-3 bg-red-50 text-red-800 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    {{-- Kategori Layanan --}}
    <div>
        <h3 class="font-bold text-gray-900 mb-3 text-[16px]">Pilih Layanan</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <a href="{{ route('guest.services.show', 'laundry') }}" class="service-card block">
                <div class="service-icon flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                        <rect x="4" y="3" width="16" height="18" rx="2.5"/>
                        <circle cx="12" cy="13" r="4.2"/>
                        <circle cx="12" cy="13" r="1.6" stroke-dasharray="1 2"/>
                        <path stroke-linecap="round" d="M7.5 6h.01M10.5 6h.01"/>
                    </svg>
                </div>
                <p class="service-label">Laundry</p>
            </a>
            <a href="{{ route('guest.service-requests.category', 'cleaning') }}" class="service-card block">
                <div class="service-icon flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.5 3.5l6 6-8.5 8.5-6-6z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12L4.5 16.5a2.121 2.121 0 003 3L12 15"/>
                        <path stroke-linecap="round" d="M13 5l4 4"/>
                    </svg>
                </div>
                <p class="service-label">Cleaning</p>
            </a>
            <a href="{{ route('guest.service-requests.category', 'repair') }}" class="service-card block">
                <div class="service-icon flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a4 4 0 00-5.4 4.6L3 17.2V21h3.8l6.3-6.3a4 4 0 004.6-5.4l-2.6 2.6-2.4-.6-.6-2.4 2.6-2.6z"/>
                    </svg>
                </div>
                <p class="service-label">Repair &amp;<br>Maintenance</p>
            </a>
            <a href="{{ route('guest.service-requests.category', 'ac') }}" class="service-card block">
                <div class="service-icon flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                        <rect x="3" y="6" width="18" height="7" rx="2"/>
                        <path stroke-linecap="round" d="M7 13v2M11 13v2.5M15 13v2M18 13v1.5"/>
                        <path stroke-linecap="round" d="M9 9.5h6"/>
                    </svg>
                </div>
                <p class="service-label">Air Conditioner</p>
            </a>
        </div>
    </div>

    {{-- Active Orders --}}
    <div class="orders-section">
        <div class="flex items-center justify-between mb-3 gap-2">
            <h3 class="font-bold text-gray-900 text-[16px]">Pesanan Aktif</h3>
            <span class="text-xs text-red-600 font-semibold whitespace-nowrap">{{ $requests->count() }} pesanan</span>
        </div>

        @if ($requests->isEmpty())
            <div class="text-center py-8 text-gray-500 bg-white rounded-xl border border-dashed border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <p class="mt-2 text-sm">Belum ada permintaan jasa</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($requests as $request)
                    <a href="{{ route('guest.service-requests.show', $request) }}" class="order-card block p-4">
                        <div class="flex items-center gap-3">
                            <div class="order-icon flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 3v3M16 3v3M3 9h18M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-900 truncate">Order No. {{ $request->order_number ?? str_pad($request->id, 7, '0', STR_PAD_LEFT) }}</h4>
                                <p class="text-sm font-medium status-{{ $request->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                </p>
                            </div>
                        </div>

                        @if ($request->status === 'completed' && !$request->feedback)
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <span class="text-sm text-red-600 font-medium">Beri Feedback →</span>
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
