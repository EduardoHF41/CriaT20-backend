<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Catálogo completo das 29 perícias do Tormenta 20 (Tabela 4-1).
     *
     * Colunas: [key_attribute, trained_only, armor_penalty, is_variable]
     * key_attribute em inglês para mapear direto às colunas de atributo do personagem.
     */
    public function run(): void
    {
        $now = now();

        $skills = [
            ['Acrobacia',     'dexterity',    false, true,  false, 'Equilíbrio, rolamentos e manobras corporais ágeis.'],
            ['Adestramento',  'charisma',     false, false, false, 'Treinar, acalmar e conduzir animais.'],
            ['Atletismo',     'strength',     false, false, false, 'Correr, escalar, nadar e saltar.'],
            ['Atuação',       'charisma',     false, false, true,  'Apresentações artísticas: música, dança, teatro etc.'],
            ['Cavalgar',      'dexterity',    false, false, false, 'Montar e controlar montarias.'],
            ['Conhecimento',  'intelligence', true,  false, false, 'Saber acadêmico geral sobre o mundo.'],
            ['Cura',          'wisdom',       false, false, false, 'Primeiros socorros e tratamento de ferimentos.'],
            ['Diplomacia',    'charisma',     false, false, false, 'Negociar, persuadir e influenciar atitudes.'],
            ['Enganação',     'charisma',     false, false, false, 'Mentir, blefar e disfarçar intenções.'],
            ['Fortitude',     'constitution', false, false, false, 'Resistência física a venenos, doenças e fadiga.'],
            ['Furtividade',   'dexterity',    false, true,  false, 'Mover-se e esconder-se sem ser notado.'],
            ['Guerra',        'intelligence', true,  false, false, 'Tática, estratégia e comando em batalha.'],
            ['Iniciativa',    'dexterity',    false, false, false, 'Rapidez de reação no início do combate.'],
            ['Intimidação',   'charisma',     false, false, false, 'Coagir e amedrontar pela presença ou ameaça.'],
            ['Intuição',      'wisdom',       false, false, false, 'Perceber intenções, mentiras e o humor alheio.'],
            ['Investigação',  'intelligence', false, false, false, 'Procurar pistas e deduzir informações.'],
            ['Jogatina',      'charisma',     false, false, false, 'Jogos de azar, trapaça e apostas.'],
            ['Ladinagem',     'dexterity',    true,  true,  false, 'Abrir fechaduras, desarmar armadilhas e bater carteiras.'],
            ['Luta',          'strength',     false, false, false, 'Ataques corpo a corpo.'],
            ['Misticismo',    'intelligence', true,  false, false, 'Conhecimento sobre magia arcana e itens mágicos.'],
            ['Nobreza',       'intelligence', true,  false, false, 'Heráldica, etiqueta, política e linhagens nobres.'],
            ['Ofício',        'intelligence', true,  false, true,  'Criação de itens de uma especialidade (alquimia, armas etc.).'],
            ['Percepção',     'wisdom',       false, false, false, 'Notar detalhes, perigos e criaturas escondidas.'],
            ['Pilotagem',     'dexterity',    true,  false, false, 'Conduzir veículos como barcos e carruagens.'],
            ['Pontaria',      'dexterity',    false, true,  false, 'Ataques à distância.'],
            ['Reflexos',      'dexterity',    false, false, false, 'Esquivar de efeitos de área e perigos súbitos.'],
            ['Religião',      'intelligence', true,  false, false, 'Conhecimento sobre divindades, fé e mortos-vivos.'],
            ['Sobrevivência', 'wisdom',       false, false, false, 'Rastrear, orientar-se e sobreviver na natureza.'],
            ['Vontade',       'wisdom',       false, false, false, 'Resistência mental a medo, encantos e ilusões.'],
        ];

        $rows = [];
        foreach ($skills as [$name, $attr, $trainedOnly, $armorPenalty, $isVariable, $description]) {
            $rows[] = [
                'name'          => $name,
                'key_attribute' => $attr,
                'trained_only'  => $trainedOnly,
                'armor_penalty' => $armorPenalty,
                'is_variable'   => $isVariable,
                'description'   => $description,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        DB::table('skills')->insert($rows);
    }
}
