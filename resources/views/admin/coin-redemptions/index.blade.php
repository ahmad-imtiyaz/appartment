<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Penukaran Poin') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
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

            <!-- Filters -->
            <form method="GET" class="mb-6 flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari nama guest / produk..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Sedang Proses</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Berhasil</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Filter
                </button>
                @if (request('search') || request('status'))
                    <a href="{{ route('admin.coin-redemptions.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Redemptions Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @if ($redemptions->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <p class="mt-2 text-gray-500">Belum ada permintaan penukaran poin</p>
                    </div>
                @else
                    @php
                        $statusColors = [
                            'processing' => 'bg-yellow-100 text-yellow-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                        $statusLabels = [
                            'processing' => 'Sedang Proses',
                            'completed' => 'Berhasil',
                            'cancelled' => 'Dibatalkan',
                        ];
                    @endphp

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. WhatsApp</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Poin</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($redemptions as $redemption)
                                    @php
                                        // Normalisasi nomor untuk link wa.me (08xxx -> 628xxx)
                                        $rawPhone = $redemption->user->phone ?? null;
                                        $waNumber = null;
                                        if ($rawPhone) {
                                            $digits = preg_replace('/\D/', '', $rawPhone);
                                            if (str_starts_with($digits, '0')) {
                                                $digits = '62' . substr($digits, 1);
                                            } elseif (str_starts_with($digits, '8')) {
                                                $digits = '62' . $digits;
                                            }
                                            $waNumber = $digits ?: null;
                                        }
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-900">{{ $redemption->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $redemption->user->email }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if ($waNumber)
                                                <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener"
                                                   class="inline-flex items-center gap-1 text-green-600 hover:text-green-800 font-medium">
                                                    {{ $rawPhone }}
                                                </a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-900">{{ $redemption->product->name }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-900">
                                            <span class="font-medium text-indigo-600">{{ number_format($redemption->coin_cost) }} Poin</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$redemption->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $statusLabels[$redemption->status] ?? $redemption->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-500">
                                            {{ $redemption->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('admin.coin-redemptions.show', $redemption) }}"
                                                   class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                                    Detail
                                                </a>
                                                @if ($redemption->isProcessing())
                                                    <form method="POST" action="{{ route('admin.coin-redemptions.approve', $redemption) }}" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                                class="text-green-600 hover:text-green-800 text-sm font-medium"
                                                                onclick="return confirm('Approve penukaran ini?')">
                                                            Approve
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('admin.coin-redemptions.reject', $redemption) }}" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                                class="text-red-600 hover:text-red-800 text-sm font-medium"
                                                                onclick="return confirm('Reject penukaran ini? Poin akan dikembalikan ke guest.')">
                                                            Reject
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-4 py-3 border-t border-gray-100">
                        {{ $redemptions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
