<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pencairan Pekerja') }}</h2>
    </x-slot>

    <style>[x-cloak]{display:none !important;}</style>

    <div class="py-6 sm:py-8 px-4 sm:px-6 lg:px-8" x-data="{ payout: null }">
        <div class="max-w-7xl mx-auto">

            @if (session('success'))
                <div class="mb-6 p-3 bg-green-50 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-3 bg-red-50 text-red-800 rounded-lg text-sm">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-6 p-3 bg-red-50 text-red-800 rounded-lg text-sm">{{ $errors->first() }}</div>
            @endif

            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <p class="text-sm text-gray-600">
                    Menunggu diproses: <strong>{{ $pendingCount }}</strong> pengajuan
                    (Rp{{ number_format($pendingTotal, 0, ',', '.') }})
                </p>
                <div class="flex gap-2 text-sm">
                    @foreach ([null => 'Semua', 'pending' => 'Menunggu', 'paid' => 'Selesai'] as $value => $label)
                        <a href="{{ route('admin.worker-payouts.index', $value ? ['status' => $value] : []) }}"
                           class="px-3 py-1.5 rounded-md border {{ $status === ($value ?: null) ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                @foreach (['Pekerja', 'Tugas', 'Rekening Tujuan', 'Nominal', 'Status', 'Diajukan', 'Aksi'] as $th)
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $th }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($payouts as $p)
                                <tr class="hover:bg-gray-50 align-top">
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-gray-900">{{ $p->worker->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $p->worker->phone ?? $p->worker->email }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm">
                                        <a href="{{ route('admin.service-requests.show', $p->service_request_id) }}" class="text-indigo-600 hover:underline">
                                            {{ $p->serviceRequest->service->name }} #{{ $p->service_request_id }}
                                        </a>
                                        <div class="text-xs text-gray-500">
                                            Total Rp{{ number_format($p->serviceRequest->cost ?? 0, 0, ',', '.') }}
                                            − potongan Rp{{ number_format($p->serviceRequest->commission_amount ?? 0, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm">
                                        <div class="font-medium">{{ $p->bank_name }}</div>
                                        <div>{{ $p->account_number }}</div>
                                        <div class="text-gray-500">a.n. {{ $p->account_holder_name }}</div>
                                    </td>
                                    <td class="px-4 py-4 font-semibold text-indigo-600 whitespace-nowrap">Rp{{ number_format($p->amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $p->isPaid() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $p->isPaid() ? 'Selesai' : 'Menunggu' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $p->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-4 text-sm">
                                        @if ($p->isPending())
                                            <button type="button"
                                                    @click="payout = {{ Js::from([
                                                        'action' => route('admin.worker-payouts.pay', $p),
                                                        'worker' => $p->worker->name,
                                                        'amount' => 'Rp' . number_format($p->amount, 0, ',', '.'),
                                                        'bank' => $p->bank_name . ' ' . $p->account_number . ' a.n. ' . $p->account_holder_name,
                                                    ]) }}"
                                                    class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-md whitespace-nowrap">
                                                Bayar & Upload Bukti
                                            </button>
                                        @else
                                            <div class="flex items-start gap-2">
                                                @if ($p->proofUrl())
                                                    <a href="{{ $p->proofUrl() }}" target="_blank">
                                                        <img src="{{ $p->proofUrl() }}" alt="Bukti" class="w-12 h-12 object-cover rounded border">
                                                    </a>
                                                @endif
                                                <div class="text-xs text-gray-500">
                                                    <div>{{ $p->paid_at?->format('d M Y H:i') }}</div>
                                                    <div>oleh {{ $p->processedBy->name ?? '-' }}</div>
                                                    @if ($p->admin_note)
                                                        <div class="text-gray-700">{{ $p->admin_note }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada pengajuan pencairan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">{{ $payouts->links() }}</div>
            </div>
        </div>

        <!-- Modal bayar -->
        <div x-show="payout" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4"
             @keydown.escape.window="payout = null">
            <div class="bg-white rounded-xl p-6 w-full max-w-md" @click.outside="payout = null">
                <h3 class="font-semibold text-lg text-gray-900 mb-1">Bayar Pencairan</h3>
                <p class="text-sm text-gray-600">
                    Transfer <strong x-text="payout?.amount"></strong> ke <span x-text="payout?.worker"></span>
                </p>
                <p class="text-sm text-gray-500 mb-4" x-text="payout?.bank"></p>

                <form method="POST" :action="payout?.action" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="proof">Foto Bukti Transfer <span class="text-red-500">*</span></x-input-label>
                        <input type="file" name="proof" id="proof" accept="image/*" required
                               class="mt-1 block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:bg-gray-100 file:text-gray-700">
                    </div>
                    <div>
                        <x-input-label for="admin_note" :value="__('Catatan (opsional)')" />
                        <input type="text" name="admin_note" id="admin_note" maxlength="255"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm px-4 py-2"
                               placeholder="Contoh: transfer via BCA, ref 123456">
                    </div>
                    <div class="flex justify-end gap-3">
                        <x-secondary-button type="button" @click="payout = null">Batal</x-secondary-button>
                        <x-primary-button>Tandai Sudah Dibayar</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
