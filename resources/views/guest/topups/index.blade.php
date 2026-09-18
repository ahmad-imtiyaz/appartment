
@extends('layouts.guest')

@section('title', 'Riwayat Top Up')

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

    .history-wrapper {
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

    .topup-btn {
        background: var(--red);
        color: #fff;
        border-radius: 12px;
        padding: 12px;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        display: block;
        box-shadow: 0 4px 10px rgba(220,38,38,.22);
        transition: transform .15s ease, background .15s ease;
    }

    .topup-btn:hover {
        background: var(--red-dark);
    }

    .topup-btn:active {
        transform: scale(.98);
    }

    .history-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--border);
        padding: 14px;
        box-shadow: 0 1px 3px rgba(0,0,0,.04);
        transition: transform .15s ease;
    }

    .history-card:active {
        transform: scale(.98);
    }

    .history-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: var(--pink-bg);
        color: var(--pink-icon);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .status-pending {
        background: #FEF9C3;
        color: #854D0E;
    }

    .status-approved {
        background: #DCFCE7;
        color: #166534;
    }

    .status-rejected {
        background: #FEE2E2;
        color: #991B1B;
    }

    .status-default {
        background: #F3F4F6;
        color: #374151;
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

    .empty-card {
        background: #fff;
        border: 1px dashed #D1D5DB;
        border-radius: 16px;
        padding: 35px 20px;
        text-align: center;
    }

    @media (min-width: 481px) {
        .history-wrapper {
            box-shadow: 0 0 0 1px rgba(0,0,0,.04);
        }
    }
</style>
@endpush

@section('content')

<div class="history-wrapper px-4 pt-4 pb-6 space-y-5">

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
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                </svg>

            </div>

            <div>

                <p class="font-bold text-gray-900 leading-tight text-sm">
                    Riwayat Top Up
                </p>

                <p class="text-[10px] text-gray-500 leading-tight">
                    Daftar transaksi penambahan saldo
                </p>

            </div>

        </div>

    </div>


    {{-- Balance --}}
    <div class="balance-card">

        <p class="text-red-100 text-xs">
            Saldo Saat Ini
        </p>

        <p class="text-2xl font-extrabold mt-1">
            Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}
        </p>

    </div>


    {{-- New Top Up --}}
    <a href="{{ route('guest.topups.create') }}"
       class="topup-btn">

        <span class="flex items-center justify-center gap-2">

            <svg class="w-4 h-4"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24"
                 stroke-width="2">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 6v12m6-6H6"/>

            </svg>

            Top Up Baru

        </span>

    </a>


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


    {{-- History --}}
    <div>

        <div class="flex items-center justify-between mb-3">

            <div>

                <h3 class="font-bold text-gray-900 text-[15px]">
                    Transaksi Terakhir
                </h3>

                <p class="text-[10px] text-gray-400 mt-0.5">
                    Riwayat top up saldo Anda
                </p>

            </div>

            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">

                <svg class="w-4 h-4 text-red-600"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 8v4l2.5 2.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                </svg>

            </div>

        </div>


        @if ($topups->isEmpty())

            <div class="empty-card">

                <svg class="mx-auto h-12 w-12 text-gray-300"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24"
                     stroke-width="1.5">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                </svg>

                <p class="mt-3 text-sm font-medium text-gray-700">
                    Belum ada riwayat top up
                </p>

                <p class="text-[11px] text-gray-400 mt-1">
                    Transaksi top up Anda akan muncul di sini.
                </p>

            </div>

        @else

            <div class="space-y-3">

                @foreach ($topups as $topup)

                    <div class="history-card">

                        {{-- Top --}}
                        <div class="flex items-start gap-3">

                            <div class="history-icon">

                                <svg class="w-5 h-5"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.8">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M12 6v12m6-6H6"/>

                                </svg>

                            </div>


                            <div class="min-w-0 flex-1">

                                <div class="flex items-start justify-between gap-2">

                                    <div class="min-w-0">

                                        <p class="font-semibold text-gray-900 text-sm truncate">
                                            {{ $topup->paymentMethod->display_name }}
                                        </p>

                                        <p class="text-[10px] text-gray-400 mt-0.5">
                                            {{ $topup->created_at->format('d M Y, H:i') }}
                                        </p>

                                    </div>


                                    {{-- Status --}}
                                    <span class="shrink-0 px-2 py-1 text-[9px] font-bold rounded-full
                                        @if($topup->status === 'pending')
                                            status-pending
                                        @elseif($topup->status === 'approved')
                                            status-approved
                                        @elseif($topup->status === 'rejected')
                                            status-rejected
                                        @else
                                            status-default
                                        @endif">

                                        {{ ucfirst($topup->status) }}

                                    </span>

                                </div>


                                {{-- Amount --}}
                                <div class="mt-3 flex items-center justify-between">

                                    <span class="text-[10px] text-gray-400">
                                        Nominal Top Up
                                    </span>

                                    <span class="text-[15px] font-extrabold text-red-600">
                                        +Rp{{ number_format($topup->amount, 0, ',', '.') }}
                                    </span>

                                </div>


                                {{-- Rejected --}}
                                @if ($topup->status === 'rejected' && $topup->admin_note)

                                    <div class="mt-3 bg-red-50 rounded-lg p-2.5">

                                        <p class="text-[10px] font-semibold text-red-700">
                                            Alasan Penolakan
                                        </p>

                                        <p class="text-[10px] text-red-600 mt-0.5">
                                            {{ $topup->admin_note }}
                                        </p>

                                    </div>

                                @endif


                                {{-- Approved --}}
                                @if ($topup->status === 'approved' && $topup->approved_at)

                                    <p class="text-[10px] text-gray-400 mt-2">
                                        Disetujui:
                                        {{ $topup->approved_at->format('d M Y H:i') }}
                                    </p>

                                @endif

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</div>

@endsection

