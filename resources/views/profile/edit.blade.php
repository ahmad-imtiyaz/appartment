
@extends('layouts.guest')

@section('title', 'Profil')

@section('header')
    <h2 class="font-semibold text-lg text-gray-800">
        {{ __('Profil') }}
    </h2>
@endsection

@section('content')
    <div class="px-4 py-4 space-y-4 bg-gray-50 min-h-screen">

        <!-- Avatar / User summary card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center shrink-0">
                <span class="text-white text-xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </span>
            </div>

            <div class="min-w-0">
                <p class="font-bold text-gray-900 truncate">
                    {{ $user->name }}
                </p>

                <p class="text-sm text-gray-500 truncate">
                    {{ $user->email }}
                </p>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Update Password -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete Account -->
        <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-4">
            @include('profile.partials.delete-user-form')
        </div>

        <!-- Logout -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-semibold rounded-xl transition duration-200"
                >
                    <!-- Logout Icon -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="w-5 h-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M18 15l3-3m0 0l-3-3m3 3H9"
                        />
                    </svg>

                    <span>
                        Logout
                    </span>
                </button>
            </form>
        </div>

    </div>
@endsection
