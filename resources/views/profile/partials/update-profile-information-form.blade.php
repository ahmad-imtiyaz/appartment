<section>
    <header>
        <h2 class="text-base font-semibold text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-xs text-gray-500">
            {{ __('Perbarui nama dan alamat email akun kamu.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4 space-y-4">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama')" class="text-sm" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-lg text-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-1" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-lg text-sm" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-1" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-xs mt-2 text-gray-700">
                        {{ __('Email kamu belum terverifikasi.') }}

                        <button form="send-verification" class="underline text-xs text-indigo-600 hover:text-indigo-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Kirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-xs text-green-600">
                            {{ __('Link verifikasi baru telah dikirim ke email kamu.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <x-primary-button class="w-full justify-center rounded-lg py-2.5">{{ __('Simpan') }}</x-primary-button>
        </div>

        @if (session('status') === 'profile-updated')
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
