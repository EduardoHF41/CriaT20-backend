<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Power extends Model
{
    protected $fillable = [
        'name',
        'type',
        'category',
        'race_id',
        'prerequisites',
        'description',
    ];

    protected $casts = [
        'prerequisites' => 'array',
    ];

    public function race()
    {
        return $this->belongsTo(Race::class);
    }
}
