<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeaponCatalogSeeder extends Seeder
{
    /**
     * Tabela de Armas do Tormenta 20 (subconjunto representativo).
     *
     * Colunas:
     * [name, category, proficiency, damage_dice, damage_type, threat_range,
     *  crit_multiplier, range, attack_attribute, add_strength_damage, two_handed, properties]
     *
     * threat_range: menor valor que ameaça crítico (20 = só 20; 19 = 19-20; 18 = 18-20).
     * Armas "Ágil" mantêm attack_attribute='strength' por padrão; o personagem pode
     * sobrescrever para 'dexterity' na instância da arma.
     */
    public function run(): void
    {
        $now = now();

        $weapons = [
            // ── Simples corpo a corpo ──────────────────────────────────────────
            ['Adaga',           'melee', 'simples', '1d4',  'perfuração', 19, 2, null, 'strength', true,  false, ['Ágil', 'Arremesso']],
            ['Bordão',          'melee', 'simples', '1d6',  'impacto',    20, 2, null, 'strength', true,  true,  ['Duas Mãos']],
            ['Clava',           'melee', 'simples', '1d6',  'impacto',    20, 2, null, 'strength', true,  false, []],
            ['Lança',           'melee', 'simples', '1d6',  'perfuração', 20, 2, null, 'strength', true,  false, ['Arremesso']],
            ['Maça',            'melee', 'simples', '1d8',  'impacto',    20, 2, null, 'strength', true,  false, []],
            ['Machadinha',      'melee', 'simples', '1d6',  'corte',      20, 3, null, 'strength', true,  false, ['Arremesso']],

            // ── Marciais corpo a corpo ─────────────────────────────────────────
            ['Espada Curta',    'melee', 'marcial', '1d6',  'perfuração', 19, 2, null, 'strength', true,  false, ['Ágil']],
            ['Espada Longa',    'melee', 'marcial', '1d8',  'corte',      19, 2, null, 'strength', true,  false, []],
            ['Espada Grande',   'melee', 'marcial', '2d6',  'corte',      19, 2, null, 'strength', true,  true,  ['Duas Mãos']],
            ['Cimitarra',       'melee', 'marcial', '1d6',  'corte',      18, 2, null, 'strength', true,  false, ['Ágil']],
            ['Rapieira',        'melee', 'marcial', '1d6',  'perfuração', 18, 2, null, 'strength', true,  false, ['Ágil']],
            ['Machado de Batalha', 'melee', 'marcial', '1d8', 'corte',    20, 3, null, 'strength', true,  false, []],
            ['Machado Grande',  'melee', 'marcial', '1d12', 'corte',      20, 3, null, 'strength', true,  true,  ['Duas Mãos']],
            ['Martelo de Guerra','melee','marcial', '1d8',  'impacto',    20, 3, null, 'strength', true,  false, []],
            ['Alabarda',        'melee', 'marcial', '1d10', 'corte',      20, 3, null, 'strength', true,  true,  ['Duas Mãos', 'Alongada']],
            ['Foice',           'melee', 'marcial', '2d4',  'corte',      20, 4, null, 'strength', true,  true,  ['Duas Mãos']],
            ['Tridente',        'melee', 'marcial', '1d8',  'perfuração', 20, 2, null, 'strength', true,  false, ['Arremesso']],
            ['Chicote',         'melee', 'marcial', '1d3',  'corte',      20, 2, null, 'strength', true,  false, ['Ágil', 'Alongada']],
            ['Lança Montada',   'melee', 'marcial', '1d10', 'perfuração', 20, 3, null, 'strength', true,  false, ['Montaria']],

            // ── Simples à distância ────────────────────────────────────────────
            ['Funda',           'ranged', 'simples', '1d4', 'impacto',    20, 2, 'Médio',  'dexterity', false, false, []],
            ['Azagaia',         'ranged', 'simples', '1d6', 'perfuração', 20, 2, 'Curto',  'dexterity', true,  false, ['Arremesso']],
            ['Besta Leve',      'ranged', 'simples', '1d8', 'perfuração', 19, 2, 'Médio',  'dexterity', false, false, []],

            // ── Marciais à distância ───────────────────────────────────────────
            ['Arco Curto',      'ranged', 'marcial', '1d6', 'perfuração', 20, 3, 'Médio',  'dexterity', false, false, []],
            ['Arco Longo',      'ranged', 'marcial', '1d8', 'perfuração', 20, 3, 'Longo',  'dexterity', false, false, []],
            ['Besta Pesada',    'ranged', 'marcial', '1d10','perfuração', 19, 2, 'Longo',  'dexterity', false, false, ['Duas Mãos']],
        ];

        $rows = [];
        foreach ($weapons as $w) {
            [$name, $category, $proficiency, $dice, $type, $threat, $crit, $range, $attr, $addStr, $twoHanded, $props] = $w;

            $rows[] = [
                'name'                => $name,
                'category'            => $category,
                'proficiency'         => $proficiency,
                'damage_dice'         => $dice,
                'damage_type'         => $type,
                'threat_range'        => $threat,
                'crit_multiplier'     => $crit,
                'range'               => $range,
                'attack_attribute'    => $attr,
                'add_strength_damage' => $addStr,
                'two_handed'          => $twoHanded,
                'properties'          => json_encode($props),
                'created_at'          => $now,
                'updated_at'          => $now,
            ];
        }

        DB::table('weapons_catalog')->insert($rows);
    }
}
