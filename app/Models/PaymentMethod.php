<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    protected $fillable = [
        'type',                 // bank_transfer | qris
        'display_name',
        'bank_name',
        'account_number',
        'account_holder_name',
        'qr_image',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function topupRequests(): HasMany
    {
        return $this->hasMany(TopupRequest::class);
    }

    public function isBankTransfer(): bool
    {
        return $this->type === 'bank_transfer';
    }

    public function isQris(): bool
    {
        return $this->type === 'qris';
    }
}
