<?php

namespace App\Models;

use App\Services\AttackService;
use App\Services\InventoryService;
use App\Services\SkillService;
use App\Services\SpellService;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    /**
     * Perícias, ataques, poderes raciais e CD de magia são anexados automaticamente.
     */
    protected $appends = ['skills', 'attacks', 'racial_powers', 'spell_dc', 'inventory'];

    protected $fillable = [
        'name',
        'nickname',
        'gender',
        'age',
        'height',
        'weight',
        'avatar_url',
        'level',
        'deity',
        'deity_id',
        'deity_obligations',
        'concept',
        'background',
        'personality_traits',
        'attribute_method',
        'strength',
        'dexterity',
        'constitution',
        'intelligence',
        'wisdom',
        'charisma',
        'origin_benefits',
        'racial_flex_choices',
        'racial_subtype',
        'trained_skills',
        'armor_penalty',
        'skill_bonuses',
        'temp_attack_modifier',
        'temp_damage_modifier',
        'extra_attacks',
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
        'campaign_id',
        'chosen_spell_school',
        'chosen_spell_schools',
    ];

    protected $casts = [
        'deity_obligations'    => 'array',
        'origin_benefits'      => 'array',
        'racial_flex_choices'  => 'array',
        'trained_skills'          => 'array',
        'skill_bonuses'           => 'array',
        'chosen_spell_schools'    => 'array',
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

    public function deityRelation()
    {
        return $this->belongsTo(Deity::class, 'deity_id');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Classes do personagem com o nível em cada uma (multiclasse).
     */
    public function classes()
    {
        return $this->belongsToMany(CharacterClass::class, 'character_class_levels')
            ->withPivot('level')
            ->withTimestamps();
    }

    /**
     * Nível total = soma dos níveis de todas as classes.
     * Faz fallback para a coluna `level` quando não há registros de multiclasse.
     */
    public function getTotalLevelAttribute(): int
    {
        $sum = (int) $this->classes->sum('pivot.level');

        return $sum > 0 ? $sum : (int) $this->level;
    }

    /**
     * Perícias calculadas (½ nível + mod + treino + bônus − penalidade de armadura).
     * Exposto automaticamente via $appends.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getSkillsAttribute(): array
    {
        return app(SkillService::class)->computeForCharacter($this);
    }

    /**
     * Ataques calculados a partir das armas do personagem
     * (bônus de ataque, dano, margem de ameaça, crítico etc.).
     * Exposto automaticamente via $appends.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAttacksAttribute(): array
    {
        return app(AttackService::class)->computeForCharacter($this);
    }

    /**
     * Poderes raciais do personagem, derivados da raça.
     * Exposto automaticamente via $appends.
     */
    public function getRacialPowersAttribute()
    {
        if (!$this->race_id) {
            return [];
        }

        return Power::query()
            ->where('type', 'racial')
            ->where('race_id', $this->race_id)
            ->orderBy('name')
            ->get(['id', 'name', 'description', 'prerequisites']);
    }

    /**
     * CD das magias (10 + ½ nível + atributo-chave). Null se não for conjurador.
     * Exposto automaticamente via $appends.
     */
    public function getSpellDcAttribute(): ?array
    {
        return app(SpellService::class)->spellDc($this);
    }

    /**
     * Resumo de inventário e carga (limite, status Leve/Pesado/Sobrecarga,
     * separação equipados/mochila/consumíveis). Exposto via $appends.
     */
    public function getInventoryAttribute(): array
    {
        return app(InventoryService::class)->summary($this);
    }
}