<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tugas Saya') }}
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

            <!-- Tasks Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guest</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jasa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diajukan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @if ($tasks->isEmpty())
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada tugas yang di-assign ke Anda</td>
                                </tr>
                            @else
                                @foreach ($tasks as $task)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $task->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $task->user->phone }}</div>
                                            @if ($task->user->apartment_unit_number)
                                                <div class="text-xs text-gray-400">Unit: {{ $task->user->apartment_unit_number }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $task->service->name }}</div>
                                            @if ($task->service->slug === 'maintenance-repair' && $task->maintenanceDetail)
                                                <div class="text-xs text-gray-500">{{ $task->maintenanceDetail->damage_category }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 text-sm font-medium rounded-full 
                                                @if($task->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($task->status === 'assigned') bg-blue-100 text-blue-800
                                                @elseif($task->status === 'in_progress') bg-purple-100 text-purple-800
                                                @elseif($task->status === 'completed') bg-green-100 text-green-800
                                                @elseif($task->status === 'rejected') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $task->created_at->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            @if ($task->scheduled_at)
                                                {{ $task->scheduled_at->format('d M Y H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('worker.tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>