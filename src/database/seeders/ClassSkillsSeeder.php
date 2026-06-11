<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSkillsSeeder extends Seeder
{
    /**
     * Popula initial_skills_data com estrutura:
     *   fixed      → perícias obrigatórias (sem escolha)
     *   or_groups  → grupos de escolha exclusiva: player escolhe 1 por grupo
     *   free_count → perícias adicionais livres do catálogo completo
     */
    public function run(): void
    {
        $data = [
            'Arcanista'  => ['fixed' => ['Misticismo', 'Vontade'],        'or_groups' => [],                            'free_count' => 2],
            'Bárbaro'    => ['fixed' => [],                               'or_groups' => [],                            'free_count' => 4],
            'Bardo'      => ['fixed' => [],                               'or_groups' => [],                            'free_count' => 8],
            'Bucaneiro'  => ['fixed' => ['Reflexos'],                     'or_groups' => [],                            'free_count' => 6],
            'Caçador'    => ['fixed' => ['Sobrevivência'],                'or_groups' => [['Luta', 'Pontaria']],        'free_count' => 2],
            'Cavaleiro'  => ['fixed' => ['Luta', 'Cavalgar'],             'or_groups' => [],                            'free_count' => 2],
            'Clérigo'    => ['fixed' => ['Religião', 'Vontade'],          'or_groups' => [],                            'free_count' => 2],
            'Druida'     => ['fixed' => ['Sobrevivência'],                'or_groups' => [],                            'free_count' => 4],
            'Guerreiro'  => ['fixed' => ['Luta', 'Pontaria'],             'or_groups' => [],                            'free_count' => 4],
            'Inventor'   => ['fixed' => ['Ofício', 'Vontade'],            'or_groups' => [],                            'free_count' => 4],
            'Ladino'     => ['fixed' => ['Ladinagem', 'Reflexos'],        'or_groups' => [],                            'free_count' => 8],
            'Lutador'    => ['fixed' => ['Luta', 'Atletismo'],            'or_groups' => [],                            'free_count' => 4],
            'Nobre'      => ['fixed' => ['Vontade'],                      'or_groups' => [['Diplomacia', 'Intimidação']],'free_count' => 4],
            'Paladino'   => ['fixed' => ['Fortitude'],                    'or_groups' => [],                            'free_count' => 2],
        ];

        foreach ($data as $name => $skills) {
            DB::table('character_classes')
                ->where('name', $name)
                ->update(['initial_skills_data' => json_encode($skills)]);
        }
    }
}
