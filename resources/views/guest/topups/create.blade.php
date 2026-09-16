@extends('layouts.guest')

@section('title', 'Top Up Saldo')

@section('header')
    <h2 class="font-semibold text-lg text-gray-800">
        {{ __('Top Up Saldo') }}
    </h2>
@endsection

@section('content')
    <div class="py-4 px-4">
        <!-- Current Balance Card -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-xl p-6 text-white mb-6">
            <p class="text-indigo-100 text-sm">Saldo Saat Ini</p>
            <p class="text-3xl font-bold mt-1">Rp{{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-800 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-3 bg-red-50 text-red-800 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('guest.topups.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Payment Method Selection -->
            <div>
                <x-input-label for="payment_method_id" :value="__('Metode Pembayaran') <span class=\"text-red-500\">*</span>" />
                <select name="payment_method_id" id="payment_method_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white"
                        onchange="showPaymentDetails(this.value)">
                    <option value="">-- Pilih Metode --</option>
                    @foreach ($paymentMethods as $method)
                        <option value="{{ $method->id }}"
                                data-type="{{ $method->type }}"
                                data-bank="{{ $method->bank_name }}"
                                data-account="{{ $method->account_number }}"
                                data-holder="{{ $method->account_holder_name }}"
                                data-qr="{{ $method->qr_image ? Storage::url($method->qr_image) : '' }}">
                            {{ $method->display_name }} ({{ $method->type === 'bank_transfer' ? 'Transfer Bank' : 'QRIS' }})
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('payment_method_id')" class="mt-2" />
            </div>

            <!-- Payment Details (shown dynamically) -->
            <div id="payment-details" class="hidden bg-gray-50 rounded-lg p-4 space-y-3">
                <!-- Bank Transfer Details -->
                <div id="bank-details" class="hidden">
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Nama Bank</label>
                        <p class="font-medium text-gray-900" id="detail-bank"></p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">No. Rekening</label>
                        <p class="font-medium text-gray-900 break-all" id="detail-account"></p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase tracking-wide">Atas Nama</label>
                        <p class="font-medium text-gray-900" id="detail-holder"></p>
                    </div>
                    <p class="text-xs text-gray-500">Transfer ke rekening di atas, lalu upload bukti transfer</p>
                </div>

                <!-- QRIS Details -->
                <div id="qris-details" class="hidden text-center">
                    <label class="text-xs text-gray-500 uppercase tracking-wide block mb-2">Scan QR Code</label>
                    <div id="qris-image-container" class="bg-white p-4 rounded-lg inline-block">
                        <img id="detail-qr" src="" alt="QRIS" class="w-48 h-48 object-contain">
                    </div>
                    <p class="text-xs text-gray-500">Scan QR code di atas menggunakan aplikasi e-wallet/banking, lalu upload bukti pembayaran</p>
                </div>
            </div>

            <!-- Amount -->
            <div>
                <x-input-label for="amount" :value="__('Nominal') <span class=\"text-red-500\">*</span>" />
                <x-text-input id="amount" type="number" name="amount" min="10000" step="1000" :value="old('amount')" required class="mt-1 block w-full" placeholder="Minimal Rp10.000" />
                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
            </div>

            <!-- Proof Image -->
            <div>
                <x-input-label for="proof_image" :value="__('Bukti Transfer') <span class=\"text-red-500\">*</span>" />
                <input type="file" name="proof_image" id="proof_image" accept="image/*" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                <x-input-error :messages="$errors->get('proof_image')" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500">Format: JPG/PNG, maksimal 2MB</p>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                    Ajukan Top Up
                </button>
            </div>
        </form>
    </div>

    <script>
        function showPaymentDetails(value) {
            const select = document.getElementById('payment_method_id');
            const selectedOption = select.options[select.selectedIndex];
            const type = selectedOption.dataset.type;

            const detailsDiv = document.getElementById('payment-details');
            const bankDiv = document.getElementById('bank-details');
            const qrisDiv = document.getElementById('qris-details');

            if (!value) {
                detailsDiv.classList.add('hidden');
                return;
            }

            detailsDiv.classList.remove('hidden');

            if (type === 'bank_transfer') {
                bankDiv.classList.remove('hidden');
                qrisDiv.classList.add('hidden');

                document.getElementById('detail-bank').textContent = selectedOption.dataset.bank;
                document.getElementById('detail-account').textContent = selectedOption.dataset.account;
                document.getElementById('detail-holder').textContent = selectedOption.dataset.holder;
            } else if (type === 'qris') {
                bankDiv.classList.add('hidden');
                qrisDiv.classList.remove('hidden');

                const qrUrl = selectedOption.dataset.qr;
                if (qrUrl) {
                    document.getElementById('detail-qr').src = qrUrl;
                } else {
                    document.getElementById('detail-qr').src = '';
                    document.getElementById('detail-qr').alt = 'QRIS belum diupload admin';
                }
            }
        }
    </script>
@endsection
