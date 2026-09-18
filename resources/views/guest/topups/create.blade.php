
@extends('layouts.guest')

@section('title', 'Top Up Saldo')

@push('styles')
<style>
    :root {
        --red: #DC2626;
        --red-dark: #B91C1C;
        --pink-bg: #FDECEF;
        --pink-icon: #DB2777;
        --orange: #F97316;
        --border: #F1F1F1;
    }

    .topup-wrapper {
        max-width: 480px;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        min-height: 100vh;
        overflow-x: hidden;
    }

    .header-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
        padding: 16px;
    }

    .brand-icon {
        width: 36px;
        height: 36px;
        background: var(--red);
        border-radius: 10px;
    }

    .balance-card {
        background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
        border-radius: 20px;
        padding: 18px;
        color: #fff;
        box-shadow: 0 4px 12px rgba(220,38,38,.18);
    }

    .balance-icon {
        width: 42px;
        height: 42px;
        border-radius: 13px;
        background: rgba(255,255,255,.16);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
        padding: 16px;
    }

    .section-title {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
    }

    .input-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .custom-input,
    .custom-select {
        width: 100%;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 13px;
        color: #111827;
        background: #fff;
        outline: none;
    }

    .custom-input:focus,
    .custom-select:focus {
        border-color: var(--red);
        box-shadow: 0 0 0 2px rgba(220,38,38,.08);
    }

    .payment-details {
        background: #F9FAFB;
        border: 1px solid #F1F1F1;
        border-radius: 14px;
        padding: 14px;
    }

    .info-item {
        background: #fff;
        border-radius: 10px;
        border: 1px solid #F1F1F1;
        padding: 10px 12px;
    }

    .upload-box {
        border: 1px dashed #D1D5DB;
        border-radius: 12px;
        padding: 14px;
        background: #FAFAFA;
    }

    .submit-btn {
        width: 100%;
        background: var(--red);
        color: #fff;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(220,38,38,.22);
        transition: transform .15s ease, background .15s ease;
    }

    .submit-btn:hover {
        background: var(--red-dark);
    }

    .submit-btn:active {
        transform: scale(.98);
    }

    .alert-success {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #166534;
        border-radius: 12px;
        padding: 11px 13px;
        font-size: 12px;
    }

    .alert-error {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        color: #991B1B;
        border-radius: 12px;
        padding: 11px 13px;
        font-size: 12px;
    }

    .error-text {
        color: #DC2626;
        font-size: 11px;
        margin-top: 5px;
    }

    @media (min-width: 481px) {
        .topup-wrapper {
            box-shadow: 0 0 0 1px rgba(0,0,0,.04);
        }
    }
</style>
@endpush

@section('content')

