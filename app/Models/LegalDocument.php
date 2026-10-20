<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model
{
    protected $fillable = ['type', 'title', 'summary', 'content', 'version'];

    public static function terms(): self
    {
        return static::where('type', 'terms')->firstOrFail();
    }

    public static function privacy(): self
    {
        return static::where('type', 'privacy')->firstOrFail();
    }
}
