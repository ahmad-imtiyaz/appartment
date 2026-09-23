
@extends('layouts.guest')

@section('title', __('guest.show.title'))

@section('content')

<div class="ui-page">

    @include('guest.partials.page-hero', [
        'title'    => __('guest.show.title'),
        'subtitle' => __('guest.detail.order_number', [
            'number' => str_pad($serviceRequest->id, 7, '0', STR_PAD_LEFT)
        ]),
        'back'     => route('guest.service-requests.index'),
        'iconKey'  => $serviceRequest->service->slug,
    ])

    <div class="ui-body">
        <div class="ui-pull ui-stack">

            {{-- Success message --}}
            @if (session('success'))
                <div class="ui-alert ui-alert--success">
                    {{ session('success') }}
                </div>
            @endif


            {{-- Ringkasan --}}
            <div class="ui-card ui-rise">

                <div class="ui-sec-head" style="margin-bottom:6px">
                    <h3 class="ui-heading">
                        {{ $serviceRequest->service->name }}
                    </h3>

                    <span class="ui-pill ui-pill--{{ $serviceRequest->status }}">
                        {{ __('guest.status.' . $serviceRequest->status) }}
                    </span>
                </div>

                <dl>

                    {{-- Tanggal pengajuan --}}
                    <div class="ui-kv-item">
                        <dt>{{ __('guest.show.submitted') }}</dt>
                        <dd>
                            {{ $serviceRequest->created_at->translatedFormat('d M Y H:i') }}
                        </dd>
                    </div>

                    {{-- Jadwal --}}
                    @if ($serviceRequest->scheduled_at)
                        <div class="ui-kv-item">
                            <dt>{{ __('guest.show.scheduled') }}</dt>
                            <dd>
                                {{ $serviceRequest->scheduled_at->translatedFormat('d M Y H:i') }}
                            </dd>
                        </div>
                    @endif

                    {{-- Ditugaskan --}}
                    @if ($serviceRequest->assigned_at)
                        <div class="ui-kv-item">
                            <dt>{{ __('guest.show.assigned') }}</dt>
                            <dd>
                                {{ $serviceRequest->assigned_at->translatedFormat('d M Y H:i') }}
                            </dd>
                        </div>
                    @endif

                    {{-- Pekerja --}}
                    @if ($serviceRequest->worker)
                        <div class="ui-kv-item">
                            <dt>{{ __('guest.show.worker') }}</dt>
                            <dd>
                                {{ $serviceRequest->worker->name }}
                                ({{ $serviceRequest->worker->phone }})
                            </dd>
                        </div>
                    @endif

                    {{-- Diterima pekerja --}}
                    @if ($serviceRequest->accepted_at)
                        <div class="ui-kv-item">
                            <dt>{{ __('guest.show.accepted_by_worker') }}</dt>
                            <dd>
                                {{ $serviceRequest->accepted_at->translatedFormat('d M Y H:i') }}
                            </dd>
                        </div>
                    @endif

                    {{-- Selesai --}}
                    @if ($serviceRequest->completed_at)
                        <div class="ui-kv-item">
                            <dt>{{ __('guest.show.completed') }}</dt>
                            <dd>
                                {{ $serviceRequest->completed_at->translatedFormat('d M Y H:i') }}
                            </dd>
                        </div>
                    @endif

                    {{-- Harga --}}
                    @if ($serviceRequest->total_price)
                        <div class="ui-kv-item">
                            <dt>{{ __('guest.show.cost') }}</dt>
                            <dd class="is-price">
                                Rp{{ number_format($serviceRequest->total_price, 0, ',', '.') }}
                            </dd>
                        </div>
                    @endif

                    {{-- Berat laundry --}}
                    @if ($serviceRequest->isLaundry() && $serviceRequest->billable_weight !== null)
                        <div class="ui-kv-item">
                            <dt>{{ __('guest.show.weight') }}</dt>
                            <dd>
                                {{ $serviceRequest->billableWeightLabel() }}
                            </dd>
                        </div>
                    @endif

                </dl>

                {{-- Catatan guest --}}
                @if ($serviceRequest->notes)
                    <div class="ui-note">
                        <span class="ui-note-title">
                            {{ __('guest.show.your_notes') }}
                        </span>

                        {{ $serviceRequest->notes }}
                    </div>
                @endif

                {{-- Catatan pekerja --}}
                @if ($serviceRequest->worker_notes)
                    <div class="ui-note ui-note--info">
                        <span class="ui-note-title">
                            {{ __('guest.show.worker_notes') }}
                        </span>

                        {{ $serviceRequest->worker_notes }}
                    </div>
                @endif

            </div>

            {{-- Status masih menunggu diproses admin --}}
            @if ($serviceRequest->status === 'pending')
                <div class="ui-alert" style="background:#FFFBEB;color:#92400E">
                    {{ __('guest.show.pending_note') }}
                </div>
            @endif

            {{-- Status sedang diproses --}}
            @if ($serviceRequest->status === 'in_progress')
                <div class="ui-alert" style="background:#EFF6FF;color:#1E40AF">
                    {{ __('guest.show.in_progress_note') }}
                </div>
            @endif


            {{-- Detail maintenance --}}
            @if ($serviceRequest->maintenanceDetail)
                <div class="ui-card ui-rise">

                    <h3 class="ui-heading" style="margin-bottom:6px">
                        {{ __('guest.form.maintenance_details') }}
                    </h3>

                    <dl>

                        <div class="ui-kv-item">
                            <dt>
                                {{ __('guest.form.damage_category') }}
                            </dt>

                            <dd>
                                {{
                                    __('guest.damage_categories.' .
                                    $serviceRequest->maintenanceDetail->damage_category)
                                }}
                            </dd>
                        </div>

                        @if ($serviceRequest->maintenanceDetail->location)
                            <div class="ui-kv-item">
                                <dt>{{ __('guest.show.location') }}</dt>

                                <dd>
                                    {{ $serviceRequest->maintenanceDetail->location }}
                                </dd>
                            </div>
                        @endif

                        <div class="ui-kv-item">

                            <dt>
                                {{ __('guest.show.urgency') }}
                            </dt>

                            <dd>
                                <span class="ui-pill
                                    @if($serviceRequest->maintenanceDetail->urgency === 'high')
                                        ui-pill--rejected
                                    @elseif($serviceRequest->maintenanceDetail->urgency === 'medium')
                                        ui-pill--pending
                                    @else
                                        ui-pill--completed
                                    @endif">

                                    {{
                                        __('guest.urgency.' .
                                        $serviceRequest->maintenanceDetail->urgency .
                                        '.label')
                                    }}

                                </span>
                            </dd>

                        </div>

                    </dl>

                </div>
            @endif


            {{-- Persetujuan harga --}}
            @if ($serviceRequest->status === 'waiting_approval')

                <div class="ui-card ui-rise">

                    <h3 class="ui-heading" style="margin-bottom:12px">
                        {{ __('guest.show.price_approval') }}
                    </h3>

                    @if (session('error'))
                        <div class="ui-alert ui-alert--error" style="margin-bottom:12px">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="ui-price" style="display:block">

                        <p class="ui-price-note"
                           style="color:#6B7280;font-size:12px">
                            {{ __('guest.show.survey_done') }}
                        </p>

                        <p class="ui-price-value"
                           style="font-size:26px;margin-top:6px">

                            Rp{{ number_format($serviceRequest->total_price, 0, ',', '.') }}

                        </p>

                        <p class="ui-price-note" style="margin-top:6px">

                            {{
                                __('guest.show.current_balance', [
                                    'amount' =>
                                        'Rp' .
                                        number_format(
                                            auth()->user()->balance,
                                            0,
                                            ',',
                                            '.'
                                        )
                                ])
                            }}

                        </p>

                    </div>

                    <div style="display:flex;gap:10px;margin-top:14px">

                        {{-- Setujui & bayar --}}
                        <form method="POST"
                              action="{{ route('guest.service-requests.approve-price', $serviceRequest) }}"
                              style="flex:1">

                            @csrf

                            <button type="submit"
                                    class="ui-btn ui-btn--primary">

                                {{ __('guest.show.approve_pay') }}

                            </button>

                        </form>

                        {{-- Tolak --}}
                        <form method="POST"
                              action="{{ route('guest.service-requests.reject-price', $serviceRequest) }}"
                              style="flex:1"
                              onsubmit="return confirm('{{ __('guest.show.confirm_reject') }}')">

                            @csrf

                            <button type="submit"
                                    class="ui-btn ui-btn--outline">

                                {{ __('guest.show.reject') }}

                            </button>

                        </form>

                    </div>

                </div>

            @endif


            {{-- Pembayaran laundry sebelum diantar --}}
            @if ($serviceRequest->status === 'waiting_payment')

                <div class="ui-card ui-rise">

                    <h3 class="ui-heading" style="margin-bottom:12px">
                        {{ __('guest.show.laundry_payment') }}
                    </h3>

                    @if (session('error'))
                        <div class="ui-alert ui-alert--error" style="margin-bottom:12px">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Sudah dibayar --}}
                    @if ($serviceRequest->laundry_paid_at)

                        <div class="ui-alert ui-alert--success">
                            {{ __('guest.show.laundry_already_paid') }}
                        </div>

                    @else

                        {{-- Informasi pembayaran --}}
                        <div class="ui-price" style="display:block">

                            <p class="ui-price-note"
                               style="color:#6B7280;font-size:12px">
                                {{ __('guest.show.laundry_ready') }}
                            </p>

                            <p class="ui-price-value"
                               style="font-size:26px;margin-top:6px">

                                Rp{{ number_format($serviceRequest->total_price, 0, ',', '.') }}

                            </p>

                        </div>

                        {{-- Tombol bayar --}}
                        <form method="POST"
                              action="{{ route('guest.service-requests.pay-laundry', $serviceRequest) }}"
                              style="margin-top:14px">

                            @csrf

                            <button type="submit"
                                    class="ui-btn ui-btn--primary">

                                {{ __('guest.show.pay_now') }}

                            </button>

                        </form>

                    @endif

                </div>

            @endif


            {{-- Foto --}}
            @if ($serviceRequest->photos->isNotEmpty())

                <div class="ui-card ui-rise">

                    <h3 class="ui-heading" style="margin-bottom:12px">
                        {{ __('guest.show.photos') }}
                    </h3>

                    <div class="ui-opts ui-opts--2" style="margin-top:0">

                        @foreach ($serviceRequest->photos as $photo)

                            <div>

                                <p class="ui-row-meta"
                                   style="margin:0 0 6px;font-weight:700">

                                    {{ __('guest.photo_types.' . $photo->type) }}

                                </p>

                                <a href="{{ Storage::url($photo->photo_path) }}"
                                   target="_blank">

                                    <img src="{{ Storage::url($photo->photo_path) }}"
                                         alt="{{ $photo->type }}"
                                         style="width:100%;height:128px;object-fit:cover;border-radius:14px;border:1px solid #F1F1F1">

                                </a>

                            </div>

                        @endforeach

                    </div>

                </div>

            @endif


            {{-- Feedback --}}
            @if ($serviceRequest->status === 'completed')

                <div class="ui-card ui-rise" id="feedback">

                    <h3 class="ui-heading" style="margin-bottom:12px">
                        {{ __('guest.show.feedback_title') }}
                    </h3>

                    {{-- Feedback sudah diberikan --}}
                    @if ($serviceRequest->feedback)

                        <div class="ui-alert ui-alert--success">

                            <p style="font-weight:800">
                                {{ __('guest.show.feedback_thanks') }}
                            </p>

                            <div class="ui-stars" style="margin-top:8px">

                                @for ($i = 1; $i <= 5; $i++)

                                    <svg class="{{ $i <= $serviceRequest->feedback->rating ? 'on' : '' }}"
                                         fill="currentColor"
                                         viewBox="0 0 20 20">

                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>

                                    </svg>

                                @endfor

                            </div>

                            @if ($serviceRequest->feedback->comment)

                                <p style="margin-top:8px;color:#374151">
                                    "{{ $serviceRequest->feedback->comment }}"
                                </p>

                            @endif

                        </div>

                    @else

                        {{-- Form feedback --}}
                        <form method="POST"
                              action="{{ route('guest.service-requests.feedback', $serviceRequest) }}"
                              class="ui-form">

                            @csrf

                            <div>

                                <span class="ui-label">
                                    {{ __('guest.show.rating') }}
                                    <span class="text-red-500">*</span>
                                </span>

                                <div class="ui-rate"
                                     role="radiogroup"
                                     aria-label="{{ __('guest.show.rating') }}">

                                    @for ($i = 5; $i >= 1; $i--)

                                        <input type="radio"
                                               name="rating"
                                               id="rating-{{ $i }}"
                                               value="{{ $i }}"
                                               {{ old('rating') == $i ? 'checked' : '' }}
                                               required>

                                        <label for="rating-{{ $i }}">

                                            <svg fill="currentColor"
                                                 viewBox="0 0 20 20">

                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>

                                            </svg>

                                        </label>

                                    @endfor

                                </div>

                                <x-input-error
                                    :messages="$errors->get('rating')"
                                    class="mt-2"
                                />

                            </div>


                            <div>

                                <label for="comment" class="ui-label">
                                    {{ __('guest.show.comment_optional') }}
                                </label>

                                <textarea name="comment"
                                          id="comment"
                                          rows="3"
                                          class="ui-input"
                                          placeholder="{{ __('guest.show.comment_placeholder') }}">{{ old('comment') }}</textarea>

                                <x-input-error
                                    :messages="$errors->get('comment')"
                                    class="mt-2"
                                />

                            </div>


                            <button type="submit"
                                    class="ui-btn ui-btn--primary">

                                {{ __('guest.show.send_feedback') }}

                            </button>

                        </form>

                    @endif

                </div>

            @endif


            {{-- Kembali --}}
            <a href="{{ route('guest.service-requests.index') }}"
               class="ui-btn ui-btn--outline">

                {{ __('guest.common.back_to_list') }}

            </a>

        </div>
    </div>

</div>

@endsection

