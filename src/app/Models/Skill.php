<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'key_attribute',
        'trained_only',
        'armor_penalty',
        'is_variable',
        'description',
    ];

    protected $casts = [
        'trained_only'  => 'boolean',
        'armor_penalty' => 'boolean',
        'is_variable'   => 'boolean',
    ];
}
