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
            @if ($service->slug === 'cleaning' && $cleaningPricings->isNotEmpty())
                <div class="ui-card ui-rise">

                    <h3 class="ui-heading">{{ __('guest.detail.cleaning_title') }}</h3>
                    <p class="ui-sub">{{ __('guest.detail.cleaning_subtitle') }}</p>

                    @php
                        $cleaningIconConfig = [
                            'cleaning-regular' => [
                                'tone' => 'purple',
                                'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5m4.75-11.396a24.301 24.301 0 014.5 0M14.25 3.104v5.714c0 .597.237 1.17.659 1.591L19.8 15.3m0 0a48.11 48.11 0 00-14.8 0M19.8 15.3l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" /></svg>',
                            ],
                            'cleaning-deep' => [
                                'tone' => 'indigo',
                                'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" /></svg>',
                            ],
                            'cleaning-postmove' => [
                                'tone' => 'orange',
                                'icon' => '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>',
                            ],
                        ];
                        $preselected = old('cleaning_type') ?: request('type');
                    @endphp

                    <div class="ui-opts ui-opts--3">
                        @foreach ($cleaningPricings as $pricing)
                            @php
                                $cfg = $cleaningIconConfig[$pricing->type] ?? ['icon' => '', 'tone' => 'red'];
                                $checked = $preselected === $pricing->type ? 'checked' : '';
                            @endphp
                            <label class="ui-opt" for="cleaning-{{ $pricing->type }}">
                                <input type="radio" name="cleaning_type_display" value="{{ $pricing->type }}"
                                       data-price="{{ $pricing->price }}"
                                       data-label="{{ $pricing->typeLabel() }}"
                                       {{ $checked }} id="cleaning-{{ $pricing->type }}"
                                       class="cleaning-type-radio">
                                <div class="ui-opt-box">
                                    <span class="ui-ico tone-{{ $cfg['tone'] }}">{!! $cfg['icon'] !!}</span>
                                    <span class="ui-opt-name">{{ $pricing->typeLabel() }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div id="cleaning-price-info" class="hidden" style="margin-top:16px">
                        <div class="ui-price">
                            <div>
                                <p class="ui-price-label">{{ __('guest.detail.selected_service') }}</p>
                                <p class="ui-price-name" id="selected-cleaning-label">-</p>
                            </div>
                            <p class="ui-price-value" id="selected-cleaning-price">Rp 0</p>
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
                        <input type="hidden" name="cleaning_type" id="form-cleaning-type" value="{{ old('cleaning_type') }}">
                        <input type="hidden" name="snapshot_cleaning_price" id="form-cleaning-price" value="{{ old('snapshot_cleaning_price') }}">
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

    const cleaningRadios = document.querySelectorAll('.cleaning-type-radio');
    const formCleaningType = document.getElementById('form-cleaning-type');
    const formCleaningPrice = document.getElementById('form-cleaning-price');

    const cleaningPriceInfo = document.getElementById('cleaning-price-info');
    const cleaningLabelDisplay = document.getElementById('selected-cleaning-label');
    const cleaningPriceDisplay = document.getElementById('selected-cleaning-price');

    function updateCleaningSelection() {
        const checked = document.querySelector(
            'input[name="cleaning_type_display"]:checked'
        );

        if (
            checked &&
            formCleaningType &&
            formCleaningPrice
        ) {
            formCleaningType.value = checked.value;
            formCleaningPrice.value = checked.dataset.price;

            if (
                cleaningPriceInfo &&
                cleaningLabelDisplay &&
                cleaningPriceDisplay
            ) {
                cleaningPriceInfo.classList.remove('hidden');

                cleaningLabelDisplay.textContent =
                    checked.dataset.label;

                cleaningPriceDisplay.textContent =
                    'Rp ' + Number(checked.dataset.price).toLocaleString('id-ID');
            }
        } else {
            if (cleaningPriceInfo) {
                cleaningPriceInfo.classList.add('hidden');
            }

            if (formCleaningType) {
                formCleaningType.value = '';
            }

            if (formCleaningPrice) {
                formCleaningPrice.value = '';
            }
        }
    }

    cleaningRadios.forEach(r => {
        r.addEventListener('change', updateCleaningSelection);
    });

    // Initialize cleaning saat halaman dibuka
    // termasuk ketika menggunakan old() atau ?type=
    updateCleaningSelection();

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
</script>
@endpush
