<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetCodeMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;


class PasswordResetLinkController extends Controller
{
    private const CODE_MINUTES = 10;

    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $email = strtolower(trim($request->email));

        // Maksimal satu permintaan OTP per menit per email dan IP.
        $key = 'forgot-code:' . $email . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 1)) {
            $seconds = RateLimiter::availableIn($key);

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => __(
                        'Please wait :seconds seconds before requesting a new code.',
                        ['seconds' => $seconds]
                    ),
                ]);
        }

        RateLimiter::hit($key, 60);

        $user = User::where('email', $email)->first();

        if ($user) {
            $code = str_pad(
                (string) random_int(0, 999999),
                6,
                '0',
                STR_PAD_LEFT
            );

            // Hapus OTP lama untuk email ini.
            DB::table('password_reset_codes')
                ->where('email', $email)
                ->delete();

            // Simpan hash OTP dengan masa berlaku 10 menit.
            DB::table('password_reset_codes')->insert([
                'email' => $email,
                'code_hash' => Hash::make($code),
                'attempts' => 0,
                'expires_at' => now()->addMinutes(self::CODE_MINUTES),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Kirim kode ke email.
            Mail::to($user->email)->send(
                new PasswordResetCodeMail($code, self::CODE_MINUTES)
            );
        }

        // Tidak memerlukan parameter token.
        return redirect()
            ->route('password.reset')
            ->with('reset_email', $email)
            ->with(
                'status',
                __('If the email is registered, a 6-digit code has been sent.')
            );
    }
}
