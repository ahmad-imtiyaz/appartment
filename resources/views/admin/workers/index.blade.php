<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Pekerja') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 p-3 bg-green-50 text-green-800 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-3 bg-red-50 text-red-800 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Add Worker Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 mb-8">
                <h3 class="font-semibold text-gray-900 mb-4">Tambah Pekerja Baru</h3>
                <form method="POST" action="{{ route('admin.workers.store') }}" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="name" :value="__('Nama')" />
                            <x-text-input id="name" name="name" required class="mt-1 block w-full" autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" type="email" name="email" required class="mt-1 block w-full" autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="phone" :value="__('Telepon')" />
                            <x-text-input id="phone" type="tel" name="phone" class="mt-1 block w-full" autocomplete="tel" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Password default: <code class="bg-gray-100 px-1 rounded">password</code> (bisa diubah oleh pekerja setelah login)</p>
                    </div>
                    <x-primary-button class="w-full sm:w-auto justify-center">
                        Tambah Pekerja
                    </x-primary-button>
                </form>
            </div>

            <!-- Workers: mobile card list -->
            <div class="space-y-3 lg:hidden">
                @forelse ($workers as $worker)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <p class="font-medium text-gray-900">{{ $worker->name }}</p>
                        <dl class="mt-2 grid grid-cols-2 gap-y-1.5 text-sm">
                            <dt class="text-gray-500">Email</dt>
                            <dd class="text-gray-900 text-right truncate">{{ $worker->email }}</dd>

                            <dt class="text-gray-500">Telepon</dt>
                            <dd class="text-gray-900 text-right">{{ $worker->phone ?? '-' }}</dd>

                            <dt class="text-gray-500">Dibuat</dt>
                            <dd class="text-gray-900 text-right">{{ $worker->created_at->format('d M Y') }}</dd>
                        </dl>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center text-gray-500">
                        Belum ada data pekerja
                    </div>
                @endforelse
            </div>

            <!-- Workers: desktop table -->
            <div class="hidden lg:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @if ($workers->isEmpty())
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data pekerja</td>
                                </tr>
                            @else
                                @foreach ($workers as $worker)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-medium text-gray-900">{{ $worker->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $worker->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $worker->phone ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $worker->created_at->format('d M Y') }}</td>
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
