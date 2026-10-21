<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PromoBanner extends Model
{
    /**
     * Ukuran gambar yang ditentukan (rasio 3:1). Upload di-validasi
     * dengan rasio ini supaya semua banner tampil seragam.
     */
    public const WIDTH = 1200;
    public const HEIGHT = 400;

    protected $fillable = [
        'title', 'image', 'link_url', 'is_active', 'sort_order', 'posted_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Banner yang tampil di beranda, urut sesuai sort_order.
     */
    public function scopeShown(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->orderBy('sort_order')
            ->latest();
    }
}
