<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\BalanceMutation;
use App\Models\PaymentMethod;
use App\Models\TopupRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\CoinMutation;
use Illuminate\Support\Facades\DB;

class TopupController extends Controller
{
    public function index()
    {
        $topups = auth()->user()->topupRequests()->with('paymentMethod')->latest()->get();

        return view('guest.topups.index', compact('topups'));
    }

    public function balance(Request $request): View
{
    $filter = in_array($request->query('filter'), ['saldo', 'koin']) ? $request->query('filter') : 'all';
    $userId = auth()->id();

    $balanceQuery = fn () => DB::table('balance_mutations')
        ->select(
            DB::raw("'saldo' as kind"),
            'id', 'type',
            DB::raw("CASE WHEN type = 'credit' THEN 'in' ELSE 'out' END as direction"),
            'amount', 'balance_before', 'balance_after',
            'reference_type', 'reference_id', 'description', 'created_at'
        )
        ->where('user_id', $userId);

    $coinQuery = fn () => DB::table('coin_mutations')
        ->select(
            DB::raw("'koin' as kind"),
            'id', 'type',
            DB::raw("CASE WHEN type = 'earn' THEN 'in' ELSE 'out' END as direction"),
            'amount', 'balance_before', 'balance_after',
            'reference_type', 'reference_id', 'description', 'created_at'
        )
        ->where('user_id', $userId);

    $mutations = match ($filter) {
        'saldo' => $balanceQuery()->orderByDesc('created_at')->paginate(20)->withQueryString(),
        'koin' => $coinQuery()->orderByDesc('created_at')->paginate(20)->withQueryString(),
        default => $balanceQuery()->unionAll($coinQuery())->orderByDesc('created_at')->paginate(20)->withQueryString(),
    };

    auth()->user()->forceFill(['notif_seen_at' => now()])->save();

    return view('guest.balance', compact('mutations', 'filter'));
}

    public function create(): View
    {
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('guest.topups.create', compact('paymentMethods'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'amount' => ['required', 'numeric', 'min:10000'],
            'proof_image' => ['required', 'image', 'max:2048'],
        ]);

        $validated['proof_image'] = $request->file('proof_image')->store('topup-proofs', 'public');
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        TopupRequest::create($validated);

        return back()->with('success', 'Pengajuan top up terkirim, menunggu verifikasi admin.');
    }
}
