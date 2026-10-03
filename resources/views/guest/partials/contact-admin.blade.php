@php
    $adminWaUrl = \App\Services\AdminWhatsappLink::for(auth()->user());
@endphp

@if ($adminWaUrl)
<style>
    .ca-card{
        display:flex;
        align-items:center;
        gap:12px;
        margin-bottom:22px;
        padding:12px 14px;
        background:#fff;
        border:1px solid #E5E7EB;
        border-radius:18px;
        text-decoration:none;
        box-shadow:0 1px 2px rgba(17,24,39,.04);
        transition:transform .15s ease,box-shadow .15s ease;
        -webkit-tap-highlight-color:transparent;
    }

    .ca-card:active{
        transform:scale(.98);
    }

    .ca-card:focus-visible{
        outline:2px solid #6366F1;
        outline-offset:2px;
    }

    .ca-icon{
        width:40px;
        height:40px;
        border-radius:12px;
        background:#EEF2FF;
        color:#6366F1;
        display:flex;
        align-items:center;
        justify-content:center;
        flex-shrink:0;
    }

    .ca-icon svg{
        width:22px;
        height:22px;
    }

    .ca-text{
        min-width:0;
        flex:1;
    }

    .ca-title{
        display:block;
        font-size:13.5px;
        font-weight:800;
        color:#111827;
        line-height:1.25;
    }

    .ca-desc{
        display:block;
        margin-top:2px;
        font-size:11px;
        color:#6B7280;
        line-height:1.35;
    }

    .ca-arrow{
        width:26px;
        height:26px;
        border-radius:50%;
        background:#F3F4F6;
        color:#9CA3AF;
        display:flex;
        align-items:center;
        justify-content:center;
        flex-shrink:0;
    }

    .ca-arrow svg{
        width:13px;
        height:13px;
    }

    @media (prefers-reduced-motion:reduce){
        .ca-card{
            transition:none;
        }
    }
</style>

{{-- Tanpa target="_blank": di app Flutter link ini dicegat lewat onNavigationRequest
     lalu dibuka di aplikasi WhatsApp. --}}
<a href="{{ $adminWaUrl }}"
   rel="noopener"
   class="ca-card"
   aria-label="{{ __('guest.contact.title') }}">

    {{-- Icon Chat Admin --}}
    <span class="ca-icon">
        <svg viewBox="0 0 24 24"
             fill="none"
             stroke="currentColor"
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round"
             aria-hidden="true">

            <path d="M21 11.5a8.38 8.38 0 0 1-9 8.5
                     8.5 8.5 0 0 1-4.5-1.3L3 20l1.3-4.5
                     A8.5 8.5 0 1 1 21 11.5z"/>

            <path d="M8 11h.01"/>
            <path d="M12 11h.01"/>
            <path d="M16 11h.01"/>
        </svg>
    </span>

    <span class="ca-text">
        <span class="ca-title">Chat Admin</span>
        <span class="ca-desc">
            Ada pertanyaan atau kendala? Hubungi admin untuk mendapatkan bantuan.
        </span>
    </span>

    <span class="ca-arrow">
        <svg fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24"
             stroke-width="2.5"
             aria-hidden="true">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M9 5l7 7-7 7"/>
        </svg>
    </span>

</a>
@endif
