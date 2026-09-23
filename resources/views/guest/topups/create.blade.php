@extends('layouts.guest')

@section('title', __('guest.topup.title'))

@section('content')

<div class="ui-page">

       <div style="position:relative">

        @include('guest.partials.page-hero', [
            'title'    => __('guest.topup.title'),
            'subtitle' => __('guest.topup.subtitle'),
            'back'     => route('guest.home'),
        ])

        {{-- Tombol ke riwayat top up --}}
        <a href="{{ route('guest.topups.index') }}"
           aria-label="{{ __('guest.topup.history_title') }}"
           title="{{ __('guest.topup.history_title') }}"
           style="position:absolute;top:calc(16px + env(safe-area-inset-top, 0px));right:16px;z-index:10;
                  width:40px;height:40px;border-radius:50%;
                  display:flex;align-items:center;justify-content:center;
                  background:rgba(255,255,255,.18);color:#fff;
                  border:1px solid rgba(255,255,255,.28);
                  -webkit-tap-highlight-color:transparent;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </a>

    </div>

    <div class="ui-body">
        <div class="ui-pull ui-stack">

            @include('guest.partials.topup-balance')
            @include('guest.partials.topup-pending')


            {{-- Alerts --}}
            @if (session('success'))
                <div class="ui-alert ui-alert--success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="ui-alert ui-alert--error">{{ session('error') }}</div>
            @endif


            {{-- Form --}}
            <div class="ui-card ui-rise" style="animation-delay:.06s">

                <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px">

                    <span class="ui-ico ui-ico--sm tone-red">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/>
                        </svg>
                    </span>

                    <div>
                        <h3 class="ui-heading">{{ __('guest.topup.form_title') }}</h3>
                        <p class="ui-sub" style="margin-top:1px">{{ __('guest.topup.form_subtitle') }}</p>
                    </div>

                </div>


                <form method="POST"
                      action="{{ route('guest.topups.store') }}"
                      enctype="multipart/form-data"
                      class="ui-form">

                    @csrf


                    {{-- Metode pembayaran --}}
                    <div>

                        <label for="payment_method_id" class="ui-label">
                            {{ __('guest.topup.payment_method') }}
                            <span class="text-red-500">*</span>
                        </label>

                        <select name="payment_method_id"
                                id="payment_method_id"
                                required
                                class="ui-input"
                                onchange="showPaymentDetails(this.value)">

                            <option value="">{{ __('guest.topup.choose_method') }}</option>

                            @foreach ($paymentMethods as $method)
                                <option
                                    value="{{ $method->id }}"
                                    data-type="{{ $method->type }}"
                                    data-bank="{{ $method->bank_name }}"
                                    data-account="{{ $method->account_number }}"
                                    data-holder="{{ $method->account_holder_name }}"
                                    data-qr="{{ $method->qr_image ? Storage::url($method->qr_image) : '' }}"
                                    @selected(old('payment_method_id') == $method->id)>

                                    {{ $method->display_name }}
                                    ({{ $method->type === 'bank_transfer' ? __('guest.topup.type_bank_transfer') : __('guest.topup.type_qris') }})

                                </option>
                            @endforeach

                        </select>

                        <x-input-error :messages="$errors->get('payment_method_id')" class="mt-2" />

                    </div>


                    {{-- Detail pembayaran --}}
                    <div id="payment-details" class="hidden">
                        <div class="tp-panel">

                            {{-- Bank --}}
                            <div id="bank-details" class="hidden">

                                <p class="tp-panel-title">{{ __('guest.topup.account_details') }}</p>

                                <dl>
                                    <div class="ui-kv-item">
                                        <dt>{{ __('guest.topup.bank_name') }}</dt>
                                        <dd id="detail-bank"></dd>
                                    </div>
                                    <div class="ui-kv-item">
                                        <dt>{{ __('guest.topup.account_number') }}</dt>
                                        <dd id="detail-account" class="break-all"></dd>
                                    </div>
                                    <div class="ui-kv-item">
                                        <dt>{{ __('guest.topup.account_holder') }}</dt>
                                        <dd id="detail-holder"></dd>
                                    </div>
                                </dl>

                                <p class="tp-panel-hint">{{ __('guest.topup.bank_hint') }}</p>

                            </div>


                            {{-- QRIS --}}
                            <div id="qris-details" class="hidden" style="text-align:center">

                                <p class="tp-panel-title" style="margin-bottom:12px">{{ __('guest.topup.scan_qr') }}</p>

                                <div class="tp-qr">
                                    <img id="detail-qr" src="" alt="QRIS">
                                </div>

                                <p class="tp-panel-hint">{{ __('guest.topup.qris_hint') }}</p>

                            </div>

                        </div>
                    </div>


                    {{-- Nominal --}}
                    <div>

                        <label for="amount" class="ui-label">
                            {{ __('guest.topup.amount') }}
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="tp-money">
                            <span>Rp</span>
                            <input id="amount"
                                   type="number"
                                   name="amount"
                                   min="10000"
                                   step="1000"
                                   value="{{ old('amount') }}"
                                   required
                                   class="ui-input"
                                   placeholder="{{ __('guest.topup.amount_placeholder') }}">
                        </div>

                        <div class="tp-chips">
                            @foreach ([20000, 50000, 100000, 200000] as $quick)
                                <button type="button" class="tp-chip" data-amount="{{ $quick }}">
                                    Rp{{ number_format($quick, 0, ',', '.') }}
                                </button>
                            @endforeach
                        </div>

                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />

                    </div>


                    {{-- Bukti transfer --}}
                    <div>

                        <label for="proof_image" class="ui-label">
                            {{ __('guest.topup.proof') }}
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="ui-upload">
                            <input type="file"
                                   name="proof_image"
                                   id="proof_image"
                                   accept="image/*"
                                   required
                                   class="block w-full text-xs text-gray-500
                                   file:mr-3 file:py-2 file:px-3
                                   file:rounded-lg file:border-0
                                   file:text-xs file:font-semibold
                                   file:bg-red-50 file:text-red-700
                                   hover:file:bg-red-100">
                        </div>

                        <x-input-error :messages="$errors->get('proof_image')" class="mt-2" />

                        <p class="ui-hint">{{ __('guest.topup.proof_hint') }}</p>

                    </div>


                    {{-- Submit --}}
                    <button type="submit" class="ui-btn ui-btn--primary" style="margin-top:20px">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-5 5m5-5l5 5"/>
                        </svg>
                        {{ __('guest.topup.submit') }}
                    </button>

                </form>

            </div>

        </div>
    </div>

