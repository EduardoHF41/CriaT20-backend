<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpellSeeder extends Seeder
{
    /**
     * Banco de magias do Tormenta 20 a partir dos dados OGL oficiais
     * (database/data/spells/circle-1..5.json — conteúdo sob a Open Game License,
     * direitos das magias pertencem à Jambô Editora).
     *
     * Estrutura de origem por magia:
     *   name, type ("Arcana 1 (Convocação)"), circle, school (em type), execution,
     *   range, target, area, duration, resistance, description, effect,
     *   implements [{cost:"+2 PM", description}]  → aprimoramentos
     *
     * O custo-base em PM não consta no dataset; aplicamos a regra padrão do T20:
     *   custo = 2 × círculo − 1  (1º=1, 2º=3, 3º=5, 4º=7, 5º=9 PM)
     */
    public function run(): void
    {
        $now = now();
        $rows = [];

        foreach ([1, 2, 3, 4, 5] as $circle) {
            $path = database_path("data/spells/circle-{$circle}.json");
            if (!is_file($path)) {
                $this->command?->warn("Arquivo de magias ausente: {$path}");
                continue;
            }

            $data = json_decode(file_get_contents($path), true);

            foreach ($data['spells'] ?? [] as $s) {
                [$tradition, $school] = $this->parseType($s['type'] ?? '');
                $circleNum = (int) ($s['circle'] ?? $circle);

                $rows[] = [
                    'name'         => $s['name'],
                    'tradition'    => $tradition,
                    'school'       => $school,
                    'circle'       => $circleNum,
                    'mp_cost'      => max(1, 2 * $circleNum - 1),
                    'execution'    => $this->cap($s['execution'] ?? 'Padrão'),
                    'range'        => $this->cap($s['range'] ?? '—'),
                    'target_area'  => $this->targetArea($s),
                    'duration'     => $this->cap($s['duration'] ?? 'Instantânea'),
                    'resistance'   => $this->nullable($s['resistance'] ?? ''),
                    'description'  => $this->description($s),
                    'enhancements' => $this->enhancements($s['implements'] ?? []),
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }
        }

        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('spells')->insert($chunk);
        }
    }

    /**
     * "Arcana 1 (Convocação)" → ['arcana', 'Convocação'].
     *
     * @return array{0:string,1:string}
     */
    private function parseType(string $type): array
    {
        $tradition = 'arcana';
        if (preg_match('/^(\w+)/u', $type, $m)) {
            $tradition = strtolower($m[1]); // arcana | divina | universal
        }

        $school = 'Universal';
        if (preg_match('/\(([^)]+)\)/u', $type, $m)) {
            $school = trim($m[1]);
        }

        return [$tradition, $school];
    }

    /**
     * @param array<string,mixed> $s
     */
    private function targetArea(array $s): ?string
    {
        $parts = array_filter([
            trim($s['target'] ?? ''),
            trim($s['area'] ?? ''),
        ]);

        return empty($parts) ? null : implode(' / ', $parts);
    }

    /**
     * @param array<string,mixed> $s
     */
    private function description(array $s): string
    {
        $desc = trim($s['description'] ?? '');
        $effect = trim($s['effect'] ?? '');

        if ($effect !== '' && stripos($desc, $effect) === false) {
            $desc = $effect . ($desc !== '' ? "\n\n" . $desc : '');
        }

        return $desc;
    }

    /**
     * Converte os "implements" do dataset em aprimoramentos {cost:int, description}.
     *
     * @param array<int,array<string,string>> $implements
     */
    private function enhancements(array $implements): ?string
    {
        if (empty($implements)) {
            return null;
        }

        $out = [];
        foreach ($implements as $imp) {
            $cost = 0;
            if (preg_match('/(\d+)/', $imp['cost'] ?? '', $m)) {
                $cost = (int) $m[1];
            }
            $out[] = [
                'cost'        => $cost,
                'description' => trim($imp['description'] ?? ''),
            ];
        }

        return json_encode($out, JSON_UNESCAPED_UNICODE);
    }

    private function nullable(string $value): ?string
    {
        $value = trim($value);
        return $value === '' ? null : $this->cap($value);
    }

    private function cap(string $value): string
    {
        $value = trim($value);
        if ($value === '') {
            return $value;
        }
        return mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
    }
}
