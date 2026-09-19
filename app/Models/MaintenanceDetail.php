<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceDetail extends Model
{
    protected $fillable = [
        'service_request_id',
        'damage_category',       // label kategori dari repair_pricings, atau "Lainnya"
        'severity',              // ringan | sedang | berat (null untuk "Lainnya")
        'location',
        'description',
        'urgency',               // low | medium | high
    ];

    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function severityLabel(): string
    {
        return $this->severity
            ? (RepairPricing::SEVERITIES[$this->severity] ?? ucfirst($this->severity))
            : '-';
    }
}
