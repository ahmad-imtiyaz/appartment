<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    private const MAX_ATTEMPTS = 5;

    public function create(Request $request): View
    {
        return view('auth.reset-password', [
            'email' => old('email', session('reset_email', '')),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'code' => ['required', 'digits:6'],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        $email = strtolower(trim($request->email));

        // Maksimal 10 percobaan dalam 5 menit per email dan IP.
        $throttle = 'reset-code:' . $email . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttle, 10)) {
            $seconds = RateLimiter::availableIn($throttle);

            return $this->fail(
                $email,
                __('Too many attempts. Please try again in :seconds seconds.', [
                    'seconds' => $seconds,
                ])
            );
        }

        RateLimiter::hit($throttle, 300);

        $record = DB::table('password_reset_codes')
            ->where('email', $email)
            ->first();

        if (! $record || now()->greaterThan($record->expires_at)) {
            return $this->fail(
                $email,
                __('The code is invalid or has expired. Please request a new one.')
            );
        }

        if ($record->attempts >= self::MAX_ATTEMPTS) {
            DB::table('password_reset_codes')
                ->where('email', $email)
                ->delete();

            return $this->fail(
                $email,
                __('Too many wrong codes. Please request a new one.')
            );
        }

        if (! Hash::check($request->code, $record->code_hash)) {
            DB::table('password_reset_codes')
                ->where('email', $email)
                ->increment('attempts');

            return $this->fail($email, __('The code is incorrect.'));
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return $this->fail(
                $email,
                __('The code is invalid or has expired. Please request a new one.')
            );
        }

        // Model User menggunakan cast hashed, sehingga password diisi
        // dengan teks asli dan Laravel meng-hash saat menyimpan.
        $user->forceFill([
            'password' => $request->password,
            'remember_token' => Str::random(60),
        ])->save();

        // OTP hanya bisa digunakan sekali.
        DB::table('password_reset_codes')
            ->where('email', $email)
            ->delete();

        RateLimiter::clear($throttle);

        event(new PasswordReset($user));

        return redirect()
            ->route('login')
            ->with(
                'status',
                __('Password changed. Please log in with your new password.')
            );
    }

    private function fail(
        string $email,
        string $message
    ): RedirectResponse {
        return redirect()
            ->route('password.reset')
            ->withInput(['email' => $email])
            ->withErrors(['code' => $message])
            ->with('reset_email', $email);
    }
}
