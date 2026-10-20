@extends('layouts.oregonet-auth')

@section('title', __('Reset password'))

@section('content')

    <h1 class="au-title">{{ __('Reset password') }}</h1>
    <p class="au-sub">{{ __('Enter the 6-digit code from your email and choose a new password.') }}</p>

    <x-auth-session-status class="mt-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.store') }}" class="au-form">
        @csrf

        <div>
            <label for="email" class="au-label">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ $email }}"
                   required autocomplete="username"
                   class="au-input {{ $errors->has('email') ? 'has-error' : '' }}" />
            @error('email')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="code" class="au-label">{{ __('Verification code') }}</label>
            <input id="code" type="text" name="code" inputmode="numeric" maxlength="6"
                   pattern="[0-9]{6}" required autofocus autocomplete="one-time-code"
                   class="au-input {{ $errors->has('code') ? 'has-error' : '' }}" />
            @error('code')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="au-label">{{ __('New password') }}</label>
            <div class="au-pw">
                <input id="password" type="password" name="password"
                       required autocomplete="new-password"
                       class="au-input {{ $errors->has('password') ? 'has-error' : '' }}" />
                @include('auth.partials.pw-toggle', ['target' => 'password'])
            </div>
            @error('password')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="au-label">{{ __('Confirm new password') }}</label>
            <div class="au-pw">
                <input id="password_confirmation" type="password" name="password_confirmation"
                       required autocomplete="new-password" class="au-input" />
                @include('auth.partials.pw-toggle', ['target' => 'password_confirmation'])
            </div>
        </div>

        <button type="submit" class="au-btn">{{ __('Change password') }}</button>
    </form>

    <p class="au-foot">
        {{ __("Didn't receive the code?") }}
        <a class="au-link" href="{{ route('password.request') }}">{{ __('Send again') }}</a>
    </p>

@endsection
