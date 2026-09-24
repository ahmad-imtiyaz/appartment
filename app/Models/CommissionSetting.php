<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionSetting extends Model
{
    protected $fillable = ['percentage'];

    protected function casts(): array
    {
        return [
            'percentage' => 'decimal:2',
        ];
    }

    // Baris setting yang aktif (dibuat otomatis 10% kalau belum ada)
    public static function current(): self
    {
        return static::query()->first()
            ?? static::create(['percentage' => 10]);
    }

    public static function percentage(): float
    {
        return (float) static::current()->percentage;
    }
}
