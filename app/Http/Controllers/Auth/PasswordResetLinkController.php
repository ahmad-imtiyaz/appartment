<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Tampilkan form lupa password (email + password baru).
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Ganti password langsung berdasarkan email, tanpa kirim link.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Batasi percobaan: maksimal 5x per menit per IP.
        $key = 'forgot-password:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => __('Too many attempts. Please try again in :seconds seconds.', ['seconds' => $seconds]),
                ]);
        }

        RateLimiter::hit($key, 60);

        // Akun admin tidak boleh direset lewat jalur ini.
        $user = User::where('email', strtolower($request->email))
            ->where('role', '!=', 'admin')
            ->first();

        if (! $user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => __('We could not find an account with that email.'),
                ]);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        RateLimiter::clear($key);

        return redirect()
            ->route('login')
            ->with('status', __('Password changed. Please log in with your new password.'));
    }
}
