<section>
    <header>
        <h2 class="text-base font-semibold text-gray-900">
            {{ __('Ubah Password') }}
        </h2>

        <p class="mt-1 text-xs text-gray-500">
            {{ __('Pastikan akun kamu menggunakan password yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4 space-y-4">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')" class="text-sm" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full rounded-lg text-sm" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Password Baru')" class="text-sm" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full rounded-lg text-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password')" class="text-sm" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-lg text-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="flex items-center gap-3">
            <x-primary-button class="w-full justify-center rounded-lg py-2.5">{{ __('Simpan') }}</x-primary-button>
        </div>

        @if (session('status') === 'password-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-xs text-green-600 text-center"
            >{{ __('Tersimpan.') }}</p>
        @endif
    </form>
</section>
