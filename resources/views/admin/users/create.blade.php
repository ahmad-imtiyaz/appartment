<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah User') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5"
                      x-data="{ role: '{{ old('role', 'pekerja') }}' }">
                    @csrf

                    <div>
                        <x-input-label for="role">
                            {{ __('Role') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <select name="role" id="role" x-model="role" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">
                            @foreach ($roles as $key => $label)
                                <option value="{{ $key }}" {{ old('role', 'pekerja') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />

                        <p x-show="role === 'admin'" x-cloak class="mt-2 text-xs text-amber-600">
                            Admin punya akses penuh ke seluruh panel ini. Buat hanya untuk orang yang dipercaya.
                        </p>
                    </div>

                    <div>
                        <x-input-label for="name">
                            {{ __('Nama') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="name" type="text" name="name" class="mt-1 block w-full"
                                      :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email">
                            {{ __('Email') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="email" type="email" name="email" class="mt-1 block w-full"
                                      :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="phone" :value="__('No. Telepon')" />
                        <x-text-input id="phone" type="text" name="phone" class="mt-1 block w-full"
                                      :value="old('phone')" placeholder="08xxxxxxxxxx" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div x-show="role === 'guest'" x-cloak>
                        <x-input-label for="apartment_unit_number" :value="__('Nomor Unit Apartemen')" />
                        <x-text-input id="apartment_unit_number" type="text" name="apartment_unit_number"
                                      class="mt-1 block w-full" :value="old('apartment_unit_number')"
                                      placeholder="Contoh: A-1205" />
                        <x-input-error :messages="$errors->get('apartment_unit_number')" class="mt-2" />
                    </div>

                    <!-- Spesialisasi Jasa (khusus pekerja, pilih 1) -->
                    <div x-show="role === 'pekerja'" x-cloak>
                        <x-input-label for="specialization" :value="__('Spesialisasi Jasa')" />
                        <select name="specialization" id="specialization"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2 bg-white">
                            <option value="">Semua jasa (tidak dibatasi)</option>
                            @foreach ($services as $serviceName)
                                <option value="{{ $serviceName }}" {{ old('specialization') === $serviceName ? 'selected' : '' }}>
                                    {{ $serviceName }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">
                            Pekerja hanya akan muncul di pilihan assign untuk jasa ini.
                        </p>
                        <x-input-error :messages="$errors->get('specialization')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password">
                            {{ __('Password') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="password" type="password" name="password" class="mt-1 block w-full"
                                      required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation">
                            {{ __('Konfirmasi Password') }} <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                                      class="mt-1 block w-full" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <x-primary-button>Buat Akun</x-primary-button>
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
