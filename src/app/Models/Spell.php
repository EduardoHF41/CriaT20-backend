<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spell extends Model
{
    protected $fillable = [
        'name',
        'tradition',
        'school',
        'circle',
        'mp_cost',
        'execution',
        'range',
        'target_area',
        'duration',
        'resistance',
        'description',
        'enhancements',
    ];

    protected $casts = [
        'circle'       => 'integer',
        'mp_cost'      => 'integer',
        'enhancements' => 'array',
    ];
}
