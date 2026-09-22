@extends('layouts.guest')

@section('title', __('guest.profile.title'))

@push('styles')
<style>
    :root {
        --red: #DC2626;
        --red-dark: #B91C1C;
        --pink-bg: #FDECEF;
        --pink-icon: #DB2777;
        --border: #F1F1F1;
    }

    .profile-wrapper {
        max-width: 480px;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        min-height: 100vh;
        overflow-x: hidden;
    }

    .profile-header {
        background: #fff;
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        padding: 18px;
    }

    .profile-avatar {
        width: 58px;
        height: 58px;
        background: var(--red);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .profile-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        padding: 16px;
    }

    .section-title {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 14px;
    }

    .profile-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .profile-input {
        width: 100%;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        padding: 10px 12px;
        font-size: 13px;
        color: #111827;
        background: #fff;
        outline: none;
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    .profile-input:focus {
        border-color: var(--red);
        box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.08);
    }

    .btn-save {
        width: 100%;
        background: var(--red);
        color: #fff;
        border-radius: 10px;
        padding: 11px 14px;
        font-size: 13px;
        font-weight: 600;
        transition: background .15s ease, transform .15s ease;
    }

    .btn-save:hover {
        background: var(--red-dark);
    }

    .btn-save:active {
        transform: scale(.98);
    }

    .danger-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #FEE2E2;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        padding: 16px;
    }

    .btn-delete {
        width: 100%;
        background: #FEF2F2;
        color: #DC2626;
        border: 1px solid #FECACA;
        border-radius: 10px;
        padding: 11px 14px;
        font-size: 13px;
        font-weight: 600;
        transition: background .15s ease, transform .15s ease;
    }

    .btn-delete:hover {
        background: #FEE2E2;
    }

    .btn-delete:active {
        transform: scale(.98);
    }

    .btn-logout {
        width: 100%;
        background: #fff;
        color: #374151;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 13px;
        font-weight: 600;
        transition: background .15s ease, transform .15s ease;
    }

    .btn-logout:hover {
        background: #F9FAFB;
    }

    .btn-logout:active {
        transform: scale(.98);
    }

    .status-success {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #166534;
        border-radius: 12px;
        padding: 11px 13px;
        font-size: 12px;
    }

    .error-text {
        color: #DC2626;
        font-size: 11px;
        margin-top: 5px;
    }

    @media (min-width: 481px) {
        .profile-wrapper {
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.04);
        }
    }
</style>
@endpush

@section('content')

<div class="profile-wrapper px-4 pt-4 pb-6 space-y-5">

    {{-- Header Profil --}}
    <div class="profile-header">

        <div class="flex items-center gap-3">

            <div class="profile-avatar">

                <svg class="w-7 h-7 text-white"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M4.5 20.25a8.25 8.25 0 0115 0" />

                </svg>

            </div>

            <div class="min-w-0">

                <p class="font-bold text-gray-900 text-base truncate">
                    {{ $user->name }}
                </p>

                <p class="text-xs text-gray-500 truncate">
                    {{ $user->email }}
                </p>

                <p class="text-[10px] text-gray-400 mt-0.5">
                    {{ __('guest.profile.resident_profile') }}
                </p>

            </div>

        </div>

    </div>


    {{-- Notifikasi --}}
    @if (session('status') === 'profile-updated')

        <div class="status-success flex items-center gap-2">

            <svg class="w-4 h-4 shrink-0"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24"
                 stroke-width="2">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M5 13l4 4L19 7" />

            </svg>

            <span>
                {{ __('guest.profile.updated') }}
            </span>

        </div>

    @endif


    {{-- Informasi Profil --}}
    <div class="profile-card">

        <div class="section-title flex items-center gap-2">

            <div class="w-7 h-7 rounded-lg bg-red-50 flex items-center justify-center">

                <svg class="w-4 h-4 text-red-600"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M4.5 20.25a8.25 8.25 0 0115 0" />

                </svg>

            </div>

            <span>
                {{ __('guest.profile.info_title') }}
            </span>

        </div>


        <form method="post"
              action="{{ route('guest.profile.update') }}"
              class="space-y-4">

            @csrf
            @method('patch')


            {{-- Nama --}}
            <div>

                <label for="name"
                       class="profile-label">
                    {{ __('guest.profile.name') }}
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $user->name) }}"
                    class="profile-input"
                    placeholder="{{ __('guest.profile.name_placeholder') }}">

                @error('name')
                    <p class="error-text">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Email --}}
            <div>

                <label for="email"
                       class="profile-label">
                    {{ __('guest.profile.email') }}
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $user->email) }}"
                    class="profile-input"
                    placeholder="{{ __('guest.profile.email_placeholder') }}">

                @error('email')
                    <p class="error-text">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Phone --}}
<div>
    <label for="phone" class="profile-label">{{ __('guest.profile.phone') }}</label>
    <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}"
           class="profile-input" placeholder="{{ __('guest.profile.phone_placeholder') }}">
    @error('phone')
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>

