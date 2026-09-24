<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    /**
     * Simpan (atau pindahkan) token FCM HP ini ke pekerja yang sedang login.
     * Dipanggil otomatis oleh JavaScript di halaman pekerja.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'token'    => ['required', 'string', 'max:255'],
            'platform' => ['nullable', 'in:android'],
        ]);

        // Token = identitas HP. Kalau HP yang sama dipakai login akun lain,
        // token otomatis pindah ke akun yang sedang login.
        DeviceToken::updateOrCreate(
            ['token' => $validated['token']],
            [
                'user_id'  => $request->user()->id,
                'platform' => $validated['platform'] ?? 'android',
            ]
        );

        return response()->json(['ok' => true]);
    }
}
