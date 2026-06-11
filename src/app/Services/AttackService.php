<?php

namespace App\Services;

use App\Models\Character;
use App\Models\WeaponCatalog;
use Illuminate\Support\Collection;

class AttackService
{
    /**
     * Penalidade T20 por usar arma sem proficiência.
     */
    private const NON_PROFICIENT_PENALTY = 5;

    private ?Collection $catalogCache = null;

    public function __construct(private readonly SkillService $skillService)
    {
    }

    /**
     * Catálogo de armas indexado por id (cacheado na instância).
     */
    private function catalog(): Collection
    {
        if ($this->catalogCache === null) {
            $this->catalogCache = WeaponCatalog::query()->get()->keyBy('id');
        }

        return $this->catalogCache;
    }

    /**
     * Calcula a linha de ataque de cada arma do personagem.
     *
     * Bônus de ataque (T20):
     *   ⌊nível/2⌋ + mod_atributo + treino(Luta/Pontaria) + bônus_arma
     *   + mod_temporário − penalidade_armadura(à distância) − penalidade_não_proficiente
     *
     * Dano:
     *   dado_arma + mod_Força(1,5× se duas mãos) + bônus_arma + mod_temporário_dano
     *
     * @return array<int, array<string, mixed>>
     */
    public function computeForCharacter(Character $character): array
    {
        $weapons = array_values((array) ($character->weapons ?? []));

        return array_map(
            fn (array $weapon) => $this->computeAttack($character, $weapon),
            array_filter($weapons, 'is_array')
        );
    }

    /**
     * @param array<string, mixed> $weapon
     * @return array<string, mixed>
     */
    private function computeAttack(Character $character, array $weapon): array
    {
        $base = $this->resolveBaseStats($weapon);

        $level     = max(1, (int) $character->total_level);
        $halfLevel = intdiv($level, 2);

        $category     = $base['category'];
        $isRanged     = $category === 'ranged';
        $skillName    = $isRanged ? 'Pontaria' : 'Luta';
        $attackAttr   = $base['attack_attribute'];
        $attrMod      = (int) ($character->{$attackAttr} ?? 0);

        // Treino na perícia de ataque (Luta/Pontaria).
        $trained      = in_array($skillName, (array) ($character->trained_skills ?? []), true);
        $training     = $trained ? $this->skillService->trainingBonusForLevel($level) : 0;

        // Pontaria sofre penalidade de armadura; Luta não.
        $skill        = $this->skillService->findSkill($skillName);
        $armorPenalty = ($skill && $skill->armor_penalty) ? (int) ($character->armor_penalty ?? 0) : 0;

        $weaponAtkBonus = (int) ($weapon['attack_bonus'] ?? 0);
        $tempAtk        = (int) ($character->temp_attack_modifier ?? 0);
        $proficient     = (bool) ($weapon['proficient'] ?? true);
        $profPenalty    = $proficient ? 0 : self::NON_PROFICIENT_PENALTY;

        $attackTotal = $halfLevel + $attrMod + $training + $weaponAtkBonus + $tempAtk
            - $armorPenalty - $profPenalty;

        // ── Dano ───────────────────────────────────────────────────────────
        $strMod = (int) ($character->strength ?? 0);
        $strDamage = 0;
        if ($base['add_strength_damage']) {
            $strDamage = $base['two_handed'] ? (int) floor($strMod * 1.5) : $strMod;
        }

        $weaponDmgBonus = (int) ($weapon['damage_bonus'] ?? 0);
        $tempDmg        = (int) ($character->temp_damage_modifier ?? 0);
        $flatDamage     = $strDamage + $weaponDmgBonus + $tempDmg;

        return [
            'name'           => $weapon['name'] ?? $base['name'] ?? 'Arma',
            'category'       => $category,
            'attack_attribute' => $attackAttr,
            'proficient'     => $proficient,
            'attack_bonus'   => $attackTotal,
            'attack_display' => $this->formatSigned($attackTotal),
            'attack_breakdown' => [
                'half_level'         => $halfLevel,
                'attribute_modifier' => $attrMod,
                'training_bonus'     => $training,
                'weapon_bonus'       => $weaponAtkBonus,
                'temp_modifier'      => $tempAtk,
                'armor_penalty'      => $armorPenalty,
                'proficiency_penalty'=> $profPenalty,
            ],
            'damage'         => $this->formatDamage($base['damage_dice'], $flatDamage),
            'damage_breakdown' => [
                'dice'               => $base['damage_dice'],
                'strength_modifier'  => $strDamage,
                'weapon_bonus'       => $weaponDmgBonus,
                'temp_modifier'      => $tempDmg,
            ],
            'damage_type'    => $base['damage_type'],
            'threat_range'   => $this->formatThreatRange($base['threat_range']),
            'threat_range_min' => $base['threat_range'],
            'crit_multiplier' => 'x' . $base['crit_multiplier'],
            'range'          => $base['range'] ?? ($isRanged ? null : 'Corpo a corpo'),
            'properties'     => $base['properties'],
        ];
    }

    /**
     * Resolve os atributos-base da arma: parte do catálogo (quando há catalog_id)
     * e aplica sobrescritas vindas da instância no personagem.
     *
     * @param array<string, mixed> $weapon
     * @return array<string, mixed>
     */
    private function resolveBaseStats(array $weapon): array
    {
        $catalog = null;
        if (!empty($weapon['catalog_id'])) {
            $catalog = $this->catalog()->get((int) $weapon['catalog_id']);
        }

        $get = function (string $key, $default) use ($weapon, $catalog) {
            if (array_key_exists($key, $weapon) && $weapon[$key] !== null && $weapon[$key] !== '') {
                return $weapon[$key];
            }
            return $catalog?->{$key} ?? $default;
        };

        $category = $get('category', 'melee');

        return [
            'name'                => $catalog->name ?? ($weapon['name'] ?? 'Arma'),
            'category'            => $category,
            'damage_dice'         => $get('damage_dice', '1d4'),
            'damage_type'         => $get('damage_type', 'impacto'),
            'threat_range'        => (int) $get('threat_range', 20),
            'crit_multiplier'     => (int) $get('crit_multiplier', 2),
            'range'               => $get('range', null),
            'attack_attribute'    => $get('attack_attribute', $category === 'ranged' ? 'dexterity' : 'strength'),
            'add_strength_damage' => (bool) $get('add_strength_damage', $category !== 'ranged'),
            'two_handed'          => (bool) $get('two_handed', false),
            'properties'          => $get('properties', []),
        ];
    }

    private function formatSigned(int $value): string
    {
        return ($value >= 0 ? '+' : '') . $value;
    }

    private function formatDamage(string $dice, int $flat): string
    {
        if ($flat === 0) {
            return $dice;
        }

        return $dice . ($flat > 0 ? '+' . $flat : (string) $flat);
    }

    private function formatThreatRange(int $min): string
    {
        return $min >= 20 ? '20' : "{$min}-20";
    }
}
