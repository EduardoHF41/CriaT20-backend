<?php

namespace App\Services;

use App\Models\Character;
use App\Models\Spell;
use Illuminate\Validation\ValidationException;

class SpellService
{
    /**
     * Calcula a Classe de Dificuldade (CD) das magias do personagem.
     *
     * Fórmula T20: CD = 10 + ½ nível + modificador do atributo-chave de conjuração.
     * Retorna null se a classe não for conjuradora.
     *
     * @return array{value:int, attribute:string, tradition:?string, breakdown:array}|null
     */
    public function spellDc(Character $character): ?array
    {
        $class = $character->characterClass;

        if (!$class || !$class->is_spellcaster) {
            return null;
        }

        $attribute = $class->spellcasting_attribute;
        if (!$attribute) {
            return null;
        }

        $level    = max(1, (int) $character->total_level);
        $halfLevel = intdiv($level, 2);
        $attrMod  = (int) ($character->{$attribute} ?? 0);

        return [
            'value'     => 10 + $halfLevel + $attrMod,
            'attribute' => $attribute,
            'tradition' => $class->magic_tradition,
            'breakdown' => [
                'base'               => 10,
                'half_level'         => $halfLevel,
                'attribute_modifier' => $attrMod,
            ],
        ];
    }

    /**
     * Custo total de uma conjuração: custo base + aprimoramentos selecionados.
     *
     * @param array<int, int> $enhancementIndexes índices dos aprimoramentos escolhidos
     * @return array{base:int, enhancements:int, total:int}
     */
    public function castingCost(Spell $spell, array $enhancementIndexes = []): array
    {
        $enhancements = $spell->enhancements ?? [];
        $extra = 0;

        foreach ($enhancementIndexes as $i) {
            if (!isset($enhancements[$i])) {
                throw ValidationException::withMessages([
                    'enhancements' => "Aprimoramento inválido (índice {$i}) para a magia \"{$spell->name}\".",
                ]);
            }
            $extra += (int) ($enhancements[$i]['cost'] ?? 0);
        }

        $base = (int) $spell->mp_cost;

        return [
            'base'         => $base,
            'enhancements' => $extra,
            'total'        => $base + $extra,
        ];
    }

    /**
     * Verifica se o personagem tem PM para conjurar (sem deduzir).
     * Gera o "alerta de PM excedido" quando o custo supera o PM atual.
     *
     * @return array{cost:int, current_mp:int, remaining:int, can_cast:bool, alert:?string}
     */
    public function castPreview(Character $character, int $cost): array
    {
        $current = (int) $character->current_mp;
        $canCast = $cost <= $current;

        return [
            'cost'       => $cost,
            'current_mp' => $current,
            'remaining'  => $current - $cost,
            'can_cast'   => $canCast,
            'alert'      => $canCast
                ? null
                : "PM insuficiente: a conjuração custa {$cost} PM, mas você tem apenas {$current} PM.",
        ];
    }

    /**
     * Conjura: deduz o PM do personagem. Bloqueia se não houver PM suficiente.
     *
     * @return array{spent:int, current_mp:int, alert:?string}
     */
    public function cast(Character $character, int $cost): array
    {
        $preview = $this->castPreview($character, $cost);

        if (!$preview['can_cast']) {
            throw ValidationException::withMessages([
                'mp' => $preview['alert'],
            ]);
        }

        $character->update(['current_mp' => $preview['remaining']]);

        return [
            'spent'      => $cost,
            'current_mp' => $preview['remaining'],
            'alert'      => null,
        ];
    }
}
