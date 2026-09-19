<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RepairPricing extends Model
{
    public const SEVERITIES = [
        'ringan' => 'Ringan',
        'sedang' => 'Sedang',
        'berat'  => 'Berat',
    ];

    // Harus sinkron dengan opsi damage_category di form guest (create.blade.php)
    // "lainnya" sengaja tidak dimasukkan — kategori itu tidak punya harga patok.
    public const CATEGORIES = [
        'cat_luntur'     => 'Cat Luntur / Rontok',
        'kebocoran'      => 'Kebocoran Air / Pipa',
        'listrik'        => 'Kelistrikan (lampu mati, saklar, stop kontak)',
        'ac'             => 'AC (tidak dingin, bocor, error)',
        'pintu_jendela'  => 'Pintu / Jendela (sulit dibuka, kaca pecah)',
        'furniture'      => 'Furnitur Bawaan (rak, lemari, meja rusak)',
    ];

    protected $fillable = [
        'category',
        'severity',
        'price',
        'description',
        'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getSeverityLabelAttribute(): string
    {
        return self::SEVERITIES[$this->severity] ?? ucfirst($this->severity);
    }

    /**
     * Cari harga patok untuk kombinasi kategori  tingkat kerusakan (hanya yang aktif).
     */
    public function scopeByCategoryAndSeverity(Builder $query, string $category, string $severity): Builder
    {
        return $query->active()->where('category', $category)->where('severity', $severity);
    }
}
