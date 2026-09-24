<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail User') }}
        </h2>
    </x-slot>

@php
    $roleBadge = match ($user->role) {
        'admin'   => 'bg-purple-100 text-purple-800',
        'pekerja' => 'bg-blue-100 text-blue-800',
        default   => 'bg-green-100 text-green-800',
    };

    $statusBadge = fn ($s) => match ($s) {
        'pending'          => 'bg-yellow-100 text-yellow-800',
        'assigned'         => 'bg-blue-100 text-blue-800',
        'in_progress'      => 'bg-purple-100 text-purple-800',
        'waiting_approval' => 'bg-orange-100 text-orange-800',
        'completed'        => 'bg-green-100 text-green-800',
        'rejected'         => 'bg-red-100 text-red-800',
        default             => 'bg-gray-100 text-gray-800',
    };

    // Sesuaikan 'coins' bila nama kolom poin/koin di tabel users berbeda
    $coins = $user->coins ?? 0;
@endphp

<div class="py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Profil -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4 mb-5">
                <div class="h-14 w-14 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xl font-semibold shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <h3 class="font-semibold text-gray-900 text-lg truncate">{{ $user->name }}</h3>
                    <span class="inline-block mt-1 px-2 py-1 text-xs font-medium rounded-full {{ $roleBadge }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-gray-500">Email</dt>
                    <dd class="font-medium break-all">{{ $user->email }}</dd>
                </div>

                <div>
                    <dt class="text-gray-500">Telepon</dt>
                    <dd class="font-medium">{{ $user->phone ?? '-' }}</dd>
                </div>

                @if ($user->role === 'pekerja')
                    <div>
                        <dt class="text-gray-500">Spesialisasi Jasa</dt>
                        <dd class="font-medium">{{ $user->specialization ?? 'Semua jasa' }}</dd>
                    </div>
                @endif

                @if ($user->role === 'guest')
                    <div>
                        <dt class="text-gray-500">Unit Apartemen</dt>
                        <dd class="font-medium">{{ $user->apartment_unit_number ?? '-' }}</dd>
                    </div>
                @endif

                <div>
                    <dt class="text-gray-500">Email Terverifikasi</dt>
                    <dd class="font-medium">
                        {{ $user->email_verified_at ? $user->email_verified_at->format('d M Y H:i') : 'Belum' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-gray-500">Bergabung</dt>
                    <dd class="font-medium">{{ $user->created_at->format('d M Y H:i') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Saldo & Poin (hanya guest) -->
        @if ($user->role === 'guest')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">Saldo</p>
                    <p class="mt-1 text-2xl font-semibold text-green-700">
                        Rp{{ number_format($user->balance, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">Poin</p>
                    <p class="mt-1 text-2xl font-semibold text-amber-600">
                        {{ number_format($coins, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        @endif

        <!-- Aktivitas (guest & pekerja) -->
        @if ($user->role !== 'admin')
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-900">
                        {{ $user->role === 'pekerja' ? 'Tugas Pekerja' : 'Service Request' }}
                    </h3>

                    <p class="text-sm text-gray-500">
                        {{ $totalRequests }} total · {{ $completedRequests }} selesai
                    </p>
                </div>

                @if ($recentRequests->isEmpty())
                    <p class="text-sm text-gray-500">Belum ada data.</p>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach ($recentRequests as $sr)
                            <a href="{{ route('admin.service-requests.show', $sr) }}"
                               class="flex items-center justify-between gap-3 py-3 hover:bg-gray-50 -mx-2 px-2 rounded-md">
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-900 truncate">
                                        {{ $sr->service->name ?? '-' }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        {{ $sr->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>

                                <span class="shrink-0 px-2 py-1 text-xs font-medium rounded-full {{ $statusBadge($sr->status) }}">
                                    {{ ucfirst(str_replace('_', ' ', $sr->status)) }}
                                </span>
                            </a>
                        @endforeach
                    </div>

                    <p class="mt-3 text-xs text-gray-400">
                        Menampilkan 5 terbaru.
                    </p>
                @endif
            </div>
        @endif

        <a href="{{ route('admin.users.index') }}"
           class="inline-block text-indigo-600 hover:underline">
            ← Kembali ke Daftar
        </a>

    </div>
</div>

</x-app-layout>
