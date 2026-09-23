<?php

namespace App\Models;

class RepairPricing
{
    public const SEVERITIES = [
        'ringan' => 'Ringan',
        'sedang' => 'Sedang',
        'berat'  => 'Berat',
    ];

    // Harus sinkron dengan opsi damage_category di form guest (create.blade.php)
    public const CATEGORIES = [
        'cat_luntur'     => 'Cat Luntur / Rontok',
        'kebocoran'      => 'Kebocoran Air / Pipa',
        'listrik'        => 'Kelistrikan (lampu mati, saklar, stop kontak)',
        'ac'             => 'AC (tidak dingin, bocor, error)',
        'pintu_jendela'  => 'Pintu / Jendela (sulit dibuka, kaca pecah)',
        'furniture'      => 'Furnitur Bawaan (rak, lemari, meja rusak)',
    ];
}
