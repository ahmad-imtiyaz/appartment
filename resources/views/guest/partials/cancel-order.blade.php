{{--
    Tombol + modal batal pesanan (guest).
    Param: $serviceRequest, $block (opsional, true = tombol full width)
--}}
@php
    $failedHere = (string) old('cancel_request_id') === (string) $serviceRequest->id;
@endphp

<div x-data="{ open: {{ $failedHere && $errors->hasAny(['cancel_reason', 'cancel_note']) ? 'true' : 'false' }}, reason: {{ Js::from($failedHere ? old('cancel_reason', '') : '') }} }"
     class="{{ !empty($block) ? '' : 'shrink-0' }}">

    <button type="button" @click="open = true"
            class="ui-btn ui-btn--soft {{ !empty($block) ? '' : 'ui-btn--sm' }}">
        {{ __('guest.detail.cancel') }}
    </button>

    <template x-teleport="body">
        <div x-show="open" x-cloak x-transition.opacity
             @keydown.escape.window="open = false"
             style="position:fixed;inset:0;z-index:60;background:rgba(17,24,39,.55);display:flex;align-items:flex-end;justify-content:center;padding:16px">

            <div @click.outside="open = false"
                 style="width:100%;max-width:420px;background:#fff;border-radius:20px;padding:20px;max-height:90vh;overflow-y:auto">

                <h3 class="ui-heading">{{ __('guest.cancel.title') }}</h3>
                <p class="ui-sub">{{ __('guest.cancel.subtitle', ['id' => str_pad($serviceRequest->id, 7, '0', STR_PAD_LEFT)]) }}</p>

                <form method="POST" action="{{ route('guest.service-requests.cancel', $serviceRequest) }}" style="margin-top:14px">
                    @csrf
                    <input type="hidden" name="cancel_request_id" value="{{ $serviceRequest->id }}">

                    <div class="ui-stack" style="gap:8px">
                        @foreach (\App\Models\ServiceRequest::GUEST_CANCEL_REASONS as $key)
                            <label style="display:flex;align-items:center;gap:10px;padding:11px 13px;border:1px solid #E5E7EB;border-radius:12px;cursor:pointer;font-size:13px"
                                   :style="reason === '{{ $key }}' && { borderColor: '#DC2626', background: '#FEF2F2' }">
                                <input type="radio" name="cancel_reason" value="{{ $key }}" x-model="reason"
                                       style="accent-color:#DC2626">
                                {{ __('guest.cancel_reasons.' . $key) }}
                            </label>
                        @endforeach
                    </div>

                    @if ($failedHere)
                        @error('cancel_reason')
                            <p class="ui-hint" style="color:#B91C1C">{{ $message }}</p>
                        @enderror
                    @endif

                    <div x-show="reason === 'other'" x-cloak style="margin-top:12px">
                        <label class="ui-label" for="cancel_note_{{ $serviceRequest->id }}">{{ __('guest.cancel.note_label') }}</label>
                        <textarea id="cancel_note_{{ $serviceRequest->id }}" name="cancel_note" rows="2" maxlength="255"
                                  class="ui-input" placeholder="{{ __('guest.cancel.note_placeholder') }}"
                                  :required="reason === 'other'">{{ $failedHere ? old('cancel_note') : '' }}</textarea>
                        @if ($failedHere)
                            @error('cancel_note')
                                <p class="ui-hint" style="color:#B91C1C">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>

                    <div style="display:flex;gap:8px;margin-top:16px">
                        <button type="button" @click="open = false" class="ui-btn ui-btn--outline">
                            {{ __('guest.cancel.back') }}
                        </button>
                        <button type="submit" class="ui-btn ui-btn--primary" :disabled="!reason" :style="!reason && { opacity: .5 }">
                            {{ __('guest.cancel.confirm') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </template>
</div>
