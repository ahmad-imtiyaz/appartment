<?php

return [

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Admin
    |--------------------------------------------------------------------------
    |
    | Nomor WhatsApp admin untuk tombol "Chat Admin" di sisi guest.
    | Isi di .env, contoh: ADMIN_WHATSAPP=6281234567890
    | Format 08xxx atau 628xxx sama-sama boleh, nanti dinormalisasi.
    |
    */

    'admin_whatsapp' => env('ADMIN_WHATSAPP'),

    'fcm' => [
        'credentials' => env('FCM_CREDENTIALS', storage_path('app/firebase-service-account.json')),
    ],

];
