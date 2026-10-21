<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendapatan & Pencairan') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-6">

            @if (session('success'))
                <div class="p-3 bg-green-50 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="p-3 bg-red-50 text-red-800 rounded-lg text-sm">{{ session('error') }}</div>
            @endif

            <!-- Ringkasan -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-xs text-gray-500">Belum diajukan</p>
                    <p class="mt-1 text-lg font-bold text-gray-900">Rp{{ number_format($unrequested->sum('worker_earning'), 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400">{{ $unrequested->count() }} tugas</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-xs text-gray-500">Menunggu admin</p>
                    <p class="mt-1 text-lg font-bold text-yellow-700">Rp{{ number_format($totalPending, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-xs text-gray-500">Sudah dibayarkan</p>
                    <p class="mt-1 text-lg font-bold text-green-700">Rp{{ number_format($totalPaid, 0, ',', '.') }}</p>
                </div>
            </div>

            @unless (auth()->user()->hasBankAccount())
                <div class="p-3 bg-yellow-50 text-yellow-800 rounded-lg text-sm">
                    Kamu belum mengisi rekening pencairan.
                    <a href="{{ route('worker.profile.edit') }}#rekening" class="font-semibold underline">Isi rekening sekarang</a>
                </div>
            @endunless

            <!-- Tugas yang belum diajukan -->
            @if ($unrequested->isNotEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-semibold text-gray-900">Bisa Diajukan</h3>
                    <p class="text-sm text-gray-500 mb-3">Tugas selesai yang pendapatannya belum diajukan pencairan.</p>

                    <div class="divide-y divide-gray-100">
                        @foreach ($unrequested as $task)
                            <div class="py-3 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <a href="{{ route('worker.tasks.show', $task) }}" class="font-medium text-gray-900 hover:underline">
                                        {{ $task->service->name }} #{{ $task->id }}
                                    </a>
                                    <p class="text-xs text-gray-500">Selesai {{ $task->completed_at?->format('d M Y') }}</p>
                                </div>
                                <div class="flex items-center gap-3 shrink-0">
                                    <span class="font-semibold text-gray-900">Rp{{ number_format($task->worker_earning, 0, ',', '.') }}</span>
                                    @if (auth()->user()->hasBankAccount())
                                        <form method="POST" action="{{ route('worker.payouts.store', $task) }}"
                                              onsubmit="return confirm('Ajukan pencairan Rp{{ number_format($task->worker_earning, 0, ',', '.') }}?')">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-md">
                                                Ajukan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Riwayat Pencairan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="font-semibold text-gray-900 mb-3">Riwayat Pencairan</h3>

                @forelse ($payouts as $payout)
                    <div class="py-4 {{ $loop->first ? '' : 'border-t border-gray-100' }}">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <a href="{{ route('worker.tasks.show', $payout->service_request_id) }}" class="font-medium text-gray-900 hover:underline">
                                    {{ $payout->serviceRequest->service->name }} #{{ $payout->service_request_id }}
                                </a>
                                <p class="text-xs text-gray-500">
                                    Diajukan {{ $payout->created_at->format('d M Y H:i') }}
                                    · {{ $payout->bank_name }} {{ $payout->account_number }}
                                </p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="font-bold {{ $payout->isPaid() ? 'text-green-700' : 'text-gray-900' }}">Rp{{ number_format($payout->amount, 0, ',', '.') }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded-full
                                    {{ $payout->isPaid() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $payout->isPaid() ? 'Pembayaran Selesai' : 'Menunggu admin' }}
                                </span>
                            </div>
                        </div>

                        @if ($payout->isPaid())
                            <div class="mt-3 p-3 bg-green-50 rounded-lg text-sm text-green-900 flex gap-3">
                                @if ($payout->proofUrl())
                                    <a href="{{ $payout->proofUrl() }}" target="_blank" class="shrink-0">
                                        <img src="{{ $payout->proofUrl() }}" alt="Bukti transfer" class="w-16 h-16 object-cover rounded-md border border-green-200">
                                    </a>
                                @endif
                                <div>
                                    <p>Telah dibayarkan sejumlah <strong>Rp{{ number_format($payout->amount, 0, ',', '.') }}</strong></p>
                                    <p class="text-xs mt-0.5">{{ $payout->paid_at->format('d M Y H:i') }}</p>
                                    @if ($payout->admin_note)
                                        <p class="text-xs mt-0.5">Catatan admin: {{ $payout->admin_note }}</p>
                                    @endif
                                    @if ($payout->proofUrl())
                                        <a href="{{ $payout->proofUrl() }}" target="_blank" class="text-xs underline">Lihat bukti transfer</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-gray-500">Belum ada pengajuan pencairan.</p>
                @endforelse

                @if ($payouts->hasPages())
                    <div class="pt-4 border-t border-gray-100">{{ $payouts->links() }}</div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