</div>


<script>
    const qrisNotUploadedText = @json(__('guest.topup.qris_not_uploaded'));

    function showPaymentDetails(value) {

        const select = document.getElementById('payment_method_id');
        const selectedOption = select.options[select.selectedIndex];

        const detailsDiv = document.getElementById('payment-details');
        const bankDiv = document.getElementById('bank-details');
        const qrisDiv = document.getElementById('qris-details');

        if (!value) {
            detailsDiv.classList.add('hidden');
            bankDiv.classList.add('hidden');
            qrisDiv.classList.add('hidden');
            return;
        }

        const type = selectedOption.dataset.type;

        detailsDiv.classList.remove('hidden');

        if (type === 'bank_transfer') {

            bankDiv.classList.remove('hidden');
            qrisDiv.classList.add('hidden');

            document.getElementById('detail-bank').textContent =
                selectedOption.dataset.bank || '-';

            document.getElementById('detail-account').textContent =
                selectedOption.dataset.account || '-';

            document.getElementById('detail-holder').textContent =
                selectedOption.dataset.holder || '-';

        } else if (type === 'qris') {

            bankDiv.classList.add('hidden');
            qrisDiv.classList.remove('hidden');

            const qrUrl = selectedOption.dataset.qr;

            if (qrUrl) {

                document.getElementById('detail-qr').src = qrUrl;
                document.getElementById('detail-qr').alt = 'QRIS';

            } else {

                document.getElementById('detail-qr').src = '';
                document.getElementById('detail-qr').alt = qrisNotUploadedText;

            }
        }
    }

    // Tombol nominal cepat
    document.querySelectorAll('.tp-chip').forEach(function (chip) {
        chip.addEventListener('click', function () {
            const input = document.getElementById('amount');
            input.value = chip.dataset.amount;
            input.focus();
        });
    });

    // Restore detail panel after validation error (old input)
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('payment_method_id');
        if (select.value) {
            showPaymentDetails(select.value);
        }
    });
</script>

@endsection
