<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PowerSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $rows = [];

        // ── PODERES GERAIS ─────────────────────────────────────────────────────
        // [name, category, prerequisites|null, description]
        $gerais = [
            // Combate
            ['Ataque Poderoso', 'combate', ['attributes' => ['strength' => 1]],
                'Antes de um ataque corpo a corpo, troque até seu BBA em acerto por +2 de dano para cada -1.'],
            ['Ataque Preciso', 'combate', ['attributes' => ['dexterity' => 1]],
                'Antes de um ataque à distância, troque até seu BBA em acerto por +2 de dano para cada -1.'],
            ['Ambidestria', 'combate', ['attributes' => ['dexterity' => 1]],
                'Reduz a penalidade por usar duas armas. Pré-requisito para estilos de combate com duas armas.'],
            ['Estilo de Duas Armas', 'combate', ['attributes' => ['dexterity' => 2], 'powers' => ['Ambidestria']],
                'Ao atacar com duas armas, faz um ataque adicional com a arma secundária.'],
            ['Especialização em Arma', 'combate', ['min_level' => 3, 'skills' => ['Luta']],
                'Escolha uma arma. Você recebe +2 de dano com ela.'],
            ['Trespassar', 'combate', ['powers' => ['Ataque Poderoso']],
                'Ao reduzir um inimigo a 0 PV com ataque corpo a corpo, faça outro ataque contra alvo adjacente.'],

            // Destino
            ['Vitalidade', 'destino', null,
                'Você recebe +1 ponto de vida por nível de personagem.'],
            ['Saúde de Ferro', 'destino', null,
                'Você recebe +2 em testes de Fortitude.'],
            ['Vontade de Ferro', 'destino', null,
                'Você recebe +2 em testes de Vontade.'],
            ['Reflexos Rápidos', 'destino', null,
                'Você recebe +2 em testes de Reflexos.'],
            ['Perito', 'destino', null,
                'Escolha duas perícias. Você recebe +2 em cada uma delas.'],
            ['Acerto Crítico Aprimorado', 'destino', ['min_level' => 5, 'skills' => ['Luta']],
                'Escolha uma arma. A margem de ameaça dela aumenta em 1.'],

            // Magia
            ['Reservas Internas', 'magia', null,
                'Você recebe +2 pontos de mana.'],
            ['Adepto de Magia', 'magia', ['attributes' => ['intelligence' => 1]],
                'Você aprende uma magia de 1º círculo (arcana ou divina) e pode conjurá-la.'],
            ['Potência Mágica', 'magia', ['min_level' => 3, 'skills' => ['Misticismo']],
                'Gastando +2 PM, aumenta o dano de uma magia em +50%.'],
            ['Foco em Conjuração', 'magia', ['skills' => ['Misticismo']],
                'Escolha uma escola de magia. A CD para resistir às suas magias dessa escola aumenta em +1.'],

            // Concedido (exige devoção a uma divindade)
            ['Golpe Sagrado', 'concedido', ['deity' => 'Khalmyr'],
                'Uma vez por cena, adicione +2d8 de dano radiante a um ataque contra criatura maligna.'],
            ['Cura Abençoada', 'concedido', ['deity' => 'Lena'],
                'Ao lançar uma magia de cura, recupere PM igual ao círculo da magia.'],
            ['Fúria de Keenn', 'concedido', ['deity' => 'Keenn'],
                'Uma vez por cena, entre em fúria por 1 rodada, recebendo +2 em dano corpo a corpo.'],
        ];

        foreach ($gerais as [$name, $category, $prereq, $desc]) {
            $rows[] = [
                'name'          => $name,
                'type'          => 'geral',
                'category'      => $category,
                'race_id'       => null,
                'prerequisites' => $prereq ? json_encode($prereq) : null,
                'description'   => $desc,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        // ── PODERES DA TORMENTA ────────────────────────────────────────────────
        // Exigem o poder racial "Cria da Tormenta" (Lefou) ou afinidade equivalente.
        $tormenta = [
            ['Sopro da Tormenta', 'Cuspe ácido vermelho como ação padrão: 2d6 de dano em cone de 4,5m.'],
            ['Carne Viva', 'Sua carne se regenera: recupere 1 PV por nível no início de cada rodada por 1 cena.'],
            ['Membro Anômalo', 'Um membro mutante extra concede um ataque desarmado adicional por rodada.'],
            ['Escamas da Tormenta', 'Escamas vermelhas concedem +2 de Defesa e redução de dano 5 contra ácido.'],
        ];

        foreach ($tormenta as [$name, $desc]) {
            $rows[] = [
                'name'          => $name,
                'type'          => 'tormenta',
                'category'      => null,
                'race_id'       => null,
                'prerequisites' => json_encode(['powers' => ['Cria da Tormenta']]),
                'description'   => $desc,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        DB::table('powers')->insert($rows);

        // ── PODERES RACIAIS ────────────────────────────────────────────────────
        // Extraídos das habilidades raciais descritas no RaceSeeder.
        $raciais = [
            'Humano' => [
                ['Teimosia', 'Uma vez por cena, pode continuar agindo quando reduzido a 0 PV.'],
                ['Versátil', 'Recebe +1 PM e +1 ponto de perícia por nível.'],
                ['Determinação', 'Uma vez por cena, pode rolar novamente um teste com desvantagem.'],
            ],
            'Anão' => [
                ['Conhecimento das Rochas', '+2 em Percepção e Sobrevivência no subterrâneo.'],
                ['Devagar e Sempre', 'Deslocamento de 9m não é reduzido por armadura ou carga.'],
                ['Duro como Pedra', 'Recebe +3 PV por nível.'],
                ['Tradição de Herdronm', '+2 em ataques com machados, martelos e picaretas.'],
            ],
            'Dahllan' => [
                ['Amiga das Plantas', 'Pode lançar Controlar Plantas gastando 1 PM.'],
                ['Armadura de Allihanna', '+2 de Defesa na forma arbórea/vegetal.'],
                ['Empatia Selvagem', 'Comunica-se com plantas e animais nativos.'],
            ],
            'Elfo' => [
                ['Graça de Glórienm', 'Deslocamento aumenta para 12m.'],
                ['Sangue Mágico', 'Recebe +1 PM por nível.'],
                ['Sentidos Élficos', '+2 em Misticismo e Percepção.'],
            ],
            'Goblin' => [
                ['Engenhoso', 'Não sofre penalidades ao usar ferramentas improvisadas.'],
                ['Espelunqueiro', 'Visão no escuro até seu deslocamento; escala igual ao deslocamento.'],
                ['Pequenino', 'Tamanho Pequeno; ocupa espaço de 1,5m.'],
            ],
            'Lefou' => [
                ['Cria da Tormenta', 'Tipo monstro; +5 em resistência a efeitos da Tormenta. Permite Poderes da Tormenta.'],
                ['Deformidade', 'Cada deficiência física escolhida concede uma vantagem relacionada.'],
            ],
            'Minotauro' => [
                ['Chifres', 'Arma natural 1d6 (crítico x2); pode gastar 1 PM em carga para dano extra.'],
                ['Faro', '+2 em Percepção baseada em olfato; rastreia por cheiro.'],
                ['Corpulento', 'Tamanho Grande; ocupa espaço de 3m.'],
            ],
            'Qareen' => [
                ['Derejos', 'Ao lançar magia de dano, pode gastar +2 PM para mudar o tipo de dano.'],
                ['Resistência Elemental', 'Escolha um elemento; redução de dano 5 contra ele.'],
                ['Tatuagem Mística', '+1 círculo numa magia, uma vez por cena.'],
            ],
            'Golem' => [
                ['Chassis', 'O corpo é armadura; sem bônus de Defesa, mas sem limite de itens equipados.'],
                ['Criatura Artificial', 'Imune a venenos, doenças e sono; não precisa respirar.'],
                ['Propósito de Criação', '+2 em uma perícia ligada ao propósito original.'],
                ['Fonte Elemental', 'Escolha um elemento; +1 de dano desse tipo.'],
            ],
            'Hynne' => [
                ['Fortitude Hynne', 'Uma vez por cena, ao ser reduzido a 0 PV, fica com 1 PV.'],
                ['Pequenino', 'Tamanho Pequeno; deslocamento de 6m.'],
                ['Sorte Inata', 'Uma vez por cena, pode rolar novamente um teste de resistência.'],
            ],
            'Kliren' => [
                ['Arremessador', '+2 em ataques com armas de arremesso.'],
                ['Engenhosidade', 'Pode criar um dispositivo simples de uma lista em ação padrão.'],
                ['Sorte Salvadora', 'Uma vez por cena, +5 em um teste de resistência.'],
                ['Vanguardista', '+2 em Iniciativa.'],
            ],
            'Medusa' => [
                ['Olhar Petrificante', 'Ação padrão; o alvo testa Fortitude ou fica lento por 1 rodada.'],
                ['Mordida de Serpente', 'Arma natural 1d4 com veneno.'],
                ['Visão no Escuro', 'Enxerga no escuro completo até 9m.'],
            ],
            'Osteon' => [
                ['Armadura Óssea', '+2 de Defesa natural.'],
                ['Memória Póstuma', '+2 em uma perícia aleatória por cena (conhecimento da vida anterior).'],
                ['Natureza Esquelética', 'Imune a doenças, venenos e necessidades físicas; não se cura com magias de cura comuns.'],
            ],
            'Sereia/Tritão' => [
                ['Anfíbio', 'Respira sob a água; deslocamento de natação igual ao terrestre.'],
                ['Canção das Profundezas', 'Pode lançar Fascínio gastando 1 PM.'],
                ['Filho das Águas', '+2 em Atletismo aquático e +1 de dano com armas aquáticas.'],
            ],
            'Sílfide' => [
                ['Asas de Borboleta', 'Tamanho Pequeno; voo de 12m com manobrabilidade média.'],
                ['Espírito da Natureza', '+2 em Misticismo e Percepção em ambientes naturais.'],
                ['Magia das Fadas', 'Pode lançar Luz e Ilusão Fantasmagórica gastando 1 PM cada.'],
            ],
            'Suraggel' => [
                ['Herança Divina', 'Aggelus canaliza energia positiva; sulfure, energia negativa.'],
                ['Luz Sagrada/Sombras Profanas', '+1d6 de dano radiante (aggelus) ou necrótico (sulfure), uma vez por cena.'],
                ['Voo', 'Deslocamento aéreo de 9m.'],
            ],
            'Trog' => [
                ['Mau Cheiro', 'Aura de 1,5m; criaturas sem imunidade testam Fortitude ou ficam enjoadas.'],
                ['Mordida', 'Arma natural 1d6 (crítico x2).'],
                ['Reptiliano', '+1 de Defesa natural pelas escamas.'],
                ['Sangue Frio', '+1 de dano por dado de dano de frio.'],
            ],
        ];

        $raceIds = DB::table('races')->pluck('id', 'name');
        $racialRows = [];

        foreach ($raciais as $raceName => $powers) {
            $raceId = $raceIds[$raceName] ?? null;
            if (!$raceId) {
                continue;
            }

            foreach ($powers as [$name, $desc]) {
                $racialRows[] = [
                    'name'          => $name,
                    'type'          => 'racial',
                    'category'      => null,
                    'race_id'       => $raceId,
                    'prerequisites' => null,
                    'description'   => $desc,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ];
            }
        }

        DB::table('powers')->insert($racialRows);
    }
}
