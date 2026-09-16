<section class="space-y-4">
    <header>
        <h2 class="text-base font-semibold text-red-700">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-1 text-xs text-gray-500">
            {{ __('Setelah akun kamu dihapus, semua data akan dihapus secara permanen. Unduh data yang ingin kamu simpan sebelum melanjutkan.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="w-full justify-center rounded-lg py-2.5"
    >{{ __('Hapus Akun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-base font-semibold text-gray-900">
                {{ __('Yakin ingin menghapus akun kamu?') }}
            </h2>

            <p class="mt-1 text-xs text-gray-500">
                {{ __('Setelah akun dihapus, semua data akan hilang permanen. Masukkan password untuk konfirmasi.') }}
            </p>

            <div class="mt-4">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-lg text-sm"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-2">
                <x-secondary-button class="w-full sm:w-auto justify-center rounded-lg" x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="w-full sm:w-auto justify-center rounded-lg">
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
