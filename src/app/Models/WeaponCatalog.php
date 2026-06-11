<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeaponCatalog extends Model
{
    protected $table = 'weapons_catalog';

    protected $fillable = [
        'name',
        'category',
        'proficiency',
        'damage_dice',
        'damage_type',
        'threat_range',
        'crit_multiplier',
        'range',
        'attack_attribute',
        'add_strength_damage',
        'two_handed',
        'properties',
        'description',
    ];

    protected $casts = [
        'threat_range'        => 'integer',
        'crit_multiplier'     => 'integer',
        'add_strength_damage' => 'boolean',
        'two_handed'          => 'boolean',
        'properties'          => 'array',
    ];
}
