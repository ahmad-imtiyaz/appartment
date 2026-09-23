@php
    $pendingTopups = auth()->user()->topupRequests()->where('status', 'pending')->get();
    $pendingCount  = $pendingTopups->count();
    $pendingTotal  = $pendingTopups->sum('amount');
@endphp

@if ($pendingCount > 0)
    <a href="{{ route('guest.topups.index') }}"
       style="display:flex;align-items:flex-start;gap:12px;padding:14px;border-radius:16px;
              background:#FFFBEB;border:1px solid #FDE68A;text-decoration:none;">
        <span style="flex-shrink:0;width:36px;height:36px;border-radius:12px;background:#FEF3C7;color:#D97706;
                     display:flex;align-items:center;justify-content:center;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </span>
        <span style="min-width:0;">
            <span style="display:block;font-size:13px;font-weight:800;color:#92400E;">
                {{ __('guest.topup.pending_banner_title') }}
            </span>
            <span style="display:block;margin-top:2px;font-size:12px;line-height:1.45;color:#B45309;">
                {{ __('guest.topup.pending_banner_desc', [
                    'count'  => $pendingCount,
                    'amount' => 'Rp' . number_format($pendingTotal, 0, ',', '.'),
                ]) }}
            </span>
        </span>
    </a>
@endif
