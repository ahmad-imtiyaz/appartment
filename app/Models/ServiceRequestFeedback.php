<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequestFeedback extends Model
{
    protected $table = 'service_request_feedbacks';
    protected $fillable = [
        'service_request_id',
        'worker_id',
        'user_id',                // guest pemberi feedback
        'rating',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
