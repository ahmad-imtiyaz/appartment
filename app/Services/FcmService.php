<?php

namespace App\Services;

use App\Models\DeviceToken;
use App\Models\User;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class FcmService
{
    private const SCOPE = 'https://www.googleapis.com/auth/firebase.messaging';
    private const TOKEN_CACHE_KEY = 'fcm_access_token';

    // Harus sama dengan channel yang dibuat di aplikasi Flutter (push_notifications.dart).
    private const CHANNEL_ID = 'tugas_baru';

    /**
     * Kirim push ke semua HP milik $user.
     *
     * Tidak pernah melempar exception: kalau FCM bermasalah, proses utama
     * (misalnya assign tugas) tetap berjalan dan error hanya masuk log.
     *
     * @param  array<string, scalar>  $data
     */
    public function sendToUser(User $user, string $title, string $body, array $data = []): void
    {
        try {
            $tokens = $user->deviceTokens()->pluck('token');

            if ($tokens->isEmpty()) {
                return;
            }

            $credentials = $this->credentials();
            $accessToken = $this->accessToken($credentials);
            $url = "https://fcm.googleapis.com/v1/projects/{$credentials['project_id']}/messages:send";

            foreach ($tokens as $token) {
                $response = Http::withToken($accessToken)
                    ->timeout(10)
                    ->post($url, [
                        'message' => $this->buildMessage($token, $title, $body, $data),
                    ]);

                if ($response->successful()) {
                    continue;
                }

                $status = $response->json('error.status');

                if ($status === 'NOT_FOUND') {
                    // Token sudah tidak berlaku (app di-uninstall / token diganti).
                    DeviceToken::where('token', $token)->delete();
                    continue;
                }

                if ($status === 'UNAUTHENTICATED') {
                    Cache::forget(self::TOKEN_CACHE_KEY);
                }

                Log::warning('FCM gagal mengirim notifikasi', [
                    'user_id' => $user->id,
                    'http'    => $response->status(),
                    'body'    => $response->body(),
                ]);
            }
        } catch (Throwable $e) {
            Log::error('FCM error: ' . $e->getMessage());
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function buildMessage(string $token, string $title, string $body, array $data): array
    {
        $message = [
            'token'        => $token,
            'notification' => [
                'title' => $title,
                'body'  => $body,
            ],
            'android' => [
                'priority'     => 'HIGH',
                'notification' => [
                    'channel_id' => self::CHANNEL_ID,
                    'sound'      => 'default',
                ],
            ],
        ];

        // Nilai data FCM harus string, dan tidak boleh berupa array kosong.
        if ($data !== []) {
            $message['data'] = array_map('strval', $data);
        }

        return $message;
    }

    /**
     * @return array<string, mixed>
     */
    private function credentials(): array
    {
        $path = config('oregonet.fcm.credentials');

        return json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Token OAuth berlaku ~1 jam, jadi disimpan di cache supaya tidak
     * diminta ulang setiap kali mengirim notifikasi.
     */
    private function accessToken(array $credentials): string
    {
        return Cache::remember(self::TOKEN_CACHE_KEY, 3000, function () use ($credentials) {
            $auth = new ServiceAccountCredentials(self::SCOPE, $credentials);

            return $auth->fetchAuthToken()['access_token'];
        });
    }
}
