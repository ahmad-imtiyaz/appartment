@extends('layouts.guest')

@section('title', __('guest.withdraw.history_title'))

@section('content')
<div class="ui-page">

    @include('guest.partials.page-hero', [
        'title'    => __('guest.withdraw.history_title'),
        'subtitle' => __('guest.withdraw.history_subtitle'),
        'back'     => route('guest.topups.index'),
    ])

    <div class="ui-body">
        <div class="ui-pull ui-stack">

            @include('guest.partials.topup-balance')

            <a href="{{ route('guest.withdrawals.create') }}" class="ui-btn ui-btn--primary">
                {{ __('guest.withdraw.new') }}
            </a>

            @if (session('success'))
                <div class="ui-alert ui-alert--success">{{ session('success') }}</div>
            @endif

            @if ($withdrawals->isEmpty())
                <div class="ui-empty">
                    <p style="font-weight:700;color:#374151">{{ __('guest.withdraw.empty_title') }}</p>
                </div>
            @else
                <div class="ui-stack">
                    @foreach ($withdrawals as $w)
                        @php
                            $pill = ['pending' => 'ui-pill--pending', 'approved' => 'ui-pill--completed', 'rejected' => 'ui-pill--rejected'][$w->status] ?? '';
                        @endphp
                        <div class="ui-row">
                            <div class="ui-row-main" style="align-items:flex-start">
                                <div class="min-w-0 flex-1">
                                    <p class="ui-row-title">{{ $w->bank_name }} · {{ $w->account_number }}</p>
                                    <p class="ui-row-meta">a.n. {{ $w->account_holder_name }}</p>
                                    <p class="ui-row-meta">{{ $w->created_at->translatedFormat('d M Y, H:i') }}</p>
                                </div>
                                <span class="ui-pill {{ $pill }}">{{ __('guest.withdraw.status.' . $w->status) }}</span>
                            </div>

                            <div class="tp-amount-row">
                                <span class="tp-amount-label">{{ __('guest.withdraw.net') }}</span>
                                <span class="tp-amount">Rp{{ number_format($w->net_amount, 0, ',', '.') }}</span>
                            </div>
                            <p class="ui-row-meta" style="margin-top:4px">
                                {{ __('guest.withdraw.amount') }} Rp{{ number_format($w->amount, 0, ',', '.') }}
                                · {{ __('guest.withdraw.fee') }} Rp{{ number_format($w->fee, 0, ',', '.') }}
                            </p>

                            @if ($w->status === 'pending')
                                <p class="ui-row-meta" style="margin-top:10px;color:#B45309">{{ __('guest.withdraw.pending_note') }}</p>
                            @elseif ($w->status === 'rejected' && $w->admin_note)
                                <div class="ui-alert ui-alert--error" style="margin-top:12px">
                                    <p style="font-weight:800;font-size:11px">{{ __('guest.topup.rejection_reason') }}</p>
                                    <p style="margin-top:2px">{{ $w->admin_note }}</p>
                                    <p style="margin-top:4px">{{ __('guest.withdraw.refunded') }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
