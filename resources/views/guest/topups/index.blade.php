@extends('layouts.guest')

@section('title', __('guest.topup.history_title'))

@section('content')

<div class="ui-page">

    @include('guest.partials.page-hero', [
        'title'    => __('guest.topup.history_title'),
        'subtitle' => __('guest.topup.history_subtitle'),
        'back'     => route('guest.home'),
    ])

    <div class="ui-body">
        <div class="ui-pull ui-stack">

            @include('guest.partials.topup-balance')
            @include('guest.partials.topup-pending')


            {{-- Top Up Baru --}}
            <a href="{{ route('guest.topups.create') }}" class="ui-btn ui-btn--primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/>
                </svg>
                {{ __('guest.topup.new_topup') }}
            </a>

            {{-- Tarik Saldo --}}
            <a href="{{ route('guest.withdrawals.index') }}" class="ui-btn ui-btn--outline">
                {{ __('guest.withdraw.title') }}
            </a>


            {{-- Alerts --}}
            @if (session('success'))
                <div class="ui-alert ui-alert--success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="ui-alert ui-alert--error">{{ session('error') }}</div>
            @endif


            {{-- Riwayat --}}
            <section class="ui-rise" style="animation-delay:.08s">

                <div class="ui-sec-head">

                    <div>
                        <h3 class="ui-heading">{{ __('guest.topup.recent_transactions') }}</h3>
                        <p class="ui-sub" style="margin-top:1px">{{ __('guest.topup.recent_subtitle') }}</p>
                    </div>

                    <span class="ui-ico ui-ico--sm tone-red">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 2.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>

                </div>


                @if ($topups->isEmpty())

                    <div class="ui-empty">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>

                        <p style="font-weight:700;color:#374151">{{ __('guest.topup.empty_title') }}</p>
                        <p class="ui-hint" style="margin-top:4px">{{ __('guest.topup.empty_desc') }}</p>
                    </div>

                @else

                    <div class="ui-stack">

                        @foreach ($topups as $topup)

                            @php
                                $statusKey = 'guest.topup.status.' . $topup->status;
                                $statusLabel = \Illuminate\Support\Facades\Lang::has($statusKey)
                                    ? __($statusKey)
                                    : ucfirst($topup->status);

                                $pillClass = [
                                    'pending'  => 'ui-pill--pending',
                                    'approved' => 'ui-pill--completed',
                                    'rejected' => 'ui-pill--rejected',
                                ][$topup->status] ?? '';
                            @endphp

                            <div class="ui-row">

                                <div class="ui-row-main" style="align-items:flex-start">

                                    <span class="ui-ico ui-ico--sm tone-emerald">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/>
                                        </svg>
                                    </span>

                                    <div class="min-w-0 flex-1">
                                        <p class="ui-row-title">{{ $topup->paymentMethod->display_name }}</p>
                                        <p class="ui-row-meta">{{ $topup->created_at->translatedFormat('d M Y, H:i') }}</p>
                                    </div>

                                    <span class="ui-pill {{ $pillClass }}">{{ $statusLabel }}</span>

                                </div>


                                {{-- Nominal --}}
                                <div class="tp-amount-row">
                                    <span class="tp-amount-label">{{ __('guest.topup.topup_amount') }}</span>
                                    <span class="tp-amount">+Rp{{ number_format($topup->amount, 0, ',', '.') }}</span>
                                </div>


                                {{-- Ditolak --}}
                                @if ($topup->status === 'rejected' && $topup->admin_note)
                                    <div class="ui-alert ui-alert--error" style="margin-top:12px">
                                        <p style="font-weight:800;font-size:11px">{{ __('guest.topup.rejection_reason') }}</p>
                                        <p style="margin-top:2px">{{ $topup->admin_note }}</p>
                                    </div>
                                @endif


                                {{-- Disetujui --}}
                                @if ($topup->status === 'approved' && $topup->approved_at)
                                    <p class="ui-row-meta" style="margin-top:10px">
                                        {{ __('guest.topup.approved_at') }}
                                        {{ $topup->approved_at->translatedFormat('d M Y H:i') }}
                                    </p>
                                @endif

                                {{-- Sedang diproses --}}
@if ($topup->status === 'pending')
    <p class="ui-row-meta" style="margin-top:10px;color:#B45309">
        {{ __('guest.topup.pending_note') }}
    </p>
@endif

                            </div>

                        @endforeach

                    </div>

                @endif

            </section>

        </div>
    </div>

</div>

@endsection
