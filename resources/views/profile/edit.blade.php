@extends('layouts.guest')

@section('title', 'Profil')

@section('header')
    <h2 class="font-semibold text-lg text-gray-800">{{ __('Profil') }}</h2>
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
                <p class="font-bold text-gray-900 truncate">{{ $user->name }}</p>
                <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
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

    </div>
@endsection
