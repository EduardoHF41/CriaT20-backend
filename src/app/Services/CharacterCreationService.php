<?php

namespace App\Services;

use App\Models\CharacterClass;
use App\Models\OriginFeature;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class CharacterCreationService
{
    /**
     * Step model based on T20 creation flow references.
     */
    public function creationSteps(): array
    {
        return [
            ['order' => 1, 'key' => 'attributes', 'title' => 'Defina os atributos'],
            ['order' => 2, 'key' => 'race', 'title' => 'Escolha a raça'],
            ['order' => 3, 'key' => 'class', 'title' => 'Escolha a classe'],
            ['order' => 4, 'key' => 'origin', 'title' => 'Escolha a origem'],
            ['order' => 5, 'key' => 'deity', 'title' => 'Escolha a divindade (opcional)'],
            ['order' => 6, 'key' => 'skills', 'title' => 'Escolha as perícias'],
            ['order' => 7, 'key' => 'equipment', 'title' => 'Anote o equipamento'],
            ['order' => 8, 'key' => 'spells', 'title' => 'Escolha as magias (quando aplicável)'],
            ['order' => 9, 'key' => 'finalize', 'title' => 'Toques finais e fechamento'],
        ];
    }

    public function validateAttributes(array $data): void
    {
        $attributes = [
            (int) $data['strength'],
            (int) $data['dexterity'],
            (int) $data['constitution'],
            (int) $data['intelligence'],
            (int) $data['wisdom'],
            (int) $data['charisma'],
        ];

        if ($data['attribute_method'] === 'point_buy') {
            $this->validatePointBuy($attributes);

            return;
        }

        $this->validateRolled($attributes);
    }

    public function validateOriginBenefits(int $originId, array $benefits = []): void
    {
        if (empty($benefits)) {
            return;
        }

        $validBenefits = OriginFeature::query()
            ->where('origin_id', $originId)
            ->whereIn('category', ['skill', 'power'])
            ->pluck('name')
            ->toArray();

        $invalid = array_values(array_diff($benefits, $validBenefits));

        if (!empty($invalid)) {
            throw ValidationException::withMessages([
                'origin_benefits' => 'Benefícios de origem inválidos: ' . implode(', ', $invalid),
            ]);
        }

        if (count($benefits) > 2) {
            throw ValidationException::withMessages([
                'origin_benefits' => 'Você pode selecionar no máximo dois benefícios de origem.',
            ]);
        }
    }

    /**
     * Calcula PV e PM totais conforme as regras do Tormenta 20.
     *
     * Fórmula T20:
     *   PV total = (hp_per_level + modificador_Con) × nível
     *   PM total =  mp_per_level × nível
     *
     * hp_per_level e mp_per_level vêm da coluna correspondente em character_classes
     * (previamente preenchida pelo ClassSeeder com dados da Tabela 1-3 do livro).
     */
    public function calculateResources(int $classId, int $level, int $constitution): array
    {
        $class = CharacterClass::query()->findOrFail($classId);
        $safeLevel = max(1, $level);

        $maxHp = ($class->hp_per_level + $constitution) * $safeLevel;
        $maxMp = $class->mp_per_level * $safeLevel;

        return [
            'class'   => $class->name,
            'level'   => $safeLevel,
            'max_hp'  => max(1, $maxHp),
            'max_mp'  => max(0, $maxMp),
        ];
    }

    /**
     * Calcula PV/PM/nível total para personagens multiclasse.
     *
     * Regras T20:
     *   PV total = Σ(hp_per_level_classe × nível_na_classe) + (modificador_Con × nível_total)
     *   PM total = Σ(mp_per_level_classe × nível_na_classe)
     *   Nível total = Σ(nível_na_classe)
     *
     * @param array<int, array{class_id:int, level:int}> $classes
     */
    public function calculateMulticlassResources(array $classes, int $constitution): array
    {
        $totalLevel = 0;
        $hpFromClasses = 0;
        $maxMp = 0;
        $breakdown = [];

        foreach ($classes as $entry) {
            $class = CharacterClass::query()->findOrFail((int) $entry['class_id']);
            $classLevel = max(1, (int) $entry['level']);

            $totalLevel    += $classLevel;
            $hpFromClasses += $class->hp_per_level * $classLevel;
            $maxMp         += $class->mp_per_level * $classLevel;

            $breakdown[] = [
                'class_id' => $class->id,
                'class'    => $class->name,
                'level'    => $classLevel,
            ];
        }

        $maxHp = $hpFromClasses + ($constitution * $totalLevel);

        return [
            'total_level' => max(1, $totalLevel),
            'max_hp'      => max(1, $maxHp),
            'max_mp'      => max(0, $maxMp),
            'classes'     => $breakdown,
        ];
    }

    /**
     * Valida e converte nomes de magias para objetos completos.
     * Verifica se pertencem à classe, não excedem o limite inicial e retorna
     * os objetos prontos para persistência.
     */
    public function resolveInitialSpells(int $classId, array $spellNames): array
    {
        if (empty($spellNames)) {
            return [];
        }

        $class = CharacterClass::query()->findOrFail($classId);

        if (!$class->is_spellcaster) {
            throw ValidationException::withMessages([
                'spells' => 'Esta classe não é conjuradora e não pode selecionar magias.',
            ]);
        }

        $available = collect($class->available_spells ?? []);
        $limit     = (int) $class->initial_spells;

        if (count($spellNames) > $limit) {
            throw ValidationException::withMessages([
                'spells' => "Esta classe começa com no máximo {$limit} magia(s).",
            ]);
        }

        $resolved = [];
        foreach ($spellNames as $name) {
            $spell = $available->firstWhere('name', $name);
            if (!$spell) {
                throw ValidationException::withMessages([
                    'spells' => "Magia \"{$name}\" não pertence às magias disponíveis desta classe.",
                ]);
            }
            $resolved[] = [
                'id'          => (string) Str::uuid(),
                'name'        => $spell['name'],
                'description' => $spell['description'],
                'mp_cost'     => (int) $spell['mp_cost'],
                'effect_type' => 'utility',
                'damage_dice' => '',
                'damage_bonus'=> 0,
            ];
        }

        return $resolved;
    }

    /**
     * Valida e converte nomes de poderes para objetos completos.
     */
    public function resolveInitialPowers(int $classId, array $powerNames): array
    {
        if (empty($powerNames)) {
            return [];
        }

        $class = CharacterClass::query()->findOrFail($classId);
        $available = collect($class->available_powers ?? []);
        $limit     = (int) $class->powers_at_creation;

        if (count($powerNames) > $limit) {
            throw ValidationException::withMessages([
                'powers' => "Esta classe começa com no máximo {$limit} poder(es).",
            ]);
        }

        $resolved = [];
        foreach ($powerNames as $name) {
            $power = $available->firstWhere('name', $name);
            if (!$power) {
                throw ValidationException::withMessages([
                    'powers' => "Poder \"{$name}\" não pertence aos poderes disponíveis desta classe.",
                ]);
            }
            $resolved[] = [
                'id'          => (string) Str::uuid(),
                'name'        => $power['name'],
                'description' => $power['description'],
            ];
        }

        return $resolved;
    }

    private function validatePointBuy(array $attributes): void
    {
        $costMap = [-1 => -1, 0 => 0, 1 => 1, 2 => 2, 3 => 4, 4 => 7];

        $cost = 0;

        foreach ($attributes as $attribute) {
            if ($attribute < -1 || $attribute > 4 || !array_key_exists($attribute, $costMap)) {
                throw ValidationException::withMessages([
                    'attributes' => 'No método por pontos, os atributos devem ficar entre -1 e 4.',
                ]);
            }

            $cost += $costMap[$attribute];
        }

        if ($cost > 10) {
            throw ValidationException::withMessages([
                'attributes' => 'Distribuição inválida: custo total por pontos excede 10.',
            ]);
        }
    }

    private function validateRolled(array $attributes): void
    {
        foreach ($attributes as $attribute) {
            if ($attribute < -2 || $attribute > 4) {
                throw ValidationException::withMessages([
                    'attributes' => 'No método por rolagem, os atributos devem ficar entre -2 e 4.',
                ]);
            }
        }

        if (array_sum($attributes) < 6) {
            throw ValidationException::withMessages([
                'attributes' => 'Distribuição inválida: soma de atributos por rolagem deve ser pelo menos 6.',
            ]);
        }
    }
}
