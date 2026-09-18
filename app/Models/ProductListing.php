<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductListing extends Model
{
    protected $fillable = [
        'posted_by',
        'title',
        'description',
        'price',
        'image',
        'category',
        'contact_info',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function postedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    /**
     * Link wa.me dengan pesan otomatis (judul, harga, kategori, deskripsi, link gambar).
     * Nomor diambil dari contact_info yang diinput admin.
     * Pemakaian di Blade: $listing->whatsapp_url
     */
    protected function whatsappUrl(): Attribute
    {
        return Attribute::get(function () {
            $number = preg_replace('/\D+/', '', (string) $this->contact_info);

            if (strlen($number) < 8) {
                return null;
            }

            // Normalisasi ke format internasional Indonesia: 08xx / 8xx -> 628xx
            if (str_starts_with($number, '0')) {
                $number = '62' . substr($number, 1);
            } elseif (str_starts_with($number, '8')) {
                $number = '62' . $number;
            }

            $lines = [
                'Halo, saya tertarik dengan produk ini:',
                '',
                '*' . $this->title . '*',
            ];

            if ((float) $this->price > 0) {
                $lines[] = 'Harga: Rp' . number_format($this->price, 0, ',', '.');
            }

            if ($this->category) {
                $lines[] = 'Kategori: ' . $this->category;
            }

            if ($this->description) {
                $lines[] = 'Deskripsi: ' . Str::limit($this->description, 200);
            }

            if ($this->image) {
                // Link gambar di baris sendiri supaya WhatsApp menampilkan pratinjau gambarnya
                $lines[] = '';
                $lines[] = url(Storage::url($this->image));
            }

            return 'https://wa.me/' . $number . '?text=' . rawurlencode(implode("\n", $lines));
        });
    }
}
