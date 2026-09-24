
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola User') }}
            </h2>
            <a href="{{ route('admin.users.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition">
                + Tambah User
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 p-3 bg-green-50 text-green-800 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Statistik -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-sm text-gray-500">Total User</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $totalUsers }}</p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-sm text-gray-500">Pekerja</p>
                    <p class="mt-1 text-2xl font-semibold text-blue-700">
                        {{ $counts['pekerja'] ?? 0 }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-sm text-gray-500">Guest</p>
                    <p class="mt-1 text-2xl font-semibold text-green-700">
                        {{ $counts['guest'] ?? 0 }}
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-sm text-gray-500">Admin</p>
                    <p class="mt-1 text-2xl font-semibold text-purple-700">
                        {{ $counts['admin'] ?? 0 }}
                    </p>
                </div>
            </div>

            <!-- Tab Role -->
            <div class="mb-4 -mx-4 sm:mx-0 px-4 sm:px-0 overflow-x-auto">
                <div class="flex gap-2 w-max sm:w-auto">

                    <a href="{{ route('admin.users.index', array_filter(['search' => $search])) }}"
                       class="px-4 py-2 text-sm font-medium rounded-full border whitespace-nowrap
                              {{ !$role ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                        Semua
                    </a>

                    @foreach ($roles as $key => $label)
                        <a href="{{ route('admin.users.index', array_filter(['role' => $key, 'search' => $search])) }}"
                           class="px-4 py-2 text-sm font-medium rounded-full border whitespace-nowrap
                                  {{ $role === $key ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50' }}">
                            {{ $label }}
                        </a>
                    @endforeach

                </div>
            </div>

            <!-- Pencarian -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
                <form method="GET" class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">

                    @if ($role)
                        <input type="hidden" name="role" value="{{ $role }}">
                    @endif

                    <input type="text"
                           name="search"
                           value="{{ $search }}"
                           placeholder="Cari nama, email, atau telepon"
                           class="w-full sm:w-72 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">

                    <div class="flex items-center gap-4">
                        <x-primary-button type="submit">
                            Cari
                        </x-primary-button>

                        <a href="{{ route('admin.users.index') }}"
                           class="text-sm text-gray-500 hover:text-gray-700">
                            Reset
                        </a>
                    </div>

                </form>
            </div>

            @php
                $roleBadge = fn ($r) => match ($r) {
                    'admin'   => 'bg-purple-100 text-purple-800',
                    'pekerja' => 'bg-blue-100 text-blue-800',
                    default   => 'bg-green-100 text-green-800',
                };
            @endphp

            <!-- Users: mobile card list -->
            <div class="space-y-3 lg:hidden">

                @forelse ($users as $user)

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">

                        <div class="flex items-start justify-between gap-3 mb-3">

                            <div class="min-w-0">

                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="font-medium text-gray-900 hover:text-indigo-600 truncate block">
                                    {{ $user->name }}
                                </a>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ $user->email }}
                                </p>

                                @if ($user->role === 'pekerja')
                                    <div class="text-xs text-blue-600">
                                        {{ $user->specialization ?? 'Semua jasa' }}
                                    </div>
                                @endif

                            </div>

                            <span class="shrink-0 px-2 py-1 text-xs font-medium rounded-full {{ $roleBadge($user->role) }}">
                                {{ ucfirst($user->role) }}
                            </span>

                        </div>

                        <dl class="grid grid-cols-2 gap-y-1.5 text-sm mb-3">

                            <dt class="text-gray-500">Telepon</dt>
                            <dd class="text-gray-900 text-right">
                                {{ $user->phone ?? '-' }}
                            </dd>

                            @if ($user->role === 'guest')

                                <dt class="text-gray-500">Unit</dt>
                                <dd class="text-gray-900 text-right">
                                    {{ $user->apartment_unit_number ?? '-' }}
                                </dd>

                                <dt class="text-gray-500">Saldo</dt>
                                <dd class="text-gray-900 text-right">
                                    Rp{{ number_format($user->balance, 0, ',', '.') }}
                                </dd>

                            @endif

                            <dt class="text-gray-500">Bergabung</dt>
                            <dd class="text-gray-900 text-right">
                                {{ $user->created_at->format('d M Y') }}
                            </dd>

                        </dl>

                        <a href="{{ route('admin.users.show', $user) }}"
                           class="block w-full text-center rounded-md border border-indigo-200 text-indigo-600 text-sm font-medium py-2 hover:bg-indigo-50">
                            Lihat Detail
                        </a>

                    </div>

                @empty

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center text-gray-500">
                        Tidak ada data user
                    </div>

                @endforelse

            </div>

            <!-- Users: desktop table -->
            <div class="hidden lg:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Telepon
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Unit
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Saldo
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Bergabung
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse ($users as $user)

                                <tr class="hover:bg-gray-50">

                                    <td class="px-6 py-4">

                                        <a href="{{ route('admin.users.show', $user) }}"
                                           class="font-medium text-gray-900 hover:text-indigo-600">
                                            {{ $user->name }}
                                        </a>

                                        <div class="text-sm text-gray-500">
                                            {{ $user->email }}
                                        </div>

                                        @if ($user->role === 'pekerja')
                                            <div class="text-xs text-blue-600">
                                                {{ $user->specialization ?? 'Semua jasa' }}
                                            </div>
                                        @endif

                                    </td>

                                    <td class="px-6 py-4">

                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $roleBadge($user->role) }}">
                                            {{ ucfirst($user->role) }}
                                        </span>

                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $user->phone ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">

                                        {{ $user->role === 'guest'
                                            ? ($user->apartment_unit_number ?? '-')
                                            : '-' }}

                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">

                                        @if ($user->role === 'guest')

                                            Rp{{ number_format($user->balance, 0, ',', '.') }}

                                        @else

                                            -

                                        @endif

                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <a href="{{ route('admin.users.show', $user) }}"
                                           class="text-indigo-600 hover:text-indigo-900 font-medium">
                                            Detail
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7"
                                        class="px-6 py-8 text-center text-gray-500">
                                        Tidak ada data user
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>

            </div>

            <!-- Pagination (mobile) -->
            <div class="lg:hidden mt-4">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
