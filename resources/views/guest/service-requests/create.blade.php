@extends('layouts.guest')

@section('title', __('guest.create.title'))

@section('content')

<div class="ui-page">

    @include('guest.partials.page-hero', [
        'title' => __('guest.create.title'),
        'back'  => route('guest.service-requests.index'),
    ])

    <div class="ui-body">
        <div class="ui-pull ui-stack">

            @if (session('success'))
                <div class="ui-alert ui-alert--success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="ui-alert ui-alert--error">{{ session('error') }}</div>
            @endif

            <div class="ui-card ui-rise">

                <form method="POST"
                      action="{{ route('guest.service-requests.store') }}"
                      enctype="multipart/form-data"
                      class="ui-form">

                    @csrf

                    {{-- Jenis jasa --}}
                    <div>
                        <label for="service_id" class="ui-label">{{ __('guest.create.service_type') }}</label>

                        <select name="service_id" id="service_id" required class="ui-input">
                            <option value="">{{ __('guest.create.choose_service') }}</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                        data-slug="{{ $service->slug }}"
                                        data-price="{{ $service->base_price }}"
                                        @selected(old('service_id') == $service->id)>
                                    {{ $service->name }}
                                    @if ($service->base_price)
                                        - Rp{{ number_format($service->base_price, 0, ',', '.') }}
                                    @else
                                        - {{ __('guest.create.custom_price') }}
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        <x-input-error :messages="$errors->get('service_id')" class="mt-2" />
                    </div>

                    {{-- Jadwal --}}
                    <div>
                        <label for="scheduled_at" class="ui-label">{{ __('guest.form.schedule_optional') }}</label>
                        <input id="scheduled_at" type="datetime-local" name="scheduled_at"
                               value="{{ old('scheduled_at') }}" class="ui-input">
                        <p class="ui-hint">{{ __('guest.form.schedule_hint') }}</p>
                        <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
                    </div>

                    {{-- Catatan --}}
                    <div>
                        <label for="notes" class="ui-label">{{ __('guest.form.notes') }}</label>
                        <textarea name="notes" id="notes" rows="3" class="ui-input"
                                  placeholder="{{ __('guest.form.notes_placeholder') }}">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    {{-- Maintenance & Repair --}}
                    <div id="maintenance-fields" class="hidden">
                        <div class="ui-divider ui-form">

                            <h3 class="ui-heading">{{ __('guest.form.maintenance_details') }}</h3>

                            <div>
                                <label for="damage_category" class="ui-label">
                                    {{ __('guest.form.damage_category') }} <span class="text-red-500">*</span>
                                </label>
                                <select name="damage_category" id="damage_category" class="ui-input">
                                    <option value="">{{ __('guest.create.choose_category') }}</option>
                                    @foreach (['cat_luntur', 'kebocoran', 'listrik', 'ac', 'pintu_jendela', 'furniture', 'lainnya'] as $damageKey)
                                        <option value="{{ $damageKey }}" @selected(old('damage_category') === $damageKey)>
                                            {{ __('guest.damage_categories_long.' . $damageKey) }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('damage_category')" class="mt-2" />
                            </div>

                            <div>
                                <label for="location" class="ui-label">{{ __('guest.form.damage_location') }}</label>
                                <input id="location" name="location" value="{{ old('location') }}" class="ui-input"
                                       placeholder="{{ __('guest.form.damage_location_placeholder') }}">
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <div>
                                <label for="urgency" class="ui-label">{{ __('guest.form.urgency') }}</label>
                                <select name="urgency" id="urgency" class="ui-input">
                                    @foreach (['low', 'medium', 'high'] as $urgencyKey)
                                        <option value="{{ $urgencyKey }}" @selected(old('urgency', 'medium') === $urgencyKey)>
                                            {{ __('guest.urgency.' . $urgencyKey . '.label') }}
                                            ({{ __('guest.urgency.' . $urgencyKey . '.desc') }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('urgency')" class="mt-2" />
                            </div>

                        </div>
                    </div>

                    {{-- Foto --}}
                    <div id="photos-fields" class="hidden">
                        <div class="ui-divider">

                            <h3 class="ui-heading">{{ __('guest.form.photos_title') }}</h3>

                            <div class="ui-upload" style="margin-top:12px">
                                <input type="file" name="photos[]" id="photos" accept="image/*" multiple
                                       class="block w-full text-xs text-gray-500
                                       file:mr-3 file:py-2 file:px-3
                                       file:rounded-lg file:border-0
                                       file:text-xs file:font-semibold
                                       file:bg-red-50 file:text-red-700
                                       hover:file:bg-red-100">
                            </div>

                            <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                            <p class="ui-hint">{{ __('guest.form.photos_hint') }}</p>

                        </div>
                    </div>

                    <button type="submit" class="ui-btn ui-btn--primary" style="margin-top:20px">
                        {{ __('guest.create.submit') }}
                    </button>

                </form>

            </div>

        </div>
    </div>

</div>

<script>
    const serviceSelect = document.getElementById('service_id');
    const maintenanceFields = document.getElementById('maintenance-fields');
    const photosFields = document.getElementById('photos-fields');
    const damageCategory = document.getElementById('damage_category');

    function syncServiceFields() {
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        const isMaintenance = !!selectedOption && selectedOption.dataset.slug === 'maintenance-repair';

        maintenanceFields.classList.toggle('hidden', !isMaintenance);
        photosFields.classList.toggle('hidden', !isMaintenance);

        damageCategory.required = isMaintenance;
    }

    serviceSelect.addEventListener('change', syncServiceFields);

    // Pulihkan tampilan setelah validasi gagal (old input)
    syncServiceFields();
</script>

@endsection
