<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RaceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('races')->insert([
            [
                'name' => 'Humano',
                'description' => 'A raça mais numerosa e versátil de Arton. Adaptáveis e ambiciosos, humanos prosperam em qualquer ambiente ou profissão. Habilidades raciais: Teimosia (pode continuar agindo quando reduzido a 0 PV uma vez por cena), Versátil (+1 PM e +1 ponto de perícia por nível), Determinação (uma vez por cena, pode rolar novamente um teste com desvantagem).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => [],
                    'flexible' => ['count' => 3, 'value' => 1, 'exclude' => []],
                ]),
            ],
            [
                'name' => 'Anão',
                'description' => 'Povo resistente e determinado, famoso por artesanato, mineração e combate em cidades subterrâneas. Habilidades raciais: Conhecimento das Rochas (+2 em Percepção e Sobrevivência subterrâneas), Devagar e Sempre (deslocamento de 9m não reduzido por armadura), Duro como Pedra (+3 PV por nível), Tradição de Herdronm (+2 em ataques com machados, martelos e picaretas).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['constitution' => 2, 'wisdom' => 1, 'dexterity' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Dahllan',
                'description' => 'Descendentes de espíritos da natureza ligados à deusa Allihanna, com aparência parcialmente vegetal. Habilidades raciais: Amiga das Plantas (pode lançar Controlar Plantas por 1 PM), Armadura de Allihanna (+2 Defesa na forma arbórea/vegetal), Empatia Selvagem (comunica-se com plantas e animais nativos).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['wisdom' => 2, 'dexterity' => 1, 'intelligence' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Elfo',
                'description' => 'Seres longevos e graciosos com afinidade com magia e natureza, vivendo por séculos. Habilidades raciais: Graça de Glórienm (deslocamento 12m), Sangue Mágico (+1 PM por nível), Sentidos Élficos (+2 em Misticismo e Percepção).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['intelligence' => 2, 'dexterity' => 1, 'constitution' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Goblin',
                'description' => 'Pequenos humanoides ágeis e engenhosos, inventores talentosos e sobreviventes habilidosos. Habilidades raciais: Engenhoso (sem penalidades com ferramentas improvisadas), Espelunqueiro (visão no escuro até seu deslocamento, trepa igual ao deslocamento), Pequenino (tamanho Pequeno, ocupa espaço 1,5m).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['dexterity' => 2, 'intelligence' => 1, 'charisma' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Lefou',
                'description' => 'Indivíduos marcados pela Tormenta, com mutações físicas estranhas. Temidos e discriminados, sua origem caótica também lhes confere poderes incomuns. Habilidades raciais: Cria da Tormenta (tipo monstro, +5 em resistência a efeitos da Tormenta), Deformidade (cada deficiência física concede vantagem relacionada).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['charisma' => -1],
                    'flexible' => ['count' => 3, 'value' => 1, 'exclude' => ['charisma']],
                ]),
            ],
            [
                'name' => 'Minotauro',
                'description' => 'Humanoides bovinos de cultura marcial e grande orgulho, vindos do Império de Tauron. Habilidades raciais: Chifres (arma natural 1d6, crítico x2; pode gastar 1 PM em carga para dano extra), Faro (+2 Percepção baseada em olfato, rastreia por cheiro), Corpulento (tamanho Grande, ocupa espaço 3m).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['strength' => 2, 'constitution' => 1, 'wisdom' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Qareen',
                'description' => 'Descendentes de gênios elementais com talento mágico e carisma natural, ligados a pactos e desejos. Habilidades raciais: Derejos (ao lançar magia de dano, pode gastar +2 PM para mudar o tipo de dano), Resistência Elemental (escolha um elemento; redução de dano 5 contra ele), Tatuagem Mística (+1 círculo numa magia por cena).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['charisma' => 2, 'intelligence' => 1, 'wisdom' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Golem',
                'description' => 'Construtos artificiais criados por magia com consciência própria. Cada golem tem propósito único de origem. Habilidades raciais: Chassis (corpo é armadura; sem bônus de Def mas sem limite de itens equipados), Criatura Artificial (imune a venenos, doenças, sono; não precisa respirar), Propósito de Criação (+2 em perícia ligada ao seu propósito original), Fonte Elemental (escolha elemento; +1 dano desse tipo).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['strength' => 2, 'constitution' => 1, 'charisma' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Hynne',
                'description' => 'Pequenos humanoides alegres e corajosos, também chamados halflings. Apreciam boa comida, histórias e companhia. Habilidades raciais: Fortitude Hynne (uma vez por cena, quando seria reduzido a 0 PV, fica com 1 PV), Pequenino (tamanho Pequeno, deslocamento 6m), Sorte Inata (pode rolar novamente um teste de resistência uma vez por cena).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['dexterity' => 2, 'charisma' => 1, 'strength' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Kliren',
                'description' => 'Povo extremamente inteligente e curioso, com talento para ciência e magia. Valorizam conhecimento, lógica e descobertas. Habilidades raciais: Arremessador (+2 em ataques com armas de arremesso), Engenhosidade (pode criar dispositivo simples de uma lista em ação padrão), Sorte Salvadora (uma vez por cena, +5 num teste de resistência), Vanguardista (+2 Iniciativa).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['intelligence' => 2, 'charisma' => 1, 'strength' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Medusa',
                'description' => 'Humanoides com serpentes no lugar dos cabelos e olhar petrificante. Algumas tentam viver entre outras raças. Habilidades raciais: Olhar Petrificante (ação padrão; alvo vê sua face e testa Fortitude ou fica lento por 1 rodada), Mordida de Serpente (arma natural 1d4+veneno), Visão no Escuro (enxerga no escuro completo até 9m).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['dexterity' => 2, 'intelligence' => 1, 'charisma' => -1],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Osteon',
                'description' => 'Mortos-vivos conscientes com lembranças fragmentadas da vida anterior. Desafiam a fronteira entre vida e morte. Habilidades raciais: Armadura Óssea (+2 Defesa natural), Memória Póstuma (conhecimento de sua vida anterior; +2 em uma perícia aleatória por cena), Natureza Esquelética (imune a doenças, venenos, necessidades físicas; não se cura magias de cura comuns).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['constitution' => -1],
                    'flexible' => ['count' => 3, 'value' => 1, 'exclude' => ['constitution']],
                ]),
            ],
            [
                'name' => 'Sereia/Tritão',
                'description' => 'De torso humanoide e cauda de peixe, podem assumir forma bípede em terra. Vivem nos mares e rios de Arton. Habilidades raciais: Anfíbio (respira sob a água; deslocamento nado igual ao terrestre), Canção das Profundezas (pode lançar Fascínio por 1 PM), Filho das Águas (+2 Atletismo aquático, +1 dano com armas aquáticas).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => [],
                    'flexible' => ['count' => 3, 'value' => 1, 'exclude' => []],
                ]),
            ],
            [
                'name' => 'Sílfide',
                'description' => 'Pequenas criaturas aladas ligadas à magia feérica, etéreas e curiosas. Habilidades raciais: Asas de Borboleta (tamanho Pequeno; voo 12m, manobralidade média), Espírito da Natureza (+2 Misticismo e Percepção em ambientes naturais), Magia das Fadas (pode lançar Luz e Ilusão Fantasmagórica por 1 PM cada).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['charisma' => 2, 'dexterity' => 1, 'strength' => -2],
                    'flexible' => null,
                ]),
            ],
            [
                'name' => 'Suraggel',
                'description' => 'Descendentes de entidades celestiais (aggelus) ou infernais (sulfure). Dois subtipos com poderes distintos. Habilidades raciais: Herança Divina (aggelus: canaliza energia positiva; sulfure: energia negativa), Luz Sagrada/Sombras Profanas (aggelus: +1d6 dano radiante 1x/cena; sulfure: +1d6 dano necrótico 1x/cena), Voo (deslocamento aéreo 9m).',
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
                'description' => 'Humanoides reptilianos (trogloditas) de cavernas com sentidos aguçados. Muitas tribos são territoriais e ferozes. Habilidades raciais: Mau Cheiro (aura 1,5m; criaturas sem imunidade testam Fortitude ou ficam enjoadas), Mordida (arma natural 1d6, crítico x2), Reptiliano (+1 Defesa natural por escamas), Sangue Frio (+1 de dano por dado de dano de frio).',
                'attribute_modifiers' => json_encode([
                    'fixed'    => ['constitution' => 2, 'strength' => 1, 'intelligence' => -1],
                    'flexible' => null,
                ]),
            ],
        ]);
    }
}
