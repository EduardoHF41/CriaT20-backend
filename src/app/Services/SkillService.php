<?php

namespace App\Services;

use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Skill;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class SkillService
{
    /**
     * Cache do catálogo de perícias por requisição, para evitar
     * múltiplas queries quando o accessor é serializado várias vezes.
     */
    private ?Collection $catalogCache = null;

    /**
     * Retorna o catálogo completo de perícias (cacheado na instância).
     */
    public function catalog(): Collection
    {
        if ($this->catalogCache === null) {
            $this->catalogCache = Skill::query()->orderBy('name')->get();
        }

        return $this->catalogCache;
    }

    /**
     * Busca uma perícia pelo nome no catálogo (usando o cache da instância).
     */
    public function findSkill(string $name): ?Skill
    {
        return $this->catalog()->firstWhere('name', $name);
    }

    /**
     * Bônus de treinamento conforme o nível (Tormenta 20):
     *   níveis  1–6  → +2
     *   níveis  7–14 → +4
     *   níveis 15–20 → +6
     */
    public function trainingBonusForLevel(int $level): int
    {
        if ($level >= 15) {
            return 6;
        }

        if ($level >= 7) {
            return 4;
        }

        return 2;
    }

    /**
     * Calcula o bloco completo de perícias de um personagem.
     *
     * Fórmula T20:
     *   total = ⌊nível/2⌋ + mod_atributo + bônus_treino + bônus_variado − penalidade_armadura
     *
     * @return array<int, array<string, mixed>>
     */
    public function computeForCharacter(Character $character): array
    {
        $level        = max(1, (int) $character->total_level);
        $halfLevel    = intdiv($level, 2);
        $trainBonus   = $this->trainingBonusForLevel($level);
        $armorPenalty = (int) ($character->armor_penalty ?? 0);

        $trained     = array_values((array) ($character->trained_skills ?? []));
        $miscBonuses = (array) ($character->skill_bonuses ?? []);

        $result = [];

        foreach ($this->catalog() as $skill) {
            if ($skill->is_variable) {
                // Perícias variáveis (Ofício, Atuação): uma entrada por especialização treinada.
                $specs = $this->trainedSpecializations($skill->name, $trained);

                if (empty($specs)) {
                    // Nenhuma especialização treinada → entrada-base não treinada.
                    $result[] = $this->buildEntry(
                        $skill, $skill->name, false,
                        $character, $halfLevel, $trainBonus, $armorPenalty, $miscBonuses
                    );
                    continue;
                }

                foreach ($specs as $label) {
                    $result[] = $this->buildEntry(
                        $skill, $label, true,
                        $character, $halfLevel, $trainBonus, $armorPenalty, $miscBonuses
                    );
                }

                continue;
            }

            $isTrained = in_array($skill->name, $trained, true);

            $result[] = $this->buildEntry(
                $skill, $skill->name, $isTrained,
                $character, $halfLevel, $trainBonus, $armorPenalty, $miscBonuses
            );
        }

        return $result;
    }

    /**
     * Monta a entrada calculada de uma perícia.
     *
     * @param array<string, int> $miscBonuses
     * @return array<string, mixed>
     */
    private function buildEntry(
        Skill $skill,
        string $label,
        bool $isTrained,
        Character $character,
        int $halfLevel,
        int $trainBonus,
        int $armorPenalty,
        array $miscBonuses
    ): array {
        $attrMod = (int) ($character->{$skill->key_attribute} ?? 0);
        $training = $isTrained ? $trainBonus : 0;
        $misc     = (int) ($miscBonuses[$label] ?? $miscBonuses[$skill->name] ?? 0);
        $penalty  = $skill->armor_penalty ? $armorPenalty : 0;

        // "Somente treinada" não treinada não pode ser usada.
        $usable = !$skill->trained_only || $isTrained;

        $total = $halfLevel + $attrMod + $training + $misc - $penalty;

        return [
            'skill'              => $label,
            'base_skill'         => $skill->name,
            'key_attribute'      => $skill->key_attribute,
            'trained'            => $isTrained,
            'trained_only'       => $skill->trained_only,
            'is_variable'        => $skill->is_variable,
            'usable'             => $usable,
            'half_level'         => $halfLevel,
            'attribute_modifier' => $attrMod,
            'training_bonus'     => $training,
            'misc_bonus'         => $misc,
            'armor_penalty'      => $penalty,
            'total'              => $usable ? $total : null,
        ];
    }

    /**
     * Extrai as especializações treinadas de uma perícia variável.
     * Reconhece "Ofício" (base) e "Ofício (Alquimia)" (especializada).
     *
     * @param array<int, string> $trained
     * @return array<int, string>
     */
    private function trainedSpecializations(string $baseName, array $trained): array
    {
        $labels = [];

        foreach ($trained as $entry) {
            $entry = trim($entry);
            if ($entry === $baseName || str_starts_with($entry, $baseName . ' (')) {
                $labels[] = $entry;
            }
        }

        return array_values(array_unique($labels));
    }

    /**
     * Limite de perícias treinadas na criação = base da classe + modificador de Inteligência.
     *
     * A base da classe vem de initial_skills_data:
     *   nº de perícias fixas + nº de grupos de escolha + free_count
     */
    public function creationSkillLimit(CharacterClass $class, int $intelligenceModifier): int
    {
        $base = $this->classBaseSkillCount($class);

        return $base + max(0, $intelligenceModifier);
    }

    /**
     * Número de perícias treinadas concedidas pela classe (sem o modificador de INT).
     */
    public function classBaseSkillCount(CharacterClass $class): int
    {
        $data = $class->initial_skills_data ?? [];

        $fixed     = count($data['fixed'] ?? []);
        $orGroups  = count($data['or_groups'] ?? []);
        $freeCount = (int) ($data['free_count'] ?? 0);

        return $fixed + $orGroups + $freeCount;
    }

    /**
     * Valida a seleção de perícias treinadas na criação do personagem.
     *
     * Regras verificadas:
     *   - todos os nomes existem no catálogo (especializações de Ofício/Atuação são aceitas);
     *   - a quantidade não excede o limite da classe + INT (+ perícias concedidas pela origem).
     *
     * @param array<int, string> $trainedSkills
     */
    public function validateSkillSelection(
        CharacterClass $class,
        array $trainedSkills,
        int $intelligenceModifier,
        int $originSkillGrants = 0
    ): void {
        if (empty($trainedSkills)) {
            return;
        }

        $catalog        = $this->catalog();
        $names          = $catalog->pluck('name')->all();
        $variableNames  = $catalog->where('is_variable', true)->pluck('name')->all();

        $invalid = [];
        foreach ($trainedSkills as $entry) {
            if (!$this->isKnownSkill($entry, $names, $variableNames)) {
                $invalid[] = $entry;
            }
        }

        if (!empty($invalid)) {
            throw ValidationException::withMessages([
                'trained_skills' => 'Perícias inválidas: ' . implode(', ', $invalid),
            ]);
        }

        $limit = $this->creationSkillLimit($class, $intelligenceModifier) + max(0, $originSkillGrants);

        if (count($trainedSkills) > $limit) {
            throw ValidationException::withMessages([
                'trained_skills' => "Você pode treinar no máximo {$limit} perícia(s) "
                    . '(base da classe + modificador de Inteligência).',
            ]);
        }
    }

    /**
     * Verifica se um nome de perícia (com ou sem especialização) é válido.
     *
     * @param array<int, string> $names
     * @param array<int, string> $variableNames
     */
    private function isKnownSkill(string $entry, array $names, array $variableNames): bool
    {
        $entry = trim($entry);

        if (in_array($entry, $names, true)) {
            return true;
        }

        // Especializações: "Ofício (Alquimia)", "Atuação (Dança)".
        foreach ($variableNames as $base) {
            if (str_starts_with($entry, $base . ' (') && str_ends_with($entry, ')')) {
                return true;
            }
        }

        return false;
    }
}
