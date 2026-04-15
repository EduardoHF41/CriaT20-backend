<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RaceSeeder extends Seeder
{
    public function run(): void
    {
        // Estrutura de attribute_modifiers:
        // fixed   → modificadores fixos { "strength": 2, "constitution": 1, "wisdom": -1 }
        // flexible → jogador escolhe quais atributos recebem bônus
        //            { "count": 3, "value": 1, "exclude": [] }
        // subtypes → duas sub-raças com modificadores distintos (Suraggel)

        DB::table('races')->insert([
            [
                'name' => 'Humano',
                'description' => 'A raça mais numerosa e versátil de Arton. Adaptáveis e ambiciosos, humanos prosperam em qualquer ambiente ou profissão. Sua diversidade faz com que sejam encontrados em todos os reinos.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => [],
                    'flexible' => ['count' => 3, 'value' => 1, 'exclude' => []],
                ]),
            ],
            [
                'name' => 'Anão',
                'description' => 'Povo resistente e determinado, famoso por artesanato, mineração e combate. Vivem principalmente em cidades subterrâneas e possuem forte tradição cultural. Sua constituição robusta os torna difíceis de derrubar em batalha.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['constitution' => 2, 'wisdom' => 1, 'dexterity' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Dahllan',
                'description' => 'Descendentes de espíritos da natureza com forte ligação com florestas e plantas. Muitas vezes parecem parcialmente vegetais, refletindo sua origem ligada à deusa Allihanna. Defendem o equilíbrio natural.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['wisdom' => 2, 'dexterity' => 1, 'intelligence' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Elfo',
                'description' => 'Seres longevos e graciosos com afinidade com magia e natureza. Possuem grande intelecto e agilidade, vivendo por séculos e acumulando conhecimento. Mantêm tradições antigas e forte ligação com o mundo natural.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['intelligence' => 2, 'dexterity' => 1, 'constitution' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Goblin',
                'description' => 'Pequenos, rápidos e extremamente engenhosos. Embora muitas vezes vistos como trapaceiros, também são inventores talentosos e sobreviventes habilidosos. Sua inteligência prática os torna úteis em diversas situações.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['dexterity' => 2, 'intelligence' => 1, 'charisma' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Lefou',
                'description' => 'Indivíduos marcados pela influência da Tormenta, uma força caótica e alienígena. Seu corpo frequentemente apresenta mutações estranhas. Por causa dessa origem, são temidos e discriminados em muitos lugares de Arton.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['charisma' => -1],
                    'flexible' => ['count' => 3, 'value' => 1, 'exclude' => ['charisma']],
                ]),
            ],
            [
                'name' => 'Minotauro',
                'description' => 'Humanoides bovinos conhecidos por força e orgulho. Sua cultura valoriza combate, honra e conquistas pessoais. Muitos vêm do Império de Tauron e possuem tradição militar e marcial.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['strength' => 2, 'constitution' => 1, 'wisdom' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Qareen',
                'description' => 'Descendentes de gênios elementais com forte talento para magia. Seu sangue mágico lhes concede habilidades sobrenaturais e carisma natural. Frequentemente ligados a histórias de desejos, pactos e mistérios arcanos.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['charisma' => 2, 'intelligence' => 1, 'wisdom' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Golem',
                'description' => 'Construtos artificiais criados por magia ou alquimia. Apesar de serem feitos de pedra, metal ou outros elementos, possuem consciência própria. Cada golem tem uma origem única ligada ao propósito para o qual foi criado.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['strength' => 2, 'constitution' => 1, 'charisma' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Hynne',
                'description' => 'Pequenos humanoides alegres e sociáveis, também chamados halflings. Conhecidos por bom humor e hospitalidade, apreciam boa comida, histórias e companhia. Apesar da aparência inocente, podem ser surpreendentemente corajosos.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['dexterity' => 2, 'charisma' => 1, 'strength' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Kliren',
                'description' => 'Povo extremamente inteligente e curioso, com grande talento para ciência e magia. Costumam ser estudiosos, inventores ou pesquisadores. Sua cultura valoriza conhecimento, lógica e descobertas.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['intelligence' => 2, 'charisma' => 1, 'strength' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Medusa',
                'description' => 'Criaturas humanoides com serpentes no lugar dos cabelos e olhar petrificante. Muitas vivem isoladas ou em sociedades próprias. Apesar da aparência assustadora, algumas tentam viver entre outras raças.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['dexterity' => 2, 'intelligence' => 1, 'charisma' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Osteon',
                'description' => 'Mortos-vivos conscientes formados por esqueletos animados. Mesmo após a morte, mantêm lembranças fragmentadas de sua vida anterior. Sua existência desafia as fronteiras entre vida e morte.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['constitution' => -1],
                    'flexible' => ['count' => 3, 'value' => 1, 'exclude' => ['constitution']],
                ]),
            ],
            [
                'name' => 'Sereia/Tritão',
                'description' => 'De torso humanoide e corpo de peixe, podem adorar forma bípede para caminhar em terra. Enquanto algumas sereias tendem a ver outras raças com curiosidade, o comum é encontrá-las como aventureiras nos reinos aquáticos.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => [],
                    'flexible' => ['count' => 3, 'value' => 1, 'exclude' => []],
                ]),
            ],
            [
                'name' => 'Sílfide',
                'description' => 'Pequenas criaturas aladas ligadas à magia e à liberdade. Leves e etéreas, possuem asas e capacidade natural de voo. Sua personalidade costuma ser curiosa e brincalhona.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['charisma' => 2, 'dexterity' => 1, 'strength' => -3],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Suraggel',
                'description' => 'Descendentes de entidades celestiais (aggelus) ou infernais (sulfure). Existem dois tipos com poderes distintos. Seu sangue sobrenatural lhes concede habilidades incomuns e aparência marcante.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => null,
                    'flexible' => null,
                    'subtypes' => [
                        'aggelus' => ['wisdom' => 2, 'charisma' => 1],
                        'sulfure' => ['dexterity' => 2, 'intelligence' => 1],
                    ],
                ]),
            ],
            [
                'name' => 'Trog',
                'description' => 'Humanoides reptilianos (trogloditas) que vivem em cavernas e regiões subterrâneas. Possuem sentidos aguçados e grande resistência. Muitas tribos são ferozes e territoriais, mas alguns buscam caminhos além de sua cultura.',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['constitution' => 2, 'strength' => 1, 'intelligence' => -1],
                    'flexible' => null,
                ]),
            ],
        ]);
    }
}
