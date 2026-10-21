<?php

/*
|--------------------------------------------------------------------------
| Ikon SVG (isi <svg>, viewBox 0 0 24 24, stroke) untuk halaman guest
|--------------------------------------------------------------------------
| Dipakai bersama oleh form pesanan dan popup "Lihat Detail / Lihat Proses"
| supaya ikonnya selalu sama.
*/

return [

    // Kategori kerusakan Perbaikan & Perawatan (key = RepairPricing::CATEGORIES + 'lainnya')
    'damage_categories' => [
        // kuas cat
        'cat_luntur'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 4h12v5H4zM16 6.5h3v5h-8v3"/><path stroke-linecap="round" stroke-linejoin="round" d="M10 14.5h2v6.5h-2z"/>',
        // tetesan air
        'kebocoran'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3s6 6.7 6 11a6 6 0 01-12 0c0-4.3 6-11 6-11z"/>',
        // petir
        'listrik'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M13 3L4 14h7v7l9-11h-7z"/>',
        // angin
        'ac'            => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 8h11a3 3 0 10-3-3M3 12h15a3 3 0 11-3 3M3 16h7"/>',
        // pintu
        'pintu_jendela' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 21V4a1 1 0 011-1h10a1 1 0 011 1v17M3 21h18"/><circle cx="15" cy="12.5" r="0.9" fill="currentColor" stroke="none"/>',
        // sofa
        'furniture'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 11V8a3 3 0 013-3h8a3 3 0 013 3v3M3 13a2 2 0 014 0v2h10v-2a2 2 0 014 0v4a1 1 0 01-1 1H4a1 1 0 01-1-1v-4zM6 18v2M18 18v2"/>',
        // kunci pas
        'lainnya'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z"/>',
    ],

    // Langkah proses laundry
    'laundry_steps' => [
        // kotak / paket
        'pickup'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/>',
        // mesin cuci
        'wash'    => '<rect x="4" y="2.5" width="16" height="19" rx="2.5"/><circle cx="12" cy="13.5" r="4.5"/><path stroke-linecap="round" d="M7.5 6h1.5M15 6h1.5"/>',
        // centang
        'done'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        // HP
        'pay'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3"/>',
        // truk
        'deliver' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>',
    ],

    // Langkah proses Perbaikan & Perawatan
    'repair_steps' => [
        // kalender centang
        'order'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75zM3 9.75h18M9 15l2 2 4-4"/>',
        // kaca pembesar
        'survey'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>',
        // dokumen
        'estimate' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>',
        // dompet
        'pay'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3"/>',
        // kunci pas
        'repair'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z"/>',
    ],

    // Langkah proses Cleaning
    'cleaning_steps' => [
        // kalender centang
        'order'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75zM3 9.75h18M9 15l2 2 4-4"/>',
        // orang centang
        'arrive'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M14 7a4 4 0 11-8 0 4 4 0 018 0zM2.5 20a7.5 7.5 0 0112.4-5.7M15.5 18l2 2 4-4"/>',
        // botol semprot
        'clean'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 9h5l1.5 3v8a1 1 0 01-1 1h-6a1 1 0 01-1-1v-8L9 9zM10 9V6h3v3M10 6V4h5l2 2M19 4.5h.01M20.5 6.5h.01M19 8.5h.01"/>',
        // centang
        'confirm' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        // dompet
        'pay'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3"/>',
    ],

    // Langkah proses AC
    'ac_steps' => [
        // kalender centang
        'order'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75zM3 9.75h18M9 15l2 2 4-4"/>',
        // kaca pembesar
        'check'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>',
        // dokumen
        'estimate' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>',
        // kunci pas
        'work'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z"/>',
        // dompet
        'pay'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3"/>',
    ],

    // Jenis layanan AC (key = ac_type)
    'ac_types' => [
        // tetesan air
        'ac-cleaning'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3s6 6.7 6 11a6 6 0 01-12 0c0-4.3 6-11 6-11z"/>',
        // kepingan salju
        'ac-refill'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 2v20M4.5 6.5l15 11M19.5 6.5l-15 11M9.5 3.5L12 6l2.5-2.5M9.5 20.5L12 18l2.5 2.5"/>',
        // kunci pas
        'ac-repair'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z"/>',
        // perisai centang
        'ac-full-service' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>',
    ],

    // Area yang dibersihkan (Cleaning)
    'cleaning_areas' => [
        // sofa
        'living'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 11V8a3 3 0 013-3h8a3 3 0 013 3v3M3 13a2 2 0 014 0v2h10v-2a2 2 0 014 0v4a1 1 0 01-1 1H4a1 1 0 01-1-1v-4zM6 18v2M18 18v2"/>',
        // kasur
        'bedroom'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 6v13M3 14h18v5M21 14v-2a3 3 0 00-3-3h-7v5"/><circle cx="7" cy="11.5" r="1.5"/>',
        // bathtub
        'bathroom' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18v2a5 5 0 01-5 5H8a5 5 0 01-5-5v-2zM6 12V5.5A2.5 2.5 0 018.5 3c1.2 0 2.2.8 2.4 2M7 19l-1 2M17 19l1 2"/>',
        // dapur (kompor)
        'kitchen'  => '<rect x="4" y="3" width="16" height="18" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 9h16M8 6h.01M12 6h.01M16 6h.01M8 13h8v5H8z"/>',
        // matahari
        'balcony'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>',
        // tempat sampah
        'common'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>',
    ],

];