<div class="topup-wrapper px-4 pt-4 pb-6 space-y-5">

    {{-- Header --}}
    <div class="header-card">

        <div class="flex items-center gap-2">

            <div class="brand-icon flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24"
                     stroke-width="1.8">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M3 10h18M7 15h1m4 0h1m-7 4h16a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <div class="min-w-0">
                <p class="font-bold text-gray-900 leading-tight text-sm">
                    Top Up Saldo
                </p>
                <p class="text-[10px] text-gray-500 leading-tight">
                    Tambahkan saldo akun Anda
                </p>
            </div>

        </div>

    </div>


    {{-- Balance --}}
    <div class="balance-card">

        <div class="flex items-center justify-between gap-3">

            <div>
                <p class="text-red-100 text-xs">
                    Saldo Saat Ini
                </p>

                <p class="text-2xl font-extrabold mt-1">
                    Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}
                </p>
            </div>

            <div class="balance-icon">

                <svg class="w-6 h-6 text-white"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24"
                     stroke-width="1.7">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                </svg>

            </div>

        </div>

    </div>


    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif


    {{-- Form --}}
    <div class="form-card">

        <div class="flex items-center gap-2 mb-4">

            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">

                <svg class="w-4 h-4 text-red-600"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 6v12m6-6H6"/>

                </svg>

            </div>

            <div>
                <p class="section-title">
                    Ajukan Top Up
                </p>
                <p class="text-[10px] text-gray-500">
                    Isi data pembayaran di bawah
                </p>
            </div>

        </div>


        <form method="POST"
              action="{{ route('guest.topups.store') }}"
              enctype="multipart/form-data"
              class="space-y-4">

            @csrf


            {{-- Payment Method --}}
            <div>

                <label for="payment_method_id"
                       class="input-label">
                    Metode Pembayaran
                    <span class="text-red-500">*</span>
                </label>

                <select
                    name="payment_method_id"
                    id="payment_method_id"
                    required
                    class="custom-select"
                    onchange="showPaymentDetails(this.value)">

                    <option value="">
                        -- Pilih Metode --
                    </option>

                    @foreach ($paymentMethods as $method)

                        <option
                            value="{{ $method->id }}"
                            data-type="{{ $method->type }}"
                            data-bank="{{ $method->bank_name }}"
                            data-account="{{ $method->account_number }}"
                            data-holder="{{ $method->account_holder_name }}"
                            data-qr="{{ $method->qr_image ? Storage::url($method->qr_image) : '' }}">

                            {{ $method->display_name }}
                            ({{ $method->type === 'bank_transfer' ? 'Transfer Bank' : 'QRIS' }})

                        </option>

                    @endforeach

                </select>

                @error('payment_method_id')
                    <p class="error-text">{{ $message }}</p>
                @enderror

            </div>


            {{-- Payment Details --}}
            <div id="payment-details"
                 class="payment-details hidden">

                {{-- Bank --}}
                <div id="bank-details"
                     class="hidden space-y-2">

                    <p class="text-xs font-bold text-gray-800 mb-2">
                        Detail Rekening
                    </p>

                    <div class="info-item">
                        <p class="text-[10px] text-gray-400 uppercase">
                            Nama Bank
                        </p>
                        <p class="text-sm font-semibold text-gray-900"
                           id="detail-bank">
                        </p>
                    </div>

                    <div class="info-item">
                        <p class="text-[10px] text-gray-400 uppercase">
                            No. Rekening
                        </p>
                        <p class="text-sm font-semibold text-gray-900 break-all"
                           id="detail-account">
                        </p>
                    </div>

                    <div class="info-item">
                        <p class="text-[10px] text-gray-400 uppercase">
                            Atas Nama
                        </p>
                        <p class="text-sm font-semibold text-gray-900"
                           id="detail-holder">
                        </p>
                    </div>

                    <p class="text-[10px] text-gray-500 mt-2">
                        Transfer ke rekening di atas, kemudian upload bukti transfer.
                    </p>

                </div>


                {{-- QRIS --}}
                <div id="qris-details"
                     class="hidden text-center">

                    <p class="text-xs font-bold text-gray-800 mb-3">
                        Scan QR Code
                    </p>

                    <div class="bg-white p-3 rounded-xl border border-gray-100 inline-block">

                        <img
                            id="detail-qr"
                            src=""
                            alt="QRIS"
                            class="w-48 h-48 object-contain">

                    </div>

                    <p class="text-[10px] text-gray-500 mt-2">
                        Scan menggunakan aplikasi e-wallet atau banking.
                    </p>

                </div>

            </div>


            {{-- Amount --}}
            <div>

                <label for="amount"
                       class="input-label">
                    Nominal
                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="amount"
                    type="number"
                    name="amount"
                    min="10000"
                    step="1000"
                    value="{{ old('amount') }}"
                    required
                    class="custom-input"
                    placeholder="Minimal Rp10.000">

                @error('amount')
                    <p class="error-text">{{ $message }}</p>
                @enderror

            </div>


            {{-- Proof --}}
            <div>

                <label for="proof_image"
                       class="input-label">
                    Bukti Transfer
                    <span class="text-red-500">*</span>
                </label>

                <div class="upload-box">

                    <input
                        type="file"
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

                @error('proof_image')
                    <p class="error-text">{{ $message }}</p>
                @enderror

                <p class="mt-1 text-[10px] text-gray-400">
                    Format JPG/PNG, maksimal 2MB.
                </p>

            </div>


            {{-- Submit --}}
            <button type="submit"
                    class="submit-btn">

                <span class="flex items-center justify-center gap-2">

                    <svg class="w-4 h-4"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24"
                         stroke-width="1.8">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 19V5m0 0l-5 5m5-5l5 5"/>

                    </svg>

                    Ajukan Top Up

                </span>

            </button>

        </form>

    </div>

</div>


<script>
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
                document.getElementById('detail-qr').alt =
                    'QRIS belum diupload admin';

            }
        }
    }
</script>

@endsection
