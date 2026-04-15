<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = [
        'name',
        'avatar_url',
        'level',
        'deity',
        'concept',
        'attribute_method',
        'strength',
        'dexterity',
        'constitution',
        'intelligence',
        'wisdom',
        'charisma',
        'origin_benefits',
        'trained_skills',
        'powers',
        'equipment',
        'spells',
        'weapons',
        'max_hp',
        'max_mp',
        'current_hp',
        'current_mp',
        'defense',
        'size',
        'displacement',
        'money_gold',
        'money_silver',
        'money_copper',
        'race_id',
        'class_id',
        'origin_id',
        'user_id',
    ];

    protected $casts = [
        'origin_benefits' => 'array',
        'trained_skills'  => 'array',
        'powers'          => 'array',
        'equipment'       => 'array',
        'spells'          => 'array',
        'weapons'         => 'array',
    ];

    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function characterClass()
    {
        return $this->belongsTo(CharacterClass::class, 'class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function origin()
    {
        return $this->belongsTo(Origin::class);
    }
}