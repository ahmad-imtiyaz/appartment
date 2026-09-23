<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Penarikan Saldo') }}</h2>
    </x-slot>

    <div class="py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            @if (session('success'))
                <div class="mb-6 p-3 bg-green-50 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-3 bg-red-50 text-red-800 rounded-lg text-sm">{{ session('error') }}</div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                @foreach (['User', 'Rekening Tujuan', 'Nominal', 'Biaya', 'Ditransfer', 'Status', 'Waktu', 'Aksi'] as $th)
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $th }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($withdrawals as $w)
                                <tr class="hover:bg-gray-50 align-top">
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-gray-900">{{ $w->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $w->user->email }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm">
                                        <div class="font-medium">{{ $w->bank_name }}</div>
                                        <div>{{ $w->account_number }}</div>
                                        <div class="text-gray-500">a.n. {{ $w->account_holder_name }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm">Rp{{ number_format($w->amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 text-sm text-gray-500">Rp{{ number_format($w->fee, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 font-semibold text-indigo-600">Rp{{ number_format($w->net_amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            @if($w->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($w->status === 'approved') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($w->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-500">{{ $w->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-4">
                                        @if ($w->isPending())
                                            <div class="space-x-2 whitespace-nowrap">
                                                <form method="POST" action="{{ route('admin.withdrawals.approve', $w) }}" class="inline"
                                                      onsubmit="return confirm('Pastikan Rp{{ number_format($w->net_amount, 0, ',', '.') }} sudah ditransfer ke rekening tujuan. Lanjutkan?')">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 font-medium">Sudah Transfer</button>
                                                </form>
                                                <button type="button" onclick="openRejectModal({{ $w->id }})" class="text-red-600 hover:text-red-900 font-medium">Tolak</button>
                                            </div>
                                        @elseif ($w->status === 'rejected' && $w->admin_note)
                                            <span class="text-sm text-red-600">{{ $w->admin_note }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada pengajuan penarikan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100">{{ $withdrawals->links() }}</div>
            </div>
        </div>
    </div>

    <div id="reject-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 px-4">
        <div class="bg-white rounded-xl p-6 w-full max-w-md">
            <h3 class="font-semibold text-lg text-gray-900 mb-1">Tolak Penarikan</h3>
            <p class="text-sm text-gray-500 mb-4">Saldo user akan dikembalikan penuh.</p>
            <form method="POST" id="reject-form" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="admin_note" :value="__('Alasan Penolakan')" />
                    <textarea name="admin_note" id="admin_note" rows="3" required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm px-4 py-2"
                              placeholder="Contoh: Nomor rekening tidak valid."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <x-secondary-button type="button" onclick="closeRejectModal()">Batal</x-secondary-button>
                    <x-danger-button type="submit">Tolak</x-danger-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(id) {
            document.getElementById('admin_note').value = '';
            document.getElementById('reject-form').action = `{{ route('admin.withdrawals.reject', ':id') }}`.replace(':id', id);
            const m = document.getElementById('reject-modal');
            m.classList.remove('hidden'); m.classList.add('flex');
        }
        function closeRejectModal() {
            const m = document.getElementById('reject-modal');
            m.classList.add('hidden'); m.classList.remove('flex');
        }
        document.getElementById('reject-modal').addEventListener('click', e => { if (e.target === e.currentTarget) closeRejectModal(); });
    </script>
</x-app-layout>