{{-- Unit Number (Optional) --}}
<div>
    <label for="apartment_unit_number" class="profile-label">
        {{ __('guest.profile.unit_number') }} <span class="text-gray-400 font-normal">({{ __('Optional') }})</span>
    </label>
    <input id="apartment_unit_number" name="apartment_unit_number" type="text"
           value="{{ old('apartment_unit_number', $user->apartment_unit_number) }}"
           class="profile-input" placeholder="e.g., A-1203">
    @error('apartment_unit_number')
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>

{{-- Status --}}
<div>
    <label for="status" class="profile-label">{{ __('guest.profile.status') }}</label>
    <select id="status" name="status" class="profile-input">
        <option value="penyewa" @selected(old('status', $user->status) === 'penyewa')>Penyewa</option>
        <option value="pemilik" @selected(old('status', $user->status) === 'pemilik')>Pemilik</option>
        <option value="agent" @selected(old('status', $user->status) === 'agent')>Agent</option>
    </select>
    @error('status')
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>

{{-- Daerah --}}
<div>
    <label for="daerah" class="profile-label">{{ __('guest.profile.daerah') }}</label>
    <select id="daerah" name="daerah" class="profile-input">
        <option value="Jakarta" @selected(old('daerah', $user->daerah) === 'Jakarta')>Jakarta</option>
    </select>
    @error('daerah')
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>

{{-- Lokasi Unit --}}
<div>
    <label for="apartment_location_id" class="profile-label">{{ __('guest.profile.location') }}</label>
    <select id="apartment_location_id" name="apartment_location_id" class="profile-input">
        @foreach ($locations as $location)
            <option value="{{ $location->id }}"
                @selected((string) old('apartment_location_id', $user->apartment_location_id) === (string) $location->id)>
                {{ $location->name }}
            </option>
        @endforeach
    </select>
    @error('apartment_location_id')
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>

{{-- Tower --}}
<div>
    <label for="apartment_tower_id" class="profile-label">{{ __('guest.profile.tower') }}</label>
    <select id="apartment_tower_id" name="apartment_tower_id" class="profile-input">
        <option value="">{{ __('Pilih lokasi unit dahulu') }}</option>
    </select>
    @error('apartment_tower_id')
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>


            {{-- Tombol Simpan --}}
            <button type="submit"
                    class="btn-save">

                <span class="flex items-center justify-center gap-2">

                    <svg class="w-4 h-4"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24"
                         stroke-width="1.8">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M5 13l4 4L19 7" />

                    </svg>

                    {{ __('guest.profile.save') }}

                </span>

            </button>

        </form>

    </div>


    {{-- Hapus Akun --}}
    <div class="danger-card">

        <div class="flex items-start gap-3 mb-4">

            <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center shrink-0">

                <svg class="w-5 h-5 text-red-600"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M6 7.5h12M9.75 7.5V5.25h4.5V7.5m-6.75 0v11.25A2.25 2.25 0 009.75 21h4.5a2.25 2.25 0 002.25-2.25V7.5M10.5 11.25v6m3-6v6" />

                </svg>

            </div>

            <div>

                <h3 class="text-sm font-bold text-red-600">
                    {{ __('guest.profile.delete_title') }}
                </h3>

                <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">
                    {{ __('guest.profile.delete_warning') }}
                </p>

            </div>

        </div>


        <form method="post"
              action="{{ route('guest.profile.destroy') }}"
              onsubmit="return confirm('{{ __('guest.profile.confirm_delete') }}');"
              class="space-y-3">

            @csrf
            @method('delete')


            <div>

                <label for="password"
                       class="profile-label">
                    {{ __('guest.profile.confirm_password') }}
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="profile-input"
                    placeholder="{{ __('guest.profile.password_placeholder') }}">

                @error('password', 'userDeletion')
                    <p class="error-text">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            <button type="submit"
                    class="btn-delete">

                <span class="flex items-center justify-center gap-2">

                    <svg class="w-4 h-4"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24"
                         stroke-width="1.8">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M6 7.5h12M9.75 7.5V5.25h4.5V7.5m-6.75 0v11.25A2.25 2.25 0 009.75 21h4.5a2.25 2.25 0 002.25-2.25V7.5M10.5 11.25v6m3-6v6" />

                    </svg>

                    {{ __('guest.profile.delete_button') }}

                </span>

            </button>

        </form>

    </div>


    {{-- Logout --}}
    <form method="post"
          action="{{ route('logout') }}">

        @csrf

        <button type="submit"
                class="btn-logout">

            <span class="flex items-center justify-center gap-2">

                <svg class="w-4 h-4"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M18 12H9m0 0l3-3m-3 3l3 3" />

                </svg>

                {{ __('guest.profile.logout') }}

            </span>

        </button>

    </form>

</div>

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

    $currentTowerId = old(
        'apartment_tower_id',
        $user->apartment_tower_id
    );
@endphp

<script>
    const towersByLocation = @json($towersByLocation);
    const currentTowerId = @json($currentTowerId);

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

        towers.forEach((tower) => {
            const opt = document.createElement('option');

            opt.value = tower.id;
            opt.textContent = tower.name;

            if (String(tower.id) === String(currentTowerId)) {
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
