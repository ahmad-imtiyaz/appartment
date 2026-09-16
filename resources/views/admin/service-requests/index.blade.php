<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Service Request') }}
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

            <!-- Filter -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
                <form method="GET" class="flex items-center gap-4">
                    <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request()->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="assigned" {{ request()->status === 'assigned' ? 'selected' : '' }}>Assigned</option>
                        <option value="in_progress" {{ request()->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request()->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="rejected" {{ request()->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <x-primary-button type="submit">Filter</x-primary-button>
                    <a href="{{ route('admin.service-requests.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Reset</a>
                </form>
            </div>

            <!-- Service Requests Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jasa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pekerja</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @if ($serviceRequests->isEmpty())
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada data service request</td>
                                </tr>
                            @else
                                @foreach ($serviceRequests as $sr)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $sr->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $sr->user->email }}</div>
                                            @if ($sr->user->apartment_unit_number)
                                                <div class="text-xs text-gray-400">Unit: {{ $sr->user->apartment_unit_number }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $sr->service->name }}</div>
                                            @if ($sr->scheduled_at)
                                                <div class="text-xs text-gray-500">Jadwal: {{ $sr->scheduled_at->format('d M Y H:i') }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                                @if($sr->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($sr->status === 'assigned') bg-blue-100 text-blue-800
                                                @elseif($sr->status === 'in_progress') bg-purple-100 text-purple-800
                                                @elseif($sr->status === 'completed') bg-green-100 text-green-800
                                                @elseif($sr->status === 'rejected') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $sr->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($sr->worker)
                                                <div class="font-medium text-gray-900">{{ $sr->worker->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $sr->worker->phone }}</div>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $sr->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('admin.service-requests.show', $sr) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $serviceRequests->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>