<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OriginFeature extends Model
{
    protected $fillable = [
        'origin_id',
        'category',
        'name',
        'description',
        'is_unique',
        'sort_order',
    ];

    public function origin(): BelongsTo
    {
        return $this->belongsTo(Origin::class);
    }
}
