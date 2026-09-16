<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BalanceMutation extends Model
{
    protected $fillable = [
        'user_id',
        'type',                 // credit | debit
        'amount',
        'balance_before',
        'balance_after',
        'reference_type',       // string bebas, mis. 'TopupRequest' / 'ServiceRequest'
        'reference_id',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'balance_before' => 'decimal:2',
            'balance_after' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
