<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Skill;
use Illuminate\Validation\ValidationException;

class LevelUpService
{
    private const MAX_LEVEL = 20;

    /**
     * Levels that grant an attribute boost (+2 distributed freely).
     */
    private const BOOST_LEVELS = [3, 6, 9, 12, 15, 18];

    private const ATTR_KEYS = [
        'strength', 'dexterity', 'constitution',
        'intelligence', 'wisdom', 'charisma',
    ];

    /**
     * Build a summary of what the character gains at the next level.
     * Used by the frontend to display choices before confirming.
     */
    public function preview(Character $character): array
    {
        $nextLevel = $character->level + 1;

        if ($nextLevel > self::MAX_LEVEL) {
            throw ValidationException::withMessages([
                'level' => 'Nível máximo (20) já atingido.',
            ]);
        }

        $class = $character->characterClass;

        $hpGain = $class->hp_per_level + $character->constitution;
        $mpGain = $class->mp_per_level;

        $availablePowers = $this->availablePowers($character);
        $availableSpells = $this->availableSpells($character);

        return [
            'next_level'       => $nextLevel,
            'hp_gain'          => $hpGain,
            'mp_gain'          => $mpGain,
            'needs_attr_boost' => in_array($nextLevel, self::BOOST_LEVELS),
            'available_powers' => $availablePowers,
            'available_spells' => $availableSpells,
            'is_spellcaster'   => (bool) $class->is_spellcaster,
        ];
    }

    /**
     * Apply the level-up to the character.
     */
    public function apply(Character $character, array $data): Character
    {
        $nextLevel = $character->level + 1;

        if ($nextLevel > self::MAX_LEVEL) {
            throw ValidationException::withMessages([
                'level' => 'Nível máximo (20) já atingido.',
            ]);
        }

        $class = $character->characterClass;

        // ── Resources ────────────────────────────────────────────
        $hpGain = $class->hp_per_level + $character->constitution;
        $mpGain = $class->mp_per_level;

        $updates = [
            'level'  => $nextLevel,
            'max_hp' => $character->max_hp + $hpGain,
            'max_mp' => $character->max_mp + $mpGain,
        ];

        // Keep current resources at full if they were full, otherwise keep ratio
        $hpWasFull = ($character->current_hp >= $character->max_hp);
        $mpWasFull = ($character->current_mp >= $character->max_mp);

        $updates['current_hp'] = $hpWasFull
            ? $updates['max_hp']
            : $character->current_hp;

        $updates['current_mp'] = $mpWasFull
            ? $updates['max_mp']
            : $character->current_mp;

        // ── Power choice ─────────────────────────────────────────
        if (!empty($data['power'])) {
            $available = $this->availablePowers($character);
            $names     = array_column($available, 'name');

            if (!in_array($data['power'], $names)) {
                throw ValidationException::withMessages([
                    'power' => 'Poder inválido ou já possuído.',
                ]);
            }

            $powerObj  = collect($available)->firstWhere('name', $data['power']);
            $powers    = $character->powers ?? [];
            $powers[]  = [
                'id'          => (string) \Illuminate\Support\Str::uuid(),
                'name'        => $powerObj['name'],
                'description' => $powerObj['description'] ?? '',
            ];
            $updates['powers'] = $powers;
        }

        // ── Attribute boost ───────────────────────────────────────
        if (in_array($nextLevel, self::BOOST_LEVELS)) {
            $boost = $data['attribute_boost'] ?? null;
            if (empty($boost['primary'])) {
                throw ValidationException::withMessages([
                    'attribute_boost' => 'Escolha um atributo para a melhoria de +2.',
                ]);
            }

            $primary   = $boost['primary'];
            $secondary = $boost['secondary'] ?? null;

            if ($secondary && $secondary === $primary) {
                throw ValidationException::withMessages([
                    'attribute_boost' => 'Escolha dois atributos diferentes para dividir o bônus.',
                ]);
            }

            $updates[$primary] = $character->{$primary} + ($secondary ? 1 : 2);

            if ($secondary) {
                $updates[$secondary] = $character->{$secondary} + 1;
            }

            // Recalculate defense if dexterity changed
            if (in_array('dexterity', array_keys($updates))) {
                $updates['defense'] = 10 + $updates['dexterity'];
            }

            // Recalculate HP if constitution changed
            if (isset($updates['constitution'])) {
                $conDiff = $updates['constitution'] - $character->constitution;
                $updates['max_hp'] += $conDiff * $nextLevel;
                if ($hpWasFull) {
                    $updates['current_hp'] = $updates['max_hp'];
                }
            }
        }

        // ── New trained skill ─────────────────────────────────────
        if (!empty($data['new_skill'])) {
            $this->assertValidSkill($data['new_skill']);

            $trainedSkills = $character->trained_skills ?? [];
            if (!in_array($data['new_skill'], $trainedSkills)) {
                $trainedSkills[]       = $data['new_skill'];
                $updates['trained_skills'] = $trainedSkills;
            }
        }

        // ── New spell ─────────────────────────────────────────────
        if (!empty($data['new_spell'])) {
            $available = $this->availableSpells($character);
            $names     = array_column($available, 'name');

            if (!in_array($data['new_spell'], $names)) {
                throw ValidationException::withMessages([
                    'new_spell' => 'Magia inválida ou já conhecida.',
                ]);
            }

            $spellData = collect($available)->firstWhere('name', $data['new_spell']);
            $spells    = $character->spells ?? [];
            $spells[]  = [
                'id'          => (string) \Illuminate\Support\Str::uuid(),
                'name'        => $spellData['name'],
                'description' => $spellData['description'] ?? '',
                'mp_cost'     => $spellData['mp_cost'] ?? 1,
                'effect_type' => 'utility',
                'damage_dice' => '',
                'damage_bonus' => 0,
            ];
            $updates['spells'] = $spells;
        }

        $character->update($updates);

        return $character->load(['race', 'characterClass', 'origin']);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Garante que a perícia escolhida existe no catálogo
     * (aceita especializações de Ofício/Atuação, ex.: "Ofício (Alquimia)").
     */
    private function assertValidSkill(string $skill): void
    {
        $skill = trim($skill);

        if (Skill::query()->where('name', $skill)->exists()) {
            return;
        }

        $base = trim(preg_replace('/\s*\(.*\)$/', '', $skill));
        $isVariableBase = $base !== $skill
            && Skill::query()->where('name', $base)->where('is_variable', true)->exists();

        if (!$isVariableBase) {
            throw ValidationException::withMessages([
                'new_skill' => "Perícia \"{$skill}\" não existe no catálogo.",
            ]);
        }
    }

    private function availablePowers(Character $character): array
    {
        $all    = $character->characterClass->available_powers ?? [];
        $owned  = collect($character->powers ?? [])->pluck('name')->toArray();

        return array_values(
            array_filter($all, fn($p) => !in_array($p['name'], $owned))
        );
    }

    private function availableSpells(Character $character): array
    {
        if (! $character->characterClass->is_spellcaster) {
            return [];
        }

        $all   = $character->characterClass->available_spells ?? [];
        $owned = collect($character->spells ?? [])->pluck('name')->toArray();

        return array_values(
            array_filter($all, fn($s) => !in_array($s['name'], $owned))
        );
    }
}
