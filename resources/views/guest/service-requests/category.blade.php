@extends('layouts.guest')

@section('title', $category['title'])

@section('content')

<div class="ui-page">

    @include('guest.partials.page-hero', [
        'title'   => $category['title'],
        'back'    => route('guest.service-requests.index'),
        'iconKey' => $category['slug'],
    ])

    <div class="ui-body">
        <div class="ui-pull ui-stack">

            {{-- Sub layanan --}}
            <div class="ui-card ui-rise">

                <div class="ui-opts ui-opts--3" style="margin-top:0">
                    @foreach ($category['options'] as $option)
                        <a href="{{ route('guest.services.show', $category['slug']) }}?type={{ $option['id'] }}"
                           class="ui-tile">
                            <span class="ui-tile-ico {{ $category['bg'] }}">
                                {!! $option['icon'] !!}
                            </span>
                            <span class="ui-opt-name">{{ $option['label'] }}</span>
                        </a>
                    @endforeach
                </div>

            </div>


            {{-- Pesanan aktif --}}
            <section class="ui-rise" style="animation-delay:.08s">

                <div class="ui-sec-head">
                    <h3 class="ui-heading">{{ __('guest.category.active_orders', ['title' => $category['title']]) }}</h3>
                    <span class="ui-count">{{ __('guest.common.orders_count', ['count' => $activeRequests->count()]) }}</span>
                </div>

                @if ($activeRequests->isEmpty())

                    <div class="ui-empty">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        {{ __('guest.category.no_orders', ['title' => $category['title']]) }}
                    </div>

                @else

                    <div class="ui-stack">
                        @foreach ($activeRequests as $request)

                            <a href="{{ route('guest.service-requests.show', $request) }}" class="ui-row">

                                <div class="ui-row-main">

                                    <span class="ui-tile-ico {{ $category['bg'] }}" style="width:40px;height:40px;border-radius:12px">
                                        {!! $category['options'][0]['icon'] !!}
                                    </span>

                                    <div class="min-w-0 flex-1">
                                        <p class="ui-row-meta" style="margin-top:0">
                                            {{ __('guest.detail.order_number', ['number' => str_pad($request->id, 7, '0', STR_PAD_LEFT)]) }}
                                        </p>
                                        <p class="ui-row-title">{{ $request->service->name }}</p>
                                    </div>

                                    <span class="ui-pill ui-pill--{{ $request->status }}">
                                        {{ __('guest.status.' . $request->status) }}
                                    </span>

                                </div>

                            </a>

                        @endforeach
                    </div>

                @endif

            </section>


            {{-- CTA --}}
            <a href="{{ route('guest.services.show', $category['slug']) }}" class="ui-btn ui-btn--primary">
                {{ __('guest.category.new_request', ['title' => $category['title']]) }}
            </a>

        </div>
    </div>

</div>

@endsection
