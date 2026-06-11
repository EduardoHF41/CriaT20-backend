<?php

namespace App\Services;

use App\Models\Character;

class InventoryService
{
    /**
     * Carga máxima em espaços (regra T20): 10 + Força.
     */
    public function maxLoad(Character $character): int
    {
        return 10 + (int) ($character->strength ?? 0);
    }

    /**
     * Resumo completo de inventário e carga do personagem.
     *
     * Status de peso:
     *   Leve       → carga ≤ ½ do limite
     *   Pesado     → carga ≤ limite
     *   Sobrecarga → carga > limite (impõe penalidades)
     *
     * @return array<string, mixed>
     */
    public function summary(Character $character): array
    {
        $items = array_values(array_filter((array) ($character->equipment ?? []), 'is_array'));

        $used = 0.0;
        $equipped = [];
        $backpack = [];
        $consumables = [];

        foreach ($items as $item) {
            $quantity = max(1, (int) ($item['quantity'] ?? 1));
            $spaces   = (float) ($item['spaces'] ?? 1);
            $used    += $spaces * $quantity;

            if (($item['type'] ?? null) === 'consumable') {
                $consumables[] = $item;
            }

            if (!empty($item['equipped'])) {
                $equipped[] = $item;
            } else {
                $backpack[] = $item;
            }
        }

        $max    = $this->maxLoad($character);
        $used   = round($used, 1);
        $status = $this->loadStatus($used, $max);

        return [
            'max_load'     => $max,
            'used_load'    => $used,
            'free_load'    => round($max - $used, 1),
            'status'       => $status,
            'overloaded'   => $status === 'sobrecarga',
            'penalty'      => $status === 'sobrecarga'
                ? '−5 em testes de Força e Destreza e deslocamento reduzido à metade.'
                : null,
            'equipped'     => $equipped,
            'backpack'     => $backpack,
            'consumables'  => $consumables,
        ];
    }

    private function loadStatus(float $used, int $max): string
    {
        if ($used > $max) {
            return 'sobrecarga';
        }

        if ($used > $max / 2) {
            return 'pesado';
        }

        return 'leve';
    }
}
