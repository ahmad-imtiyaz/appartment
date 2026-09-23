@extends('layouts.guest')

@section('title', $service->name)

@section('content')

<div class="ui-page">

    @include('guest.partials.page-hero', [
        'title'       => $service->name,
        'subtitle'    => $service->description ?? __('guest.detail.default_description'),
        'back'        => route('guest.home'),
        'iconKey'     => $service->slug,
        'showBalance' => true,
    ])

    <div class="ui-body">
        <div class="ui-pull ui-stack">

            @if (session('success'))
                <div class="ui-alert ui-alert--success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="ui-alert ui-alert--error">{{ session('error') }}</div>
            @endif


            {{-- ================= LAUNDRY ================= --}}
            @if ($service->slug === 'laundry' && $laundryPricings->isNotEmpty())
                <div class="ui-card ui-rise">

                    <h3 class="ui-heading">{{ __('guest.detail.laundry_title') }}</h3>
                    <p class="ui-sub">{{ __('guest.detail.laundry_subtitle') }}</p>

                    @php
                        $typeConfig = [
                            'cuci'         => ['label' => __('guest.laundry_types.cuci'),         'tone' => 'sky',    'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12h15m-15 6h-1.5m19.5 0h-1.5M5.25 6h13.5M5.25 12h13.5m-13.5 6h13.5"/></svg>'],
                            'cuci_setrika' => ['label' => __('guest.laundry_types.cuci_setrika'), 'tone' => 'indigo', 'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>'],
                            'setrika'      => ['label' => __('guest.laundry_types.setrika'),       'tone' => 'purple', 'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V13.5zm0 2.25h.008v.008H8.25v-.008zm0 2.25h.008v.008H8.25V18zm2.498-6.75h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V13.5zm0 2.25h.007v.008h-.007v-.008zm0 2.25h.007v.008h-.007V18zm2.504-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V18zm2.498-6.75h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V13.5zM8.25 6h7.5v2.25h-7.5V6zM12 3a9 9 0 100 18 9 9 0 000-18z"/></svg>'],
                        ];
                    @endphp

                    <div class="ui-opts ui-opts--3">
                        @foreach (['cuci', 'cuci_setrika', 'setrika'] as $type)
                            @php
                                $cfg = $typeConfig[$type];
                                $checked = old('laundry_type') === $type ? 'checked' : '';
                            @endphp
                            <label class="ui-opt" for="type-{{ $type }}">
                                <input type="radio" name="laundry_type_display" value="{{ $type }}" {{ $checked }}
                                       id="type-{{ $type }}"
                                       class="laundry-type-radio"
                                       data-type="{{ $type }}">
                                <div class="ui-opt-box">
                                    <span class="ui-ico tone-{{ $cfg['tone'] }}">{!! $cfg['icon'] !!}</span>
                                    <span class="ui-opt-name">{{ $cfg['label'] }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="ui-divider">

                        <h3 class="ui-heading">{{ __('guest.detail.duration_title') }}</h3>
                        <p class="ui-sub">{{ __('guest.detail.duration_subtitle') }}</p>

                        @php
                            $durConfig = [
                                'reguler' => ['label' => __('guest.laundry_durations.reguler.label'), 'desc' => __('guest.laundry_durations.reguler.desc'), 'tone' => 'emerald', 'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'],
                                'express' => ['label' => __('guest.laundry_durations.express.label'), 'desc' => __('guest.laundry_durations.express.desc'), 'tone' => 'amber',   'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>'],
                            ];
                        @endphp

                        <div class="ui-opts ui-opts--2">
                            @foreach (['reguler', 'express'] as $duration)
                                @php
                                    $dcfg = $durConfig[$duration];
                                    $checked = old('laundry_duration') === $duration ? 'checked' : '';
                                @endphp
                                <label class="ui-opt" for="duration-{{ $duration }}">
                                    <input type="radio" name="laundry_duration_display" value="{{ $duration }}" {{ $checked }}
                                           id="duration-{{ $duration }}"
                                           class="laundry-duration-radio"
                                           data-duration="{{ $duration }}">
                                    <div class="ui-opt-box ui-opt-box--row">
                                        <span class="ui-ico ui-ico--sm tone-{{ $dcfg['tone'] }}" style="width:36px;height:36px">{!! $dcfg['icon'] !!}</span>
                                        <div>
                                            <p class="ui-opt-name" style="font-size:13px">{{ $dcfg['label'] }}</p>
                                            <p class="ui-opt-desc">{{ $dcfg['desc'] }}</p>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                    </div>

                    {{-- Price box --}}
                    <div id="price-info" class="hidden" style="margin-top:16px">
                        <div class="ui-price">
                            <div>
                                <p class="ui-price-label">{{ __('guest.detail.price_per_kg') }}</p>
                                <p class="ui-price-value" id="selected-price-display">Rp 0</p>
                            </div>
                            <div style="text-align:right">
                                <p class="ui-price-note" id="selected-desc-display">{{ __('guest.detail.choose_type_duration') }}</p>
                                <p class="ui-price-warn">{{ __('guest.detail.price_may_change') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            @endif


            {{-- ================= CLEANING ================= --}}
@if ($service->slug === 'cleaning' && $cleaningPricing)
    <div class="ui-card ui-rise">

        <h3 class="ui-heading">Durasi Pekerjaan</h3>
        <p class="ui-sub">Pilih berapa lama Anda membutuhkan layanan cleaning.</p>

        @php
            $durationOptions = [1, 2, 3, 4];
            $oldDuration = old('cleaning_duration_hours');
            $isCustomDuration = $oldDuration && !in_array((int) $oldDuration, $durationOptions);
        @endphp

        <div class="ui-opts ui-opts--3">
            @foreach ($durationOptions as $hours)
                @php $checked = (string) $oldDuration === (string) $hours ? 'checked' : ''; @endphp
                <label class="ui-opt" for="duration-{{ $hours }}">
                    <input type="radio" name="cleaning_duration_display" value="{{ $hours }}" {{ $checked }}
                           id="duration-{{ $hours }}" class="cleaning-duration-radio">
                    <div class="ui-opt-box">
                        <span class="ui-opt-name">{{ $hours }} jam</span>
                    </div>
                </label>
            @endforeach
            <label class="ui-opt" for="duration-custom">
                <input type="radio" name="cleaning_duration_display" value="custom" {{ $isCustomDuration ? 'checked' : '' }}
                       id="duration-custom" class="cleaning-duration-radio">
                <div class="ui-opt-box">
                    <span class="ui-opt-name">+ Jam Lainnya</span>
                </div>
            </label>
        </div>

        <div id="custom-duration-wrap" class="{{ $isCustomDuration ? '' : 'hidden' }}" style="margin-top:10px">
            <label for="custom-duration-input" class="ui-label">Jumlah jam</label>
            <input type="number" id="custom-duration-input" min="1" max="12" class="ui-input"
                   value="{{ $isCustomDuration ? $oldDuration : '' }}">
        </div>

        <div class="ui-price" style="margin-top:16px">
            <div>
                <p class="ui-price-label">Harga per Jam</p>
                <p class="ui-price-value">Rp {{ number_format($cleaningPricing->price_per_hour, 0, ',', '.') }}</p>
            </div>
            <p class="ui-price-note">Total dihitung otomatis sesuai durasi.</p>
        </div>

        @if ($cleaningAreas->isNotEmpty())
            <div class="ui-divider ui-form">
                <h3 class="ui-heading">Area yang Dibersihkan</h3>
                <p class="ui-sub">Pilih area/ruangan yang akan dibersihkan.</p>

                @php $oldAreas = old('cleaning_area_ids', []); @endphp
                <div class="ui-stack" style="margin-top:8px">
                    @foreach ($cleaningAreas as $area)
                        <label style="display:flex;align-items:center;gap:10px;padding:10px 12px;border:1px solid #E5E7EB;border-radius:10px">
                            <input type="checkbox" name="cleaning_area_ids_display[]" value="{{ $area->id }}"
                                @checked(in_array($area->id, $oldAreas)) class="cleaning-area-checkbox-display">
                            <span style="font-size:13px;color:#111827">{{ $area->name }}</span>
                        </label>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('cleaning_area_ids')" class="mt-2" />
            </div>
        @endif

        @if ($cleaningAddons->isNotEmpty())
            <div class="ui-divider ui-form">
                <h3 class="ui-heading">Pekerjaan Tambahan (Opsional)</h3>
                <p class="ui-sub">Bisa ditambahkan sesuai kebutuhan, harga otomatis masuk ke total.</p>

                @php $oldAddons = old('cleaning_addon_ids', []); @endphp
                <div class="ui-stack" style="margin-top:8px">
                    @foreach ($cleaningAddons as $addon)
                        <label style="display:flex;align-items:center;justify-content:space-between;gap:10px;padding:10px 12px;border:1px solid #E5E7EB;border-radius:10px">
                            <span style="display:flex;align-items:center;gap:10px">
                                <input type="checkbox" name="cleaning_addon_ids_display[]" value="{{ $addon->id }}"
                                    data-price="{{ $addon->price }}"
                                        @checked(in_array($addon->id, $oldAddons)) class="cleaning-addon-checkbox-display">
                                <span style="font-size:13px;color:#111827">{{ $addon->name }}</span>
                            </span>
                            <span style="font-size:13px;color:#6B7280">Rp {{ number_format($addon->price, 0, ',', '.') }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <div id="cleaning-total-info" class="hidden" style="margin-top:16px">
            <div class="ui-price">
                <div>
                    <p class="ui-price-label">Estimasi Total</p>
                    <p class="ui-price-note" id="cleaning-total-breakdown">-</p>
                </div>
                <p class="ui-price-value" id="cleaning-total-value">Rp 0</p>
            </div>
        </div>

    </div>
@endif


            {{-- ================= AC ================= --}}
            @if ($service->slug === 'ac' && $acPricings->isNotEmpty())
                <div class="ui-card ui-rise">

                    <h3 class="ui-heading">{{ __('guest.detail.ac_title') }}</h3>
                    <p class="ui-sub">{{ __('guest.detail.ac_subtitle') }}</p>

                    @php
                        $acIconConfig = [
                            'ac-cleaning' => [
                                'tone' => 'cyan',
                                'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M4.2 7.5l15.6 9M4.2 16.5l15.6-9M9.5 4.5L12 6.5l2.5-2M9.5 19.5l2.5-2 2.5 2"/></svg>',
                            ],
                            'ac-refill' => [
                                'tone' => 'sky',
                                'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v20M2 12h20" /></svg>',
                            ],
                            'ac-repair' => [
                                'tone' => 'blue',
                                'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877" /></svg>',
                            ],
                        ];
                        $preselectedAc = old('ac_type') ?: request('type');
                    @endphp

                    <div class="ui-opts ui-opts--3">
                        @foreach ($acPricings as $pricing)
                            @php
                                $cfg = $acIconConfig[$pricing->type] ?? ['icon' => '', 'tone' => 'red'];
                                $checked = $preselectedAc === $pricing->type ? 'checked' : '';
                            @endphp
                            <label class="ui-opt" for="ac-{{ $pricing->type }}">
                                <input type="radio" name="ac_type_display" value="{{ $pricing->type }}"
                                       data-price="{{ $pricing->price }}"
                                       data-label="{{ $pricing->typeLabel() }}"
                                       {{ $checked }} id="ac-{{ $pricing->type }}"
                                       class="ac-type-radio">
                                <div class="ui-opt-box">
                                    <span class="ui-ico tone-{{ $cfg['tone'] }}">{!! $cfg['icon'] !!}</span>
                                    <span class="ui-opt-name">{{ $pricing->typeLabel() }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div id="ac-price-info" class="hidden" style="margin-top:16px">
                        <div class="ui-price">
                            <div>
                                <p class="ui-price-label">{{ __('guest.detail.selected_service') }}</p>
                                <p class="ui-price-name" id="selected-ac-label">-</p>
                            </div>
                            <p class="ui-price-value" id="selected-ac-price">Rp 0</p>
                        </div>
                    </div>

                </div>
            @endif


            {{-- ================= FORM PESANAN ================= --}}
            <div class="ui-card ui-rise">

                <h3 class="ui-heading" style="margin-bottom:14px">{{ __('guest.detail.make_order') }}</h3>

                <form method="POST"
                      action="{{ route('guest.service-requests.store') }}"
                      enctype="multipart/form-data"
                      class="ui-form">

                    @csrf

                    @if ($errors->any())
                        <div class="ui-alert ui-alert--error">
                            <p style="font-weight:700">{{ __('guest.common.fix_errors') }}</p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                    {{-- Laundry hidden fields --}}
                    @if ($service->slug === 'laundry')
                        <input type="hidden" name="laundry_type" id="form-laundry-type" value="{{ old('laundry_type') }}">
                        <input type="hidden" name="laundry_duration" id="form-laundry-duration" value="{{ old('laundry_duration') }}">
                        <input type="hidden" name="snapshot_price_per_kg" id="form-price-per-kg" value="{{ old('snapshot_price_per_kg') }}">
                    @endif

                    {{-- Cleaning hidden fields --}}
                    @if ($service->slug === 'cleaning')
                        <input type="hidden" name="cleaning_duration_hours" id="form-cleaning-duration" value="{{ old('cleaning_duration_hours') }}">
                        <div id="cleaning-area-hidden-wrap"></div>
                        <div id="cleaning-addon-hidden-wrap"></div>
                    @endif

                    {{-- AC hidden fields --}}
                    @if ($service->slug === 'ac')
                        <input type="hidden" name="ac_type" id="form-ac-type" value="{{ old('ac_type') }}">
                        <input type="hidden" name="snapshot_ac_price" id="form-ac-price" value="{{ old('snapshot_ac_price') }}">
                    @endif

                    <div>
                        <label for="scheduled_at" class="ui-label">{{ __('guest.form.schedule_optional') }}</label>
                        <input id="scheduled_at" type="datetime-local" name="scheduled_at"
                               value="{{ old('scheduled_at') }}" class="ui-input">
                        <p class="ui-hint">{{ __('guest.form.schedule_hint') }}</p>
                    </div>

                    <div>
                        <label for="notes" class="ui-label">{{ __('guest.form.notes') }}</label>
                        <textarea name="notes" id="notes" rows="2" class="ui-input"
                                  placeholder="{{ __('guest.form.notes_placeholder') }}">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    {{-- Lokasi — wajib untuk semua jasa --}}
                    <div class="ui-divider ui-form">
                        <h3 class="ui-heading">{{ __('guest.form.location_title') }}</h3>

                        <div>
                            <label for="daerah" class="ui-label">{{ __('guest.form.daerah') }} <span class="text-red-500">*</span></label>
                            <select name="daerah" id="daerah" required class="ui-input">
                                <option value="" disabled {{ old('daerah', auth()->user()->daerah) ? '' : 'selected' }}>
                                    {{ __('guest.form.choose_daerah') }}
                                </option>
                                <option value="Jakarta" @selected(old('daerah', auth()->user()->daerah) === 'Jakarta')>
                                    Jakarta
                                </option>
                            </select>
                            <p class="ui-hint">{{ __('guest.form.daerah_hint') }}</p>
                            <x-input-error :messages="$errors->get('daerah')" class="mt-2" />
                        </div>

                        <div>
                            <label for="apartment_location_id" class="ui-label">{{ __('guest.form.apartment_location') }} <span class="text-red-500">*</span></label>
                            <select name="apartment_location_id" id="apartment_location_id" required class="ui-input">
                                <option value="" disabled {{ old('apartment_location_id', auth()->user()->apartment_location_id) ? '' : 'selected' }}>
                                    {{ __('guest.form.choose_location') }}
                                </option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        @selected((string) old('apartment_location_id', auth()->user()->apartment_location_id) === (string) $location->id)>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('apartment_location_id')" class="mt-2" />
                        </div>

                        <div>
                            <label for="apartment_tower_id" class="ui-label">{{ __('guest.form.apartment_tower') }} <span class="text-red-500">*</span></label>
                            <select name="apartment_tower_id" id="apartment_tower_id" required class="ui-input">
                                <option value="">{{ __('guest.form.choose_location_first') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('apartment_tower_id')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Maintenance & Repair --}}
                    @if ($service->slug === 'maintenance-repair')

                        <div class="ui-divider ui-form">

                            <h3 class="ui-heading">{{ __('guest.form.maintenance_details') }}</h3>

                            <input type="hidden" name="damage_category" id="form-damage-category" value="{{ old('damage_category') }}">

                            <div>
                                <span class="ui-label">{{ __('guest.form.damage_category') }} <span class="text-red-500">*</span></span>

                                @php
                                    $categoryIconConfig = [
                                        'cat_luntur'    => ['icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6l1.2 4.5H7.8L9 3zM6.5 7.5h11l-1 5.2a5 5 0 01-9 0l-1-5.2zM10 15v5m4-5v5"/></svg>', 'tone' => 'orange'],
                                        'kebocoran'     => ['icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3s6 6.7 6 11a6 6 0 01-12 0c0-4.3 6-11 6-11z"/></svg>', 'tone' => 'blue'],
                                        'listrik'       => ['icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 3L4 14h7v7l9-11h-7z"/></svg>', 'tone' => 'amber'],
                                        'ac'            => ['icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><rect x="3" y="6" width="18" height="7" rx="2"/><path stroke-linecap="round" d="M7 13v2M11 13v2.5M15 13v2M18 13v1.5"/></svg>', 'tone' => 'cyan'],
                                        'pintu_jendela' => ['icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><rect x="5" y="3" width="14" height="18" rx="1"/><circle cx="15" cy="12" r="0.8" fill="currentColor" stroke="none"/></svg>', 'tone' => 'indigo'],
                                        'furniture'     => ['icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v16M20 4v16M4 4h16"/></svg>', 'tone' => 'purple'],
                                        'lainnya'       => ['icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 16h.01M12 8a2 2 0 011.5 3.3c-.5.5-1.5 1-1.5 2"/></svg>', 'tone' => 'sky'],
                                    ];
                                    $categoryKeys = array_keys(\App\Models\RepairPricing::CATEGORIES + ['lainnya' => 'Lainnya']);
                                    $selectedCategory = old('damage_category');
                                @endphp

                                <div class="ui-opts ui-opts--3" style="margin-top:8px">
                                    @foreach ($categoryKeys as $value)
                                        @php
                                            $cfg = $categoryIconConfig[$value] ?? $categoryIconConfig['lainnya'];
                                            $checked = $selectedCategory === $value ? 'checked' : '';
                                        @endphp
                                        <label class="ui-opt" for="damage-category-{{ $value }}">
                                            <input type="radio" name="damage_category_display" value="{{ $value }}" {{ $checked }}
                                                   id="damage-category-{{ $value }}" class="damage-category-radio">
                                            <div class="ui-opt-box">
                                                <span class="ui-ico tone-{{ $cfg['tone'] }}">{!! $cfg['icon'] !!}</span>
                                                <span class="ui-opt-name" style="font-size:11px">{{ __('guest.damage_categories.' . $value) }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <x-input-error :messages="$errors->get('damage_category')" class="mt-2" />
                            </div>

                            <div>
                                <label for="location" class="ui-label">{{ __('guest.form.damage_location') }}</label>
                                <input id="location" name="location" value="{{ old('location') }}" class="ui-input"
                                       placeholder="{{ __('guest.form.damage_location_placeholder') }}">
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <input type="hidden" name="urgency" id="form-urgency" value="{{ old('urgency', 'medium') }}">

                            <div>
                                <span class="ui-label">{{ __('guest.form.urgency') }}</span>

                                @php
                                    $urgencyConfig = [
                                        'low'    => ['tone' => 'emerald', 'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 7v5l3 2"/></svg>'],
                                        'medium' => ['tone' => 'amber',   'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 3h.01M10.3 4.4L2.5 18a1 1 0 00.9 1.5h17.2a1 1 0 00.9-1.5L13.7 4.4a1 1 0 00-1.4 0z"/></svg>'],
                                        'high'   => ['tone' => 'red',     'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>'],
                                    ];
                                    $selectedUrgency = old('urgency', 'medium');
                                @endphp

                                <div class="ui-opts ui-opts--3" style="margin-top:8px">
                                    @foreach ($urgencyConfig as $value => $cfg)
                                        @php $checked = $selectedUrgency === $value ? 'checked' : ''; @endphp
                                        <label class="ui-opt" for="urgency-{{ $value }}">
                                            <input type="radio" name="urgency_display" value="{{ $value }}" {{ $checked }}
                                                   id="urgency-{{ $value }}" class="urgency-radio">
                                            <div class="ui-opt-box">
                                                <span class="ui-ico tone-{{ $cfg['tone'] }}">{!! $cfg['icon'] !!}</span>
                                                <div>
                                                    <p class="ui-opt-name">{{ __('guest.urgency.' . $value . '.label') }}</p>
                                                    <p class="ui-opt-desc">{{ __('guest.urgency.' . $value . '.desc') }}</p>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <x-input-error :messages="$errors->get('urgency')" class="mt-2" />
                            </div>

                            <div>
                                <span class="ui-label">{{ __('guest.form.photos_title') }}</span>
                                <div class="ui-upload">
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

                    @endif

                    @if ($service->slug === 'laundry')
                        <div class="ui-alert ui-alert--warn">
                            {{ __('guest.detail.final_price_note') }}
                        </div>
                    @endif

                    <button type="submit" class="ui-btn ui-btn--primary" style="margin-top:20px">
                        {{ __('guest.detail.submit_order') }}
                    </button>

                </form>

            </div>


            {{-- ================= DAFTAR PESANAN ================= --}}
            <div class="ui-card ui-rise">

                <div class="ui-sec-head">
                    <h3 class="ui-heading">{{ __('guest.detail.order_list') }}</h3>
                    <span class="ui-count">{{ __('guest.common.orders_count', ['count' => $requests->count()]) }}</span>
                </div>

                @if ($requests->isEmpty())

                    <div class="ui-empty">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        {{ __('guest.detail.no_orders', ['service' => $service->name]) }}
                    </div>

                @else

                    <div class="ui-stack">
                        @foreach ($requests as $request)

                            <div class="ui-row" style="background:#F9FAFB;box-shadow:none">

                                <div class="ui-row-main">

                                    <div class="min-w-0 flex-1">

                                        <p class="ui-row-meta" style="margin-top:0">
                                            {{ __('guest.detail.order_number', ['number' => str_pad($request->id, 7, '0', STR_PAD_LEFT)]) }}
                                        </p>

                                        <p class="ui-row-title">{{ $request->service->name }}</p>

                                        @if ($request->laundry_type)
                                            <p class="ui-row-meta">
                                                {{ $request->laundry_type }} / {{ $request->laundry_duration }}
                                                @if ($request->billable_weight)
                                                    — {{ $request->billable_weight }} kg, Rp{{ number_format($request->total_price ?? 0, 0, ',', '.') }}
                                                @endif
                                            </p>
                                        @endif

                                        <span class="ui-pill ui-pill--{{ $request->status }}" style="margin-top:6px">
                                            {{ __('guest.status.' . $request->status) }}
                                        </span>

                                    </div>

                                    @if (in_array($request->status, ['pending', 'assigned']))
                                        <form action="{{ route('guest.service-requests.destroy', $request) }}" method="POST" class="shrink-0"
                                              onsubmit="return confirm('{{ __('guest.detail.confirm_cancel', ['id' => $request->id]) }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="ui-btn ui-btn--soft ui-btn--sm">
                                                {{ __('guest.detail.cancel') }}
                                            </button>
                                        </form>
                                    @endif

                                </div>

                            </div>

                        @endforeach
                    </div>

                @endif

            </div>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    const typeRadios = document.querySelectorAll('.laundry-type-radio');
    const durationRadios = document.querySelectorAll('.laundry-duration-radio');
    const priceInfo = document.getElementById('price-info');
    const priceDisplay = document.getElementById('selected-price-display');
    const descDisplay = document.getElementById('selected-desc-display');
    const formType = document.getElementById('form-laundry-type');
    const formDuration = document.getElementById('form-laundry-duration');
    const formPrice = document.getElementById('form-price-per-kg');

    const pricingData = @json($laundryPricings);

    const typeLabels = {
        cuci: @json(__('guest.laundry_types.cuci')),
        cuci_setrika: @json(__('guest.laundry_types.cuci_setrika')),
        setrika: @json(__('guest.laundry_types.setrika'))
    };

    const durLabels = {
        reguler: @json(__('guest.laundry_durations.reguler.label') . ' (' . __('guest.laundry_durations.reguler.desc') . ')'),
        express: @json(__('guest.laundry_durations.express.label') . ' (' . __('guest.laundry_durations.express.desc') . ')')
    };

    function updatePrice() {
        if (!priceInfo || !formType || !formDuration || !formPrice) return;
        const type = document.querySelector('input[name="laundry_type_display"]:checked')?.value;
        const duration = document.querySelector('input[name="laundry_duration_display"]:checked')?.value;

        if (!type || !duration) {
            priceInfo.classList.add('hidden');
            formType.value = '';
            formDuration.value = '';
            formPrice.value = '';
            return;
        }

        const match = pricingData.find(
            p => p.type === type && p.duration === duration
        );

        if (match) {
            priceInfo.classList.remove('hidden');
            priceDisplay.textContent =
                'Rp ' + Number(match.price_per_kg).toLocaleString('id-ID');

            descDisplay.textContent =
                typeLabels[type] + ' • ' + durLabels[duration];

            formType.value = type;
            formDuration.value = duration;
            formPrice.value = match.price_per_kg;
        } else {
            priceInfo.classList.add('hidden');
            formType.value = '';
            formDuration.value = '';
            formPrice.value = '';
        }
    }

    typeRadios.forEach(r => {
        r.addEventListener('change', updatePrice);
    });

    durationRadios.forEach(r => {
        r.addEventListener('change', updatePrice);
    });

    // Initialize laundry saat halaman dibuka
    updatePrice();


  // ==============================
// Cleaning selection
// ==============================
const cleaningDurationRadios = document.querySelectorAll('.cleaning-duration-radio');
const customDurationWrap = document.getElementById('custom-duration-wrap');
const customDurationInput = document.getElementById('custom-duration-input');
const formCleaningDuration = document.getElementById('form-cleaning-duration');
const cleaningAreaCheckboxes = document.querySelectorAll('.cleaning-area-checkbox-display');
const cleaningAddonCheckboxes = document.querySelectorAll('.cleaning-addon-checkbox-display');
const cleaningAreaHiddenWrap = document.getElementById('cleaning-area-hidden-wrap');
const cleaningAddonHiddenWrap = document.getElementById('cleaning-addon-hidden-wrap');
const cleaningTotalInfo = document.getElementById('cleaning-total-info');
const cleaningTotalValue = document.getElementById('cleaning-total-value');
const cleaningTotalBreakdown = document.getElementById('cleaning-total-breakdown');

const cleaningPricePerHour = @json($cleaningPricing->price_per_hour ?? 0);

function getSelectedDurationHours() {
    const checked = document.querySelector('input[name="cleaning_duration_display"]:checked');
    if (!checked) return null;
    if (checked.value === 'custom') {
        const val = parseInt(customDurationInput?.value, 10);
        return val > 0 ? val : null;
    }
    return parseInt(checked.value, 10);
}

function syncHiddenCheckboxes(sourceCheckboxes, wrapEl, fieldName) {
    if (!wrapEl) return;
    wrapEl.innerHTML = '';
    sourceCheckboxes.forEach(cb => {
        if (cb.checked) {
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = fieldName;
            hidden.value = cb.value;
            wrapEl.appendChild(hidden);
        }
    });
}

function updateCleaningTotal() {
    if (!formCleaningDuration) return;

    const hours = getSelectedDurationHours();
    formCleaningDuration.value = hours ?? '';

    if (customDurationWrap) {
        const isCustom = document.querySelector('input[name="cleaning_duration_display"]:checked')?.value === 'custom';
        customDurationWrap.classList.toggle('hidden', !isCustom);
    }

    syncHiddenCheckboxes(cleaningAreaCheckboxes, cleaningAreaHiddenWrap, 'cleaning_area_ids[]');
    syncHiddenCheckboxes(cleaningAddonCheckboxes, cleaningAddonHiddenWrap, 'cleaning_addon_ids[]');

    if (!hours) {
        if (cleaningTotalInfo) cleaningTotalInfo.classList.add('hidden');
        return;
    }

    let addonTotal = 0;
    let addonCount = 0;
    cleaningAddonCheckboxes.forEach(cb => {
        if (cb.checked) {
            addonTotal += Number(cb.dataset.price);
            addonCount++;
        }
    });

    const total = (hours * cleaningPricePerHour) + addonTotal;

    if (cleaningTotalInfo && cleaningTotalValue) {
        cleaningTotalInfo.classList.remove('hidden');
        cleaningTotalValue.textContent = 'Rp ' + Number(total).toLocaleString('id-ID');
        if (cleaningTotalBreakdown) {
            cleaningTotalBreakdown.textContent = hours + ' jam × Rp' + Number(cleaningPricePerHour).toLocaleString('id-ID')
                + (addonCount > 0 ? ' + ' + addonCount + ' tambahan' : '');
        }
    }
}

cleaningDurationRadios.forEach(r => r.addEventListener('change', updateCleaningTotal));
if (customDurationInput) customDurationInput.addEventListener('input', updateCleaningTotal);
cleaningAreaCheckboxes.forEach(cb => cb.addEventListener('change', updateCleaningTotal));
cleaningAddonCheckboxes.forEach(cb => cb.addEventListener('change', updateCleaningTotal));

updateCleaningTotal();

    // ==============================
    // AC selection
    // ==============================

    const acRadios = document.querySelectorAll('.ac-type-radio');
    const formAcType = document.getElementById('form-ac-type');
    const formAcPrice = document.getElementById('form-ac-price');

    const acPriceInfo = document.getElementById('ac-price-info');
    const acLabelDisplay = document.getElementById('selected-ac-label');
    const acPriceDisplay = document.getElementById('selected-ac-price');

    function updateAcSelection() {
        const checked = document.querySelector('input[name="ac_type_display"]:checked');

        if (checked && formAcType && formAcPrice) {
            formAcType.value = checked.value;
            formAcPrice.value = checked.dataset.price;

            if (acPriceInfo && acLabelDisplay && acPriceDisplay) {
                acPriceInfo.classList.remove('hidden');
                acLabelDisplay.textContent = checked.dataset.label;
                acPriceDisplay.textContent = 'Rp ' + Number(checked.dataset.price).toLocaleString('id-ID');
            }
        } else {
            if (acPriceInfo) acPriceInfo.classList.add('hidden');
            if (formAcType) formAcType.value = '';
            if (formAcPrice) formAcPrice.value = '';
        }
    }

    acRadios.forEach(r => {
        r.addEventListener('change', updateAcSelection);
    });

    updateAcSelection();
    // ==============================
    // Maintenance & Repair selection
    // ==============================

    const damageCategoryRadios = document.querySelectorAll('.damage-category-radio');
    const formDamageCategory = document.getElementById('form-damage-category');
    damageCategoryRadios.forEach(r => {
        r.addEventListener('change', () => {
            if (formDamageCategory) formDamageCategory.value = r.value;
        });
    });

    const urgencyRadios = document.querySelectorAll('.urgency-radio');
    const formUrgency = document.getElementById('form-urgency');
    urgencyRadios.forEach(r => {
        r.addEventListener('change', () => {
            if (formUrgency) formUrgency.value = r.value;
        });
    });
    // ==============================
    // Lokasi: cascading Daerah → Lokasi Unit → Tower
    // ==============================
    const towersByLocation = @json($locations->mapWithKeys(fn ($loc) => [
        $loc->id => $loc->towers->map(fn ($t) => ['id' => $t->id, 'name' => $t->name]),
    ]));
    const oldTowerId = @json(old('apartment_tower_id', auth()->user()->apartment_tower_id));

    const locationSelect = document.getElementById('apartment_location_id');
    const towerSelect = document.getElementById('apartment_tower_id');

    function renderTowers(locationId) {
        towerSelect.innerHTML = '';
        const towers = towersByLocation[locationId] ?? [];

        if (towers.length === 0) {
            towerSelect.innerHTML = '<option value="">{{ __('guest.form.choose_location_first') }}</option>';
            return;
        }

        towerSelect.innerHTML = '<option value="" disabled selected>{{ __('guest.form.choose_tower') }}</option>';

        towers.forEach((tower) => {
            const opt = document.createElement('option');
            opt.value = tower.id;
            opt.textContent = tower.name;
            if (String(tower.id) === String(oldTowerId)) opt.selected = true;
            towerSelect.appendChild(opt);
        });
    }

    if (locationSelect && towerSelect) {
        locationSelect.addEventListener('change', (e) => renderTowers(e.target.value));
        if (locationSelect.value) renderTowers(locationSelect.value);
    }
</script>
@endpush
