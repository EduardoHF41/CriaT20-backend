<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deity extends Model
{
    protected $fillable = [
        'name',
        'title',
        'description',
        'obligations',
        'restrictions',
        'granted_powers',
        'devout_weapons',
        'is_homebrew',
    ];

    protected $casts = [
        'obligations'    => 'array',
        'restrictions'   => 'array',
        'granted_powers' => 'array',
        'devout_weapons' => 'array',
        'is_homebrew'    => 'boolean',
    ];

    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}
