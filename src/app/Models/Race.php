<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $fillable = ['name', 'description', 'attribute_modifiers'];

    protected $casts = [
        'attribute_modifiers' => 'array',
    ];

    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}