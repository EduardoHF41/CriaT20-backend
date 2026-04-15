<?php

namespace App\Services;

use App\Models\CharacterClass;
use App\Models\OriginFeature;
use Illuminate\Validation\ValidationException;

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
