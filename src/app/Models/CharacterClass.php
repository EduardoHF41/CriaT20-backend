<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterClass extends Model
{
    protected $fillable = [
        'name', 'description', 'hp_per_level', 'mp_per_level',
        'key_attribute', 'initial_skills',
        'available_powers', 'powers_at_creation',
        'is_spellcaster', 'spell_school', 'available_spells', 'initial_spells',
    ];

    protected $casts = [
        'available_powers'   => 'array',
        'available_spells'   => 'array',
        'is_spellcaster'     => 'boolean',
        'powers_at_creation' => 'integer',
        'initial_spells'     => 'integer',
    ];

    public function characters()
    {
        return $this->hasMany(Character::class, 'class_id');
    }
}