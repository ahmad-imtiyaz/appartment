{{--
    Tombol "Lihat Detail" & "Lihat Proses" + popup info layanan (guest).

    Param:
      $lang        prefix lang, mis. 'guest.laundry_info'
                   (butuh: process_title, process_subtitle, steps.{key}.title/desc,
                    detail_title, detail_subtitle, dan points.* atau grid_title + grid.*)
      $steps       [key => isi <svg>] langkah proses
      $iconBg      warna kotak ikon langkah, $iconColor warna ikonnya
      $points      (opsional) daftar key detail ditampilkan sebagai list
      $grid        (opsional) [key => isi <svg>] detail ditampilkan grid 2 kolom berikon
      $areas       (opsional) [key => isi <svg>] detail ditampilkan daftar bernomor berikon
                   (butuh areas_title + areas.{key}.title/desc)
      $processNote (opsional) true = tampilkan catatan peringatan di bawah langkah proses
                   (butuh process_note.title/desc)
--}}
@php
    $points = $points ?? [];
    $grid = $grid ?? [];
    $areas = $areas ?? [];
    $processNote = $processNote ?? false;
@endphp

<div x-data="{ modal: null }" @keydown.escape.window="modal = null">

    <div style="display:flex;gap:8px">
        <button type="button" @click="modal = 'detail'" class="ui-btn ui-btn--outline">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
            {{ __('guest.service_info.view_detail') }}
        </button>
        <button type="button" @click="modal = 'process'" class="ui-btn ui-btn--outline">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/></svg>
            {{ __('guest.service_info.view_process') }}
        </button>
    </div>

    <template x-teleport="body">
        <div x-show="modal" x-cloak x-transition.opacity
             style="position:fixed;inset:0;z-index:60;background:rgba(17,24,39,.55);display:flex;align-items:flex-end;justify-content:center;padding:16px">

            <div @click.outside="modal = null"
                 style="position:relative;width:100%;max-width:420px;background:#fff;border-radius:20px;padding:20px;max-height:90vh;overflow-y:auto">

                <button type="button" @click="modal = null" aria-label="{{ __('guest.service_info.close') }}"
                        style="position:absolute;top:14px;right:14px;width:32px;height:32px;border-radius:9999px;background:#F3F4F6;color:#6B7280;display:flex;align-items:center;justify-content:center">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                {{-- ===== Lihat Proses ===== --}}
                <div x-show="modal === 'process'">
                    <h3 class="ui-heading" style="padding-right:36px">{{ __($lang . '.process_title') }}</h3>
                    <p class="ui-sub">{{ __($lang . '.process_subtitle') }}</p>

                    <ol style="margin-top:16px;list-style:none;padding:0">
                        @foreach ($steps as $key => $icon)
                            <li style="display:flex;gap:12px;position:relative;padding-bottom:{{ $loop->last ? '0' : '16px' }}">
                                @unless ($loop->last)
                                    {{-- garis penghubung antar langkah --}}
                                    <span style="position:absolute;left:21px;top:44px;bottom:0;border-left:2px dashed {{ $iconBg }}"></span>
                                @endunless
                                <span style="width:44px;height:44px;flex-shrink:0;border-radius:12px;background:{{ $iconBg }};color:{{ $iconColor }};display:flex;align-items:center;justify-content:center">
                                    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">{!! $icon !!}</svg>
                                </span>
                                <div style="padding-top:2px">
                                    <p style="font-size:13px;font-weight:800;color:#111827">
                                        {{ $loop->iteration }}. {{ __($lang . '.steps.' . $key . '.title') }}
                                    </p>
                                    <p class="ui-sub" style="margin-top:2px">{{ __($lang . '.steps.' . $key . '.desc') }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ol>

                    @if ($processNote)
                        <div class="ui-divider" style="display:flex;gap:10px">
                            <svg width="20" height="20" fill="none" stroke="#DC2626" viewBox="0 0 24 24" stroke-width="1.8" style="flex-shrink:0"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                            <div>
                                <p style="font-size:12.5px;font-weight:800;color:#111827">{{ __($lang . '.process_note.title') }}</p>
                                <p class="ui-sub" style="margin-top:2px">{{ __($lang . '.process_note.desc') }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- ===== Lihat Detail ===== --}}
                <div x-show="modal === 'detail'">
                    <h3 class="ui-heading" style="padding-right:36px">{{ __($lang . '.detail_title') }}</h3>
                    <p class="ui-sub">{{ __($lang . '.detail_subtitle') }}</p>

                    @if ($points)
                        <dl style="margin-top:12px">
                            @foreach ($points as $point)
                                <div style="padding:11px 0;{{ $loop->last ? '' : 'border-bottom:1px solid #F3F4F6' }}">
                                    <dt style="font-size:12.5px;font-weight:800;color:#111827">{{ __($lang . '.points.' . $point . '.title') }}</dt>
                                    <dd class="ui-sub" style="margin-top:2px">{{ __($lang . '.points.' . $point . '.desc') }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    @endif

                    @if ($grid)
                        <p class="ui-label" style="margin:16px 0 8px">{{ __($lang . '.grid_title') }}</p>
                        <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px">
                            @foreach ($grid as $key => $icon)
                                <div style="border:1px solid #F3F4F6;border-radius:14px;padding:12px;background:#FAFAFA">
                                    <span style="width:36px;height:36px;border-radius:10px;background:{{ $iconBg }};color:{{ $iconColor }};display:flex;align-items:center;justify-content:center">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.6">{!! $icon !!}</svg>
                                    </span>
                                    <p style="font-size:12.5px;font-weight:800;color:#111827;margin-top:8px">{{ __($lang . '.grid.' . $key . '.title') }}</p>
                                    <p class="ui-sub" style="margin-top:2px;font-size:11px">{{ __($lang . '.grid.' . $key . '.desc') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($areas)
                        <p class="ui-label" style="margin:16px 0 4px">{{ __($lang . '.areas_title') }}</p>
                        <ol style="list-style:none;padding:0">
                            @foreach ($areas as $key => $icon)
                                <li style="display:flex;gap:12px;padding:11px 0;{{ $loop->last ? '' : 'border-bottom:1px solid #F3F4F6' }}">
                                    <svg width="24" height="24" fill="none" stroke="{{ $iconColor }}" viewBox="0 0 24 24" stroke-width="1.6" style="flex-shrink:0">{!! $icon !!}</svg>
                                    <div>
                                        <p style="font-size:12.5px;font-weight:800;color:#111827">{{ $loop->iteration }}. {{ __($lang . '.areas.' . $key . '.title') }}</p>
                                        <p class="ui-sub" style="margin-top:2px">{{ __($lang . '.areas.' . $key . '.desc') }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>

                <button type="button" @click="modal = null" class="ui-btn ui-btn--primary" style="margin-top:16px">
                    {{ __('guest.service_info.got_it') }}
                </button>
            </div>
        </div>
    </template>
</div>
