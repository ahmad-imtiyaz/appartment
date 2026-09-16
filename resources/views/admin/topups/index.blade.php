<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Top Up') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 p-3 bg-green-50 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-3 bg-red-50 text-red-800 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Top Up Requests Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @if ($topupRequests->isEmpty())
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada pengajuan top up</td>
                                </tr>
                            @else
                                @foreach ($topupRequests as $topup)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $topup->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $topup->user->email }}</div>
                                            @if ($topup->user->apartment_unit_number)
                                                <div class="text-xs text-gray-400">Unit: {{ $topup->user->apartment_unit_number }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $topup->paymentMethod->display_name }}</td>
                                        <td class="px-6 py-4 font-semibold text-indigo-600">Rp{{ number_format($topup->amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ Storage::url($topup->proof_image) }}" target="_blank" class="inline-block">
                                                <img src="{{ Storage::url($topup->proof_image) }}" alt="Bukti" class="w-20 h-20 object-cover rounded border border-gray-200">
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                @if($topup->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($topup->status === 'approved') bg-green-100 text-green-800
                                                @elseif($topup->status === 'rejected') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($topup->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $topup->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4">
                                            @if ($topup->status === 'pending')
                                                <div class="space-x-2">
                                                    <form method="POST" action="{{ route('admin.topups.approve', $topup) }}" class="inline" onsubmit="return confirm('Yakin approve top up ini?')">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900 font-medium">Approve</button>
                                                    </form>
                                                    <button onclick="openRejectModal({{ $topup->id }})" class="text-red-600 hover:text-red-900 font-medium">Reject</button>
                                                </div>
                                            @elseif ($topup->status === 'rejected' && $topup->admin_note)
                                                <span class="text-sm text-red-600">{{ $topup->admin_note }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $topupRequests->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="reject-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="font-semibold text-lg text-gray-900 mb-4">Tolak Top Up</h3>
            <form method="POST" id="reject-form" class="space-y-4">
                @csrf
                <input type="hidden" name="topup_id" id="reject-id">
                
                <div>
                    <x-input-label for="admin_note" :value="__('Alasan Penolakan') <span class=\"text-red-500\">*</span>" />
                    <textarea name="admin_note" id="admin_note" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2" placeholder="Contoh: Bukti transfer tidak jelas, nominal tidak sesuai, dsb."></textarea>
                    <x-input-error :messages="$errors->get('admin_note')" class="mt-2" />
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <x-secondary-button type="button" onclick="closeRejectModal()">
                        Batal
                    </x-secondary-button>
                    <x-danger-button type="submit">
                        Tolak
                    </x-danger-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRejectModal(id) {
            document.getElementById('reject-id').value = id;
            document.getElementById('admin_note').value = '';
            document.getElementById('reject-form').action = `{{ route('admin.topups.reject', ':id') }}`.replace(':id', id);
            document.getElementById('reject-modal').classList.remove('hidden');
            document.getElementById('reject-modal').classList.add('flex');
        }

        function closeRejectModal() {
            document.getElementById('reject-modal').classList.add('hidden');
            document.getElementById('reject-modal').classList.remove('flex');
        }

        // Close modal on outside click
        document.getElementById('reject-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</x-app-layout>