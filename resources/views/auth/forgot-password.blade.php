@extends('layouts.oregonet-auth')

@section('title', __('Forgot password'))

@section('content')

    <h1 class="au-title">{{ __('Forgot password') }}</h1>
    <p class="au-sub">{{ __('Enter your account email. We will send a 6-digit code.') }}</p>

    <form method="POST" action="{{ route('password.email') }}" class="au-form">
        @csrf

        <div>
            <label for="email" class="au-label">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   class="au-input {{ $errors->has('email') ? 'has-error' : '' }}" />
            @error('email')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="au-btn">{{ __('Send code') }}</button>
    </form>

    <p class="au-foot">
        {{ __('Remember your password?') }}
        <a class="au-link" href="{{ route('login') }}">{{ __('Log in') }}</a>
    </p>

@endsection
