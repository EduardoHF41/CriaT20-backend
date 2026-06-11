<?php

namespace App\Models;

use App\Services\SkillService;
use Illuminate\Database\Eloquent\Model;

class CharacterClass extends Model
{
    /**
     * Quantidade-base de perícias treinadas da classe (sem o modificador de INT).
     */
    protected $appends = ['base_skill_count'];

    protected $fillable = [
        'name', 'description', 'hp_per_level', 'mp_per_level',
        'key_attribute', 'initial_skills', 'initial_skills_data',
        'available_powers', 'powers_at_creation',
        'is_spellcaster', 'spell_school', 'available_spells', 'initial_spells',
        'spell_schools_to_choose', 'magic_tradition', 'spellcasting_attribute',
    ];

    protected $casts = [
        'available_powers'        => 'array',
        'available_spells'        => 'array',
        'initial_skills_data'     => 'array',
        'is_spellcaster'          => 'boolean',
        'powers_at_creation'      => 'integer',
        'initial_spells'          => 'integer',
        'spell_schools_to_choose' => 'integer',
    ];

    public function characters()
    {
        return $this->hasMany(Character::class, 'class_id');
    }

    /**
     * Perícias treinadas concedidas pela classe (fixas + grupos de escolha + livres),
     * antes de somar o modificador de Inteligência.
     */
    public function getBaseSkillCountAttribute(): int
    {
        return app(SkillService::class)->classBaseSkillCount($this);
    }
}