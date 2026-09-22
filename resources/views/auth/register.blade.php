@extends('layouts.oregonet-auth')

@section('title', __('Register'))

@section('content')

    <h1 class="au-title">{{ __('Register') }}</h1>
    <p class="au-sub">{{ __('Create an account to order apartment services.') }}</p>

    <form method="POST" action="{{ route('register') }}" class="au-form">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="au-label">{{ __('Name') }}</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                class="au-input {{ $errors->has('name') ? 'has-error' : '' }}"
            />
            @error('name')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="au-label">{{ __('Email') }}</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                class="au-input {{ $errors->has('email') ? 'has-error' : '' }}"
            />
            @error('email')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="au-label">{{ __('Phone Number') }}</label>
            <input
                id="phone"
                type="tel"
                name="phone"
                value="{{ old('phone') }}"
                autocomplete="tel"
                class="au-input {{ $errors->has('phone') ? 'has-error' : '' }}"
            />
            @error('phone')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="au-label">{{ __('Status') }}</label>

            <select
                id="status"
                name="status"
                required
                class="au-input {{ $errors->has('status') ? 'has-error' : '' }}"
            >
                <option value="" disabled {{ old('status') ? '' : 'selected' }}>
                    {{ __('Pilih status') }}
                </option>

                <option value="penyewa" @selected(old('status') === 'penyewa')>
                    {{ __('Penyewa') }}
                </option>

                <option value="pemilik" @selected(old('status') === 'pemilik')>
                    {{ __('Pemilik') }}
                </option>

                <option value="agent" @selected(old('status') === 'agent')>
                    {{ __('Agent') }}
                </option>
            </select>

            @error('status')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Daerah -->
        <div>
            <label for="daerah" class="au-label">{{ __('Daerah') }}</label>

            <select
                id="daerah"
                name="daerah"
                required
                class="au-input {{ $errors->has('daerah') ? 'has-error' : '' }}"
            >
                <option value="" disabled {{ old('daerah') ? '' : 'selected' }}>
                    {{ __('Pilih daerah') }}
                </option>

                <option value="Jakarta" @selected(old('daerah') === 'Jakarta')>
                    Jakarta
                </option>
            </select>

            <p class="au-help">
                {{ __('Saat ini layanan baru tersedia untuk area Jakarta.') }}
            </p>

            @error('daerah')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Lokasi Unit -->
        <div>
            <label for="apartment_location_id" class="au-label">
                {{ __('Lokasi Unit') }}
            </label>

            <select
                id="apartment_location_id"
                name="apartment_location_id"
                required
                class="au-input {{ $errors->has('apartment_location_id') ? 'has-error' : '' }}"
            >
                <option value="" disabled {{ old('apartment_location_id') ? '' : 'selected' }}>
                    {{ __('Pilih lokasi unit') }}
                </option>

                @foreach ($locations as $location)
                    <option
                        value="{{ $location->id }}"
                        @selected((string) old('apartment_location_id') === (string) $location->id)
                    >
                        {{ $location->name }}
                    </option>
                @endforeach
            </select>

            @error('apartment_location_id')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tower -->
        <div>
            <label for="apartment_tower_id" class="au-label">
                {{ __('Tower') }}
            </label>

            <select
                id="apartment_tower_id"
                name="apartment_tower_id"
                required
                class="au-input {{ $errors->has('apartment_tower_id') ? 'has-error' : '' }}"
            >
                <option value="">
                    {{ __('Pilih lokasi unit dahulu') }}
                </option>
            </select>

            @error('apartment_tower_id')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Apartment Unit Number -->
        <div>
            <label for="apartment_unit_number" class="au-label">
                {{ __('Unit Number') }}
                <span style="font-weight: 400; opacity: 0.6;">
                    ({{ __('Optional') }})
                </span>
            </label>

            <input
                id="apartment_unit_number"
                type="text"
                name="apartment_unit_number"
                value="{{ old('apartment_unit_number') }}"
                autocomplete="off"
                placeholder="e.g., A-1203"
                class="au-input {{ $errors->has('apartment_unit_number') ? 'has-error' : '' }}"
            />

            <p class="au-help">
                {{ __('Kosongkan jika Anda ingin menjaga privasi nomor unit.') }}
            </p>

            @error('apartment_unit_number')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="au-label">{{ __('Password') }}</label>

            <div class="au-pw">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="au-input {{ $errors->has('password') ? 'has-error' : '' }}"
                />

                <button
                    type="button"
                    class="au-pw-toggle"
                    data-toggle-pw="password"
                    aria-label="{{ __('Show password') }}"
                    aria-pressed="false"
                >
                    <svg class="eye" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>

                    <svg class="eye-off" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                    </svg>
                </button>
            </div>

            @error('password')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="au-label">
                {{ __('Confirm Password') }}
            </label>

            <div class="au-pw">
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="au-input {{ $errors->has('password_confirmation') ? 'has-error' : '' }}"
                />

                <button
                    type="button"
                    class="au-pw-toggle"
                    data-toggle-pw="password_confirmation"
                    aria-label="{{ __('Show password') }}"
                    aria-pressed="false"
                >
                    <svg class="eye" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>

                    <svg class="eye-off" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                    </svg>
                </button>
            </div>

            @error('password_confirmation')
                <p class="au-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit" class="au-btn">
            {{ __('Register') }}
        </button>
    </form>

    <p class="au-foot">
        <a class="au-link" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>
    </p>

    @php
        $towersByLocation = $locations->mapWithKeys(function ($loc) {
            return [
                $loc->id => $loc->towers->map(function ($t) {
                    return [
                        'id' => $t->id,
                        'name' => $t->name,
                    ];
                }),
            ];
        });
    @endphp

    <script>
        const towersByLocation = @json($towersByLocation);
        const oldTowerId = @json(old('apartment_tower_id'));

        const locationSelect = document.getElementById('apartment_location_id');
        const towerSelect = document.getElementById('apartment_tower_id');

        function renderTowers(locationId) {
            towerSelect.innerHTML = '';

            const towers = towersByLocation[locationId] ?? [];

            if (towers.length === 0) {
                towerSelect.innerHTML =
                    '<option value="">Pilih lokasi unit dahulu</option>';
                return;
            }

            towerSelect.innerHTML =
                '<option value="" disabled selected>Pilih tower</option>';

            towers.forEach((tower) => {
                const opt = document.createElement('option');

                opt.value = tower.id;
                opt.textContent = tower.name;

                if (String(tower.id) === String(oldTowerId)) {
                    opt.selected = true;
                }

                towerSelect.appendChild(opt);
            });
        }

        locationSelect.addEventListener('change', (e) => {
            renderTowers(e.target.value);
        });

        if (locationSelect.value) {
            renderTowers(locationSelect.value);
        }
    </script>

@endsection
