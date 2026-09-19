@extends('layouts.guest')

@section('title', __('guest.index.title'))

@section('content')

@include('guest.partials.ui')

<div class="ui-page">

    @include('guest.partials.header-card')

    <div class="ui-body ui-body--top ui-stack">

        @if (session('success'))
            <div class="ui-alert ui-alert--success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="ui-alert ui-alert--error">{{ session('error') }}</div>
        @endif


        {{-- Kategori Layanan --}}
        <section class="ui-rise">

            <h3 class="ui-heading">{{ __('guest.index.choose_service') }}</h3>
            <p class="ui-sub">{{ __('guest.home.services_subtitle') }}</p>

            <div class="ui-grid2" style="margin-top:14px">

                {{-- Laundry --}}
                <a href="{{ route('guest.services.show', 'laundry') }}" class="ui-svc tone-sky">
                    <span class="ui-svc-arrow">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                    <span class="ui-ico">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                            <rect x="4" y="2.5" width="16" height="19" rx="3"/>
                            <circle cx="12" cy="14" r="4"/>
                            <path stroke-linecap="round" d="M7.5 6h.01M11 6h2"/>
                        </svg>
                    </span>
                    <span class="ui-svc-title">{{ __('guest.home.laundry') }}</span>
                    <span class="ui-svc-desc">{{ __('guest.home.laundry_desc') }}</span>
                </a>

                {{-- Kebersihan --}}
                <a href="{{ route('guest.service-requests.category', 'cleaning') }}" class="ui-svc tone-teal">
                    <span class="ui-svc-arrow">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                    <span class="ui-ico">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/>
                        </svg>
                    </span>
                    <span class="ui-svc-title">{{ __('guest.home.cleaning') }}</span>
                    <span class="ui-svc-desc">{{ __('guest.home.cleaning_desc') }}</span>
                </a>

                {{-- Perbaikan --}}
                <a href="{{ route('guest.service-requests.category', 'repair') }}" class="ui-svc tone-amber">
                    <span class="ui-svc-arrow">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                    <span class="ui-ico">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.909 4.909m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z"/>
                        </svg>
                    </span>
                    <span class="ui-svc-title">{{ __('guest.home.repair_maintenance') }}</span>
                    <span class="ui-svc-desc">{{ __('guest.home.repair_desc') }}</span>
                </a>

                {{-- AC --}}
                <a href="{{ route('guest.service-requests.category', 'ac') }}" class="ui-svc tone-rose">
                    <span class="ui-svc-arrow">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                    <span class="ui-ico">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M4.2 7.5l15.6 9M4.2 16.5l15.6-9M9.5 4.5L12 6.5l2.5-2M9.5 19.5l2.5-2 2.5 2"/>
                        </svg>
                    </span>
                    <span class="ui-svc-title">{{ __('guest.home.ac') }}</span>
                    <span class="ui-svc-desc">{{ __('guest.home.ac_desc') }}</span>
                </a>

            </div>

        </section>


        {{-- Pesanan Aktif --}}
        <section class="ui-rise" style="animation-delay:.08s">

            <div class="ui-sec-head">
                <h3 class="ui-heading">{{ __('guest.index.active_orders') }}</h3>
                <span class="ui-count">{{ __('guest.common.orders_count', ['count' => $requests->count()]) }}</span>
            </div>

            @if ($requests->isEmpty())

                <div class="ui-empty">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    {{ __('guest.index.no_requests') }}
                </div>

            @else

                <div class="ui-stack">
                    @foreach ($requests as $request)

                        <a href="{{ route('guest.service-requests.show', $request) }}" class="ui-row">

                            <div class="ui-row-main">

                                <span class="ui-ico ui-ico--sm tone-red">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                </span>

                                <div class="min-w-0 flex-1">
                                    <p class="ui-row-title">
                                        {{ __('guest.index.order_no', ['number' => $request->order_number ?? str_pad($request->id, 7, '0', STR_PAD_LEFT)]) }}
                                    </p>
                                </div>

                                <span class="ui-pill ui-pill--{{ $request->status }}">
                                    {{ __('guest.status.' . $request->status) }}
                                </span>

                            </div>

                            @if ($request->status === 'completed' && !$request->feedback)
                                <p class="ui-row-foot">{{ __('guest.index.give_feedback') }}</p>
                            @endif

                        </a>

                    @endforeach
                </div>

            @endif

        </section>

    </div>

</div>

@endsection
