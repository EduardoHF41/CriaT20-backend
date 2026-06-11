<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Power;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PowerService
{
    /**
     * Avalia cada pré-requisito de um poder contra o personagem.
     *
     * @return array{met: bool, requirements: array<int, array{type:string, label:string, met:bool}>}
     */
    public function checkPrerequisites(Character $character, Power $power): array
    {
        $prereq = $power->prerequisites ?? [];
        $requirements = [];

        // Nível mínimo
        if (!empty($prereq['min_level'])) {
            $min = (int) $prereq['min_level'];
            $requirements[] = [
                'type'  => 'level',
                'label' => "Nível {$min}",
                'met'   => (int) $character->total_level >= $min,
            ];
        }

        // Atributos
        foreach ($prereq['attributes'] ?? [] as $attr => $value) {
            $requirements[] = [
                'type'  => 'attribute',
                'label' => ucfirst($attr) . ' ' . (int) $value,
                'met'   => (int) ($character->{$attr} ?? 0) >= (int) $value,
            ];
        }

        // Perícias treinadas
        $trained = (array) ($character->trained_skills ?? []);
        foreach ($prereq['skills'] ?? [] as $skill) {
            $requirements[] = [
                'type'  => 'skill',
                'label' => "Treinado em {$skill}",
                'met'   => $this->hasTrainedSkill($skill, $trained),
            ];
        }

        // Poderes pré-requisito
        $ownedPowers = $this->ownedPowerNames($character);
        foreach ($prereq['powers'] ?? [] as $requiredPower) {
            $requirements[] = [
                'type'  => 'power',
                'label' => "Poder: {$requiredPower}",
                'met'   => in_array($requiredPower, $ownedPowers, true),
            ];
        }

        // Divindade
        if (!empty($prereq['deity'])) {
            $deity = $prereq['deity'];
            $requirements[] = [
                'type'  => 'deity',
                'label' => "Devoto de {$deity}",
                'met'   => $this->worshipsDeity($character, $deity),
            ];
        }

        // Requisito descritivo (não verificável automaticamente — sempre exibido)
        if (!empty($prereq['text'])) {
            $requirements[] = [
                'type'  => 'text',
                'label' => $prereq['text'],
                'met'   => true,
            ];
        }

        $met = collect($requirements)->every(fn ($r) => $r['met']);

        return ['met' => $met, 'requirements' => $requirements];
    }

    /**
     * Lança ValidationException se o personagem não cumprir os pré-requisitos.
     */
    public function validatePrerequisites(Character $character, Power $power): void
    {
        $check = $this->checkPrerequisites($character, $power);

        if ($check['met']) {
            return;
        }

        $unmet = collect($check['requirements'])
            ->where('met', false)
            ->pluck('label')
            ->implode(', ');

        throw ValidationException::withMessages([
            'power' => "Pré-requisitos não atendidos para \"{$power->name}\": {$unmet}.",
        ]);
    }

    /**
     * Adiciona um poder do catálogo ao personagem (validando pré-requisitos).
     */
    public function attachPower(Character $character, Power $power, ?string $notes = null): Character
    {
        $this->validatePrerequisites($character, $power);

        $powers = $character->powers ?? [];

        if (in_array($power->name, array_column($powers, 'name'), true)) {
            throw ValidationException::withMessages([
                'power' => "O personagem já possui o poder \"{$power->name}\".",
            ]);
        }

        $powers[] = [
            'id'          => (string) Str::uuid(),
            'power_id'    => $power->id,
            'name'        => $power->name,
            'type'        => $power->type,
            'category'    => $power->category,
            'description' => $power->description,
            'notes'       => $notes,
        ];

        $character->update(['powers' => $powers]);

        return $character;
    }

    /**
     * Remove um poder do personagem pelo id da instância.
     */
    public function detachPower(Character $character, string $instanceId): Character
    {
        $powers = array_values(array_filter(
            $character->powers ?? [],
            fn ($p) => ($p['id'] ?? null) !== $instanceId
        ));

        $character->update(['powers' => $powers]);

        return $character;
    }

    /**
     * Atualiza a nota de um poder do personagem.
     */
    public function updateNotes(Character $character, string $instanceId, ?string $notes): Character
    {
        $powers = $character->powers ?? [];
        $found = false;

        foreach ($powers as &$p) {
            if (($p['id'] ?? null) === $instanceId) {
                $p['notes'] = $notes;
                $found = true;
                break;
            }
        }
        unset($p);

        if (!$found) {
            throw ValidationException::withMessages([
                'power' => 'Poder não encontrado neste personagem.',
            ]);
        }

        $character->update(['powers' => $powers]);

        return $character;
    }

    /**
     * @param array<int, string> $trained
     */
    private function hasTrainedSkill(string $skill, array $trained): bool
    {
        foreach ($trained as $entry) {
            $entry = trim($entry);
            if ($entry === $skill || str_starts_with($entry, $skill . ' (')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Nomes de todos os poderes do personagem (catálogo de classe + adquiridos + raciais).
     *
     * @return array<int, string>
     */
    private function ownedPowerNames(Character $character): array
    {
        $names = collect($character->powers ?? [])->pluck('name')->all();

        // Poderes raciais contam como poderes possuídos para pré-requisitos.
        $racial = Power::query()
            ->where('type', 'racial')
            ->where('race_id', $character->race_id)
            ->pluck('name')
            ->all();

        return array_values(array_unique(array_merge($names, $racial)));
    }

    private function worshipsDeity(Character $character, string $deity): bool
    {
        if (is_string($character->deity) && trim($character->deity) === $deity) {
            return true;
        }

        return optional($character->deityRelation)->name === $deity;
    }
}
