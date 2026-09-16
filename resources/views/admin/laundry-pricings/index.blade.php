<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Harga Laundry') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
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

            <div class="flex items-center justify-between mb-6">
                <h3 class="font-semibold text-gray-900 text-lg">Daftar Harga Laundry</h3>
                <a href="{{ route('admin.laundry-pricings.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                    + Tambah Harga
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Durasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga / Kg</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibuat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @if ($pricings->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data harga laundry</td>
                            </tr>
                        @else
                            @foreach ($pricings as $pricing)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $pricing->typeLabel() }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $pricing->durationLabel() }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">Rp{{ number_format($pricing->price_per_kg, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full @if($pricing->is_active) bg-green-100 text-green-800 @else bg-gray-100 text-gray-600 @endif">
                                            {{ $pricing->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $pricing->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.laundry-pricings.edit', $pricing) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                                            <form action="{{ route('admin.laundry-pricings.destroy', $pricing) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('Hapus harga ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                @if ($pricings->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $pricings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
