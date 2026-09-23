@extends('layouts.guest')

@section('title', __('guest.withdraw.title'))

@section('content')
<div class="ui-page">

       @php
        // Kembali ke halaman asal; kalau tidak valid, ke Beranda.
        $previous = url()->previous();
        $isInternal = str_starts_with($previous, url('/guest'))
                      && !str_contains($previous, '/withdrawals');
        $backUrl = $isInternal ? $previous : route('guest.home');
    @endphp

    @include('guest.partials.page-hero', [
        'title'    => __('guest.withdraw.title'),
        'subtitle' => __('guest.withdraw.subtitle'),
        'back'     => $backUrl,
    ])

    <div class="ui-body">
        <div class="ui-pull ui-stack">

            @include('guest.partials.topup-balance')

            <div class="ui-alert" style="background:#EFF6FF;color:#1E40AF">
                {{ __('guest.withdraw.info', [
                    'min' => 'Rp' . number_format($setting->min_amount, 0, ',', '.'),
                    'fee' => $setting->fee_type === 'percent'
                        ? rtrim(rtrim(number_format($setting->fee_value, 2, ',', '.'), '0'), ',') . '%'
                        : 'Rp' . number_format($setting->fee_value, 0, ',', '.'),
                ]) }}
            </div>

            <div class="ui-card ui-rise">
                <form method="POST" action="{{ route('guest.withdrawals.store') }}" class="ui-form">
                    @csrf

                    <div>
                        <label for="amount" class="ui-label">{{ __('guest.withdraw.amount') }} <span class="text-red-500">*</span></label>
                        <div class="tp-money">
                            <span>Rp</span>
                            <input id="amount" type="number" name="amount" required class="ui-input"
                                   min="{{ (int) $setting->min_amount }}" step="1000"
                                   value="{{ old('amount') }}"
                                   placeholder="{{ __('guest.withdraw.min_placeholder', ['min' => number_format($setting->min_amount, 0, ',', '.')]) }}">
                        </div>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                    <div class="tp-panel" id="wd-summary" style="display:none">
                        <dl>
                            <div class="ui-kv-item"><dt>{{ __('guest.withdraw.fee') }}</dt><dd id="wd-fee">-</dd></div>
                            <div class="ui-kv-item"><dt>{{ __('guest.withdraw.net') }}</dt><dd id="wd-net" class="is-price">-</dd></div>
                        </dl>
                    </div>

                    <div>
                        <label for="bank_name" class="ui-label">{{ __('guest.withdraw.bank_name') }} <span class="text-red-500">*</span></label>
                        <input id="bank_name" type="text" name="bank_name" required class="ui-input" value="{{ old('bank_name') }}" placeholder="BCA, Mandiri, BNI...">
                        <x-input-error :messages="$errors->get('bank_name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="account_number" class="ui-label">{{ __('guest.withdraw.account_number') }} <span class="text-red-500">*</span></label>
                        <input id="account_number" type="text" inputmode="numeric" name="account_number" required class="ui-input" value="{{ old('account_number') }}">
                        <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                    </div>

                    <div>
                        <label for="account_holder_name" class="ui-label">{{ __('guest.withdraw.account_holder') }} <span class="text-red-500">*</span></label>
                        <input id="account_holder_name" type="text" name="account_holder_name" required class="ui-input" value="{{ old('account_holder_name', auth()->user()->name) }}">
                        <x-input-error :messages="$errors->get('account_holder_name')" class="mt-2" />
                    </div>

                    <button type="submit" class="ui-btn ui-btn--primary" style="margin-top:20px">
                        {{ __('guest.withdraw.submit') }}
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const feeType = @json($setting->fee_type);
    const feeValue = Number(@json((float) $setting->fee_value));
    const amountInput = document.getElementById('amount');
    const summary = document.getElementById('wd-summary');

    const rp = n => 'Rp' + Math.round(n).toLocaleString('id-ID');

    function updateSummary() {
        const amount = Number(amountInput.value);
        if (!amount) { summary.style.display = 'none'; return; }
        let fee = feeType === 'percent' ? amount * feeValue / 100 : feeValue;
        fee = Math.min(fee, amount);
        document.getElementById('wd-fee').textContent = rp(fee);
        document.getElementById('wd-net').textContent = rp(amount - fee);
        summary.style.display = 'block';
    }

    amountInput.addEventListener('input', updateSummary);
    updateSummary();
</script>
@endpush
