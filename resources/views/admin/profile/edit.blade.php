<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Admin') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">

            <!-- Avatar / User summary card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4 mb-6">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center shrink-0 border border-purple-200">
    <svg
        class="w-8 h-8 text-purple-600"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        stroke-width="1.8"
    >
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
        />
    </svg>
</div>

                <div class="min-w-0">
                    <p class="font-bold text-gray-900 truncate">
                        {{ $user->name }}
                    </p>

                    <p class="text-sm text-gray-500 truncate">
                        {{ $user->email }}
                    </p>

                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mt-1">
                        Admin
                    </span>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                @include('admin.profile.partials.update-profile-information-form')
            </div>

            <!-- Update Password -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                @include('admin.profile.partials.update-password-form')
            </div>

            <!-- Delete Account -->
            <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6">
                @include('admin.profile.partials.delete-user-form')
            </div>

        </div>
    </div>

</x-app-layout>
