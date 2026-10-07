<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Saya') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto space-y-6">

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="p-3 bg-green-50 text-green-800 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-3 bg-red-50 text-red-800 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Ringkasan Akun -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sm:p-6">
                <div class="flex items-center gap-4">
                    <div class="shrink-0 w-14 h-14 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xl font-semibold">
                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-gray-900 truncate">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded-full bg-indigo-50 text-indigo-700">
                            Pekerja
                        </span>
                    </div>
                </div>

                <dl class="mt-5 pt-5 border-t border-gray-100 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500">Spesialisasi</dt>
                        <dd class="text-gray-900 font-medium">{{ $user->specialization ?: 'Semua jasa' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Bergabung sejak</dt>
                        <dd class="text-gray-900 font-medium">{{ $user->created_at->format('d M Y') }}</dd>
                    </div>
                </dl>
                <p class="mt-4 text-xs text-gray-400">
                    Spesialisasi diatur oleh admin. Hubungi admin jika perlu diubah.
                </p>
            </div>

            <!-- Informasi Akun -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sm:p-6">
                <h3 class="font-semibold text-lg text-gray-900">Informasi Akun</h3>
                <p class="mt-1 text-sm text-gray-500">Perbarui nama, email, dan nomor HP kamu.</p>

                <form method="POST" action="{{ route('worker.profile.update') }}" class="mt-6 space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="name" :value="__('Nama')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                            :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="phone" :value="__('Nomor HP')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                            :value="old('phone', $user->phone)" autocomplete="tel" placeholder="08xxxxxxxxxx" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>

                    <div class="flex justify-end pt-2">
                        <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Ubah Password -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sm:p-6">
                <h3 class="font-semibold text-lg text-gray-900">Ubah Password</h3>
                <p class="mt-1 text-sm text-gray-500">Gunakan password yang panjang dan acak agar akun tetap aman.</p>

                <form method="POST" action="{{ route('worker.profile.password') }}" class="mt-6 space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="current_password" :value="__('Password Saat Ini')" />
                        <x-text-input id="current_password" name="current_password" type="password"
                            class="mt-1 block w-full" autocomplete="current-password" />
                        <x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password Baru')" />
                        <x-text-input id="password" name="password" type="password"
                            class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                            class="mt-1 block w-full" autocomplete="new-password" />
                        <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
                    </div>

                    <div class="flex justify-end pt-2">
                        <x-primary-button>{{ __('Ubah Password') }}</x-primary-button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
