@extends('layouts.guest')

@section('title', 'Home')

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
    }
    .house-badge{
        width:92px;height:92px;
        background:var(--red);
        border-radius:20px;
    }
    .balance-strip{
        background:#F9FAFB;
        border-radius:14px;
    }
    .action-circle{
        width:42px;height:42px;border-radius:50%;
        box-shadow:0 2px 4px rgba(0,0,0,0.08);
        transition:transform .15s ease;
    }
    .action-circle:active{transform:scale(0.92);}
    .action-circle.orange{background:var(--orange);}
    .action-circle.red{background:var(--red);}

    .service-item{transition:transform .15s ease;-webkit-tap-highlight-color:transparent;}
    .service-item:active{transform:scale(0.95);}
    .service-icon{
        width:62px;height:62px;
        background:var(--pink-bg);
        border-radius:16px;
        transition:background .15s ease;
    }
    .service-item:active .service-icon{background:#FBD5E0;}
    .service-icon svg{color:var(--pink-icon);}

    .cta-btn{
        background:var(--red);
        box-shadow:0 4px 10px rgba(220,38,38,0.25);
        transition:transform .15s ease, background .15s ease;
        -webkit-tap-highlight-color:transparent;
    }
    .cta-btn:active{transform:scale(0.98);background:var(--red-dark);}

    .promo-banner{
        border-radius:20px;
        background:linear-gradient(135deg,#FFF1F2 0%,#FDECEF 55%,#FBE0E5 100%);
        border:1px solid #FBDCE1;
    }
    .promo-headline{color:var(--red-dark);}
    .promo-circle{
        width:74px;height:74px;border-radius:50%;
        background:var(--red);
    }
    .promo-tags{border-top:1px solid #F6C9D0;}
    .promo-tag .dot{
        width:20px;height:20px;border-radius:50%;
        background:var(--red);color:#fff;font-size:10px;
    }

    .request-card{transition:transform .15s ease;-webkit-tap-highlight-color:transparent;}
    .request-card:active{transform:scale(0.98);}
    .badge.pending{background:#FEF9C3;color:#854D0E;}
    .badge.completed{background:#DCFCE7;color:#166534;}
    .badge.in-progress{background:#DBEAFE;color:#1E40AF;}
</style>
@endpush

@section('content')
<div class="px-4 pt-4 pb-6 space-y-5 bg-gray-50 min-h-screen">

    {{-- Header card --}}
    <div class="header-card p-4">
        <div class="flex items-center gap-2 mb-4">
            <div class="brand-icon flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.5L2 11h3v9h5v-6h4v6h5v-9h3L12 2.5z"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-gray-900 leading-tight text-sm">OREGONET</p>
                <p class="text-[10px] text-gray-500 leading-tight italic">Apartment Services</p>
            </div>
        </div>

        <div class="flex items-center justify-between gap-2">
            <p class="text-gray-800 text-sm">
                {{ __('Welcome,') }}<br>
                <span class="text-[19px] font-extrabold text-gray-900">{{ auth()->user()->name }}</span>
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
            <div>
                <p class="text-sm text-gray-700">
                    Balance : <span class="font-bold text-gray-900">Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}</span>
                </p>
                <p class="text-sm text-gray-700 mt-1">
    Oregonet Point : <span class="font-bold text-orange-500">{{ auth()->user()->coin_balance }} point</span>
</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('guest.topups.create') }}" class="flex flex-col items-center gap-1">
                    <div class="action-circle orange flex items-center justify-center">
                        <svg class="w-[19px] h-[19px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-[10px] text-gray-600">Top Up</span>
                </a>
                <a href="{{ route('guest.balance') }}" class="flex flex-col items-center gap-1">
                    <div class="action-circle red flex items-center justify-center">
                        <svg class="w-[19px] h-[19px] text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-[10px] text-gray-600 text-center leading-tight">Change<br>Point</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Our Services --}}
    <div>
        <h3 class="font-semibold text-gray-900 mb-3 text-[15px]">Our Services</h3>
        <div class="grid grid-cols-4 gap-3">
            <a href="{{ route('guest.services.show', 'laundry') }}" class="service-item flex flex-col items-center gap-1.5">
                <div class="service-icon flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 3v3M16 3v3M3 9h18M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                        <circle cx="12" cy="14" r="3.2"/>
                    </svg>
                </div>
                <span class="text-[11px] font-medium text-gray-700 text-center">Laundry</span>
            </a>
            <a href="{{ route('guest.services.show', 'cleaning') }}" class="service-item flex flex-col items-center gap-1.5">
                <div class="service-icon flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                    </svg>
                </div>
                <span class="text-[11px] font-medium text-gray-700 text-center">Cleaning</span>
            </a>
            <a href="{{ route('guest.services.show', 'maintenance-repair') }}" class="service-item flex flex-col items-center gap-1.5">
                <div class="service-icon flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.909 4.909m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                    </svg>
                </div>
                <span class="text-[11px] font-medium text-gray-700 text-center leading-tight">Repair &amp;<br>Maintenance</span>
            </a>
            <a href="{{ route('guest.services.show', 'ac-service') }}" class="service-item flex flex-col items-center gap-1.5">
                <div class="service-icon flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375" />
                    </svg>
                </div>
                <span class="text-[11px] font-medium text-gray-700 text-center">Air Conditioner</span>
            </a>
        </div>
    </div>

    {{-- Ajukan Jasa button --}}
    <a href="{{ route('guest.service-requests.create') }}" class="cta-btn block text-white py-3.5 rounded-xl text-center font-bold text-[15px]">
        Ajukan Jasa
    </a>

    {{-- Promo Banner --}}
    <div class="promo-banner p-[18px]">
        <div class="flex items-center justify-between gap-3">
            <div>
                <p class="text-[12px] text-gray-400 font-medium m-0">More Than Just Services,</p>
                <p class="promo-headline text-[17px] font-extrabold leading-tight mt-0.5 max-w-[190px]">We Care About Your Comfort</p>
            </div>
            <div class="promo-circle flex items-center justify-center shrink-0">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 5.337c-.03-.05-.06-.1-.09-.15-.334-.55-.805-1.02-1.35-1.35-.545-.33-1.16-.5-1.79-.5-.63 0-1.245.17-1.79.5-.545.33-1.016.8-1.35 1.35-.334.55-.51 1.17-.51 1.8 0 3.48 4.89 7.3 5.19 7.53.16.12.36.19.57.19.21 0 .41-.07.57-.19.3-.23 5.19-4.05 5.19-7.53 0-.63-.176-1.25-.51-1.8-.334-.55-.805-1.02-1.35-1.35-.545-.33-1.16-.5-1.79-.5-.63 0-1.245.17-1.79.5-.545.33-1.016.8-1.35 1.35-.03.05-.06.1-.09.15z" />
                </svg>
            </div>
        </div>
        <div class="promo-tags flex gap-4 mt-3.5 pt-3">
            <div class="flex items-center gap-1.5">
                <span class="dot flex items-center justify-center">&#10003;</span>
                <span class="text-[11px] text-gray-500">Laundry</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="dot flex items-center justify-center">&#10003;</span>
                <span class="text-[11px] text-gray-500">Cleaning</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="dot flex items-center justify-center">&#10003;</span>
                <span class="text-[11px] text-gray-500">Repair</span>
            </div>
        </div>
    </div>

    {{-- Permintaan Terbaru --}}
    <div>
        <h3 class="font-semibold text-gray-900 mb-3 text-[15px]">Permintaan Terbaru</h3>
        @php
            $recentRequests = auth()->user()->serviceRequests()->with('service')->latest()->take(3)->get();
        @endphp

        @if ($recentRequests->isEmpty())
            <div class="bg-white rounded-xl border border-dashed border-gray-200 p-6 text-center">
                <p class="text-sm text-gray-500">Belum ada permintaan jasa.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($recentRequests as $request)
                    <a href="{{ route('guest.services.show', 'cleaning') }}" class="service-item flex flex-col items-center gap-1.5">
                        <div class="flex items-center justify-between">
                            <h4 class="font-semibold text-sm text-gray-900">{{ $request->service->name }}</h4>
                            <span class="badge px-2.5 py-1 text-xs font-semibold rounded-full
                                @if($request->status === 'pending') pending
                                @elseif($request->status === 'completed') completed
                                @else in-progress @endif">
                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
