<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassPowersSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Arcanista' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => true,
                'spell_school'       => 'Arcana',
                'initial_spells'     => 3,
                'available_powers'   => [
                    ['name' => 'Magia Aprimorada',    'description' => 'Escolha uma escola de magia. A CD para resistir às suas magias dessa escola aumenta em +2.'],
                    ['name' => 'Mago de Batalha',     'description' => 'Você pode conjurar magias e realizar um ataque na mesma rodada, sem penalidade.'],
                    ['name' => 'Resistência Arcana',  'description' => 'Você recebe +5 em testes de resistência contra efeitos mágicos.'],
                    ['name' => 'Arcano Extra',         'description' => 'Você recebe +2 PM (pontos de magia) adicionais.'],
                    ['name' => 'Foco em Magia',        'description' => 'Escolha uma magia. Você a conjura gastando 1 PM a menos (mínimo 1).'],
                    ['name' => 'Conjurar Monstro',     'description' => 'Você pode evocar criaturas para combater a seu lado como ação padrão.'],
                ],
                'available_spells' => [
                    ['name' => 'Mísseis Mágicos',    'circle' => 1, 'mp_cost' => 1, 'description' => 'Dispara projéteis mágicos que causam 1d4+1 de dano de força. Nunca erram.'],
                    ['name' => 'Luz',                'circle' => 1, 'mp_cost' => 1, 'description' => 'Ilumina uma área em 9m ao redor do alvo por 1 hora.'],
                    ['name' => 'Escudo Arcano',       'circle' => 1, 'mp_cost' => 1, 'description' => 'Cria um escudo mágico que concede +4 na Defesa por 1 rodada/nível.'],
                    ['name' => 'Sono',                'circle' => 1, 'mp_cost' => 1, 'description' => 'Força criaturas com até 4 DV a adormecer. CD Inteligência para resistir.'],
                    ['name' => 'Detectar Magia',      'circle' => 1, 'mp_cost' => 1, 'description' => 'Detecta a presença de magias e itens mágicos em 18m à sua frente.'],
                    ['name' => 'Enfraquecer',         'circle' => 1, 'mp_cost' => 1, 'description' => 'O alvo sofre –2 em testes de Força e –1 em rolagens de dano por 1 hora.'],
                    ['name' => 'Toque Chocante',      'circle' => 1, 'mp_cost' => 1, 'description' => 'Toque que causa 1d6 de dano de eletricidade por nível (máx. 5d6).'],
                    ['name' => 'Ilusão Fantasmagórica','circle' => 1, 'mp_cost' => 2, 'description' => 'Cria uma ilusão visual e auditiva. A criatura que interagir pode resistir.'],
                    ['name' => 'Invocar Instrumento', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Materializa um instrumento musical mágico que dura 1 hora.'],
                    ['name' => 'Levitar',             'circle' => 2, 'mp_cost' => 3, 'description' => 'Você ou um alvo flutua verticalmente até 6m pelo concentração.'],
                ],
            ],

            'Bárbaro' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Carga',                 'description' => 'Quando entra em Fúria, pode se mover até o dobro do deslocamento e atacar na mesma ação.'],
                    ['name' => 'Bravura',               'description' => 'Você é imune a efeitos de medo e pânico.'],
                    ['name' => 'Espírito Animal',        'description' => 'Escolha um animal totêmico e receba um bônus especial relacionado a ele durante a Fúria.'],
                    ['name' => 'Força Colossal',         'description' => 'Enquanto em Fúria, você recebe +4 em rolagens de dano corpo a corpo.'],
                    ['name' => 'Pele de Urso',           'description' => 'Enquanto em Fúria, você recebe +4 de Redução de Dano contra ataques físicos.'],
                    ['name' => 'Golpe de Derrubar',      'description' => 'Quando derruba um inimigo durante a Fúria, pode fazer um ataque extra imediatamente.'],
                ],
                'available_spells'   => [],
            ],

            'Bardo' => [
                'powers_at_creation' => 3,
                'is_spellcaster'     => true,
                'spell_school'       => 'Arcana',
                'initial_spells'     => 2,
                'available_powers'   => [
                    ['name' => 'Canção de Batalha',    'description' => 'Enquanto você canta, aliados a até 9m recebem +1 nas jogadas de ataque e dano.'],
                    ['name' => 'Fascínio',             'description' => 'Você pode fascinar criaturas com música. CD Vontade para resistir.'],
                    ['name' => 'Conhecimento Bardônico','description' => 'Você pode fazer testes de Conhecimento (História, Religião, etc.) mesmo sem treinamento.'],
                    ['name' => 'Inspiração',           'description' => 'Concede +2 em testes de perícia a um aliado por ação padrão, válido por 1 hora.'],
                    ['name' => 'Versatilidade',        'description' => 'Escolha uma perícia de outra classe. Você a trata como perícia treinada.'],
                    ['name' => 'Canção de Cura',       'description' => 'Sua música cura 1d6 PV de aliados a até 9m por rodada de performance.'],
                ],
                'available_spells'   => [
                    ['name' => 'Mísseis Mágicos',    'circle' => 1, 'mp_cost' => 1, 'description' => 'Dispara projéteis mágicos que causam 1d4+1 de dano de força.'],
                    ['name' => 'Luz',                'circle' => 1, 'mp_cost' => 1, 'description' => 'Ilumina uma área em 9m por 1 hora.'],
                    ['name' => 'Sono',               'circle' => 1, 'mp_cost' => 1, 'description' => 'Força criaturas com até 4 DV a adormecer.'],
                    ['name' => 'Ilusão Fantasmagórica','circle' => 1, 'mp_cost' => 2, 'description' => 'Cria uma ilusão visual e auditiva.'],
                ],
            ],

            'Bucaneiro' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Fanfarronice',   'description' => 'Você pode usar Blefar no lugar de Intimidar para assustar inimigos.'],
                    ['name' => 'Golpe Baixo',    'description' => 'Quando ataca um oponente que não agiu neste combate, você causa +2d6 de dano.'],
                    ['name' => 'Sorte do Bucaneiro','description' => 'Uma vez por cena, você pode rolar novamente qualquer teste e ficar com o melhor resultado.'],
                    ['name' => 'Saraivada',      'description' => 'Você pode realizar um ataque contra cada inimigo adjacente como uma ação padrão.'],
                    ['name' => 'Piques e Piques','description' => 'Seu deslocamento aumenta em +3m e você recebe +2 em testes de Atletismo.'],
                    ['name' => 'Esquiva do Bucaneiro','description' => 'Quando você se esquiva com sucesso de um ataque corpo a corpo, pode fazer uma réplica imediata.'],
                ],
                'available_spells'   => [],
            ],

            'Caçador' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Inimigo Predileto',  'description' => 'Escolha um tipo de criatura. Você recebe +2 em ataques, dano e testes de perícia contra esse tipo.'],
                    ['name' => 'Companheiro Animal', 'description' => 'Você tem um animal companheiro fiel que o auxilia em combate e exploração.'],
                    ['name' => 'Rastreamento',       'description' => 'Você recebe +5 em testes de Sobrevivência para rastrear criaturas.'],
                    ['name' => 'Tiro Certeiro',      'description' => 'Seus ataques à distância ignoram cobertura parcial do alvo.'],
                    ['name' => 'Emboscada',          'description' => 'Quando ataca de surpresa, você causa +1d6 de dano adicional.'],
                    ['name' => 'Terreno Favorito',   'description' => 'Escolha um tipo de terreno. Você recebe +2 em Percepção e Sobrevivência nele.'],
                ],
                'available_spells'   => [],
            ],

            'Cavaleiro' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Ataque Montado',     'description' => 'Você recebe +2 nas jogadas de ataque quando está montado.'],
                    ['name' => 'Código de Honra',    'description' => 'Enquanto cumpre seu código, recebe +2 em todos os testes e +1 de Defesa.'],
                    ['name' => 'Investida Poderosa', 'description' => 'Quando faz uma investida montado, causa +2d6 de dano adicional.'],
                    ['name' => 'Proteção',           'description' => 'Você pode usar uma reação para interpor-se e absorver um ataque destinado a um aliado adjacente.'],
                    ['name' => 'Estandarte',         'description' => 'Aliados a até 9m recebem +1 moral em ataques enquanto você brande seu estandarte.'],
                    ['name' => 'Desafio',            'description' => 'Você pode desafiar um inimigo: ele recebe –2 em ataques que não sejam contra você.'],
                ],
                'available_spells'   => [],
            ],

            'Clérigo' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => true,
                'spell_school'       => 'Divina',
                'initial_spells'     => 2,
                'available_powers'   => [
                    ['name' => 'Canalizar Energia',   'description' => 'Você pode gastar 2 PM para curar 1d6 PV de todas as criaturas vivas (ou causar esse dano a mortos-vivos) em 9m.'],
                    ['name' => 'Aura de Fé',          'description' => 'Aliados adjacentes recebem +1 nas jogadas de dano enquanto você estiver ativo.'],
                    ['name' => 'Expulsar Mortos-Vivos','description' => 'Como ação padrão, você força mortos-vivos a se afastarem. CD Vontade para resistir.'],
                    ['name' => 'Domínio Divino',      'description' => 'Você ganha um poder especial relacionado ao domínio de sua divindade.'],
                    ['name' => 'Escudo da Fé',        'description' => 'Você pode conceder +2 na Defesa a um aliado adjacente por PM gasto.'],
                    ['name' => 'Punição Divina',      'description' => 'Uma vez por cena, seu próximo ataque causa +2d8 de dano sagrado ou profano.'],
                ],
                'available_spells'   => [
                    ['name' => 'Curar Ferimentos',     'circle' => 1, 'mp_cost' => 1, 'description' => 'Cura 1d8+mod. Sab de PV no alvo pelo toque.'],
                    ['name' => 'Bênção',               'circle' => 1, 'mp_cost' => 1, 'description' => 'Aliados a até 9m recebem +1 nas jogadas de ataque e resistência por 1 min/nível.'],
                    ['name' => 'Luz',                  'circle' => 1, 'mp_cost' => 1, 'description' => 'Ilumina área de 9m por 1 hora.'],
                    ['name' => 'Proteção Divina',      'circle' => 1, 'mp_cost' => 1, 'description' => 'O alvo recebe +2 na Defesa e nos testes de resistência por 1 min/nível.'],
                    ['name' => 'Purificar Alimento',   'circle' => 1, 'mp_cost' => 1, 'description' => 'Remove toxinas e doenças de comida e água suficiente para 12 pessoas.'],
                    ['name' => 'Detectar o Mal',       'circle' => 1, 'mp_cost' => 1, 'description' => 'Detecta a presença e intensidade de auras malignas a até 18m.'],
                ],
            ],

            'Druida' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => true,
                'spell_school'       => 'Primal',
                'initial_spells'     => 2,
                'available_powers'   => [
                    ['name' => 'Forma Selvagem',      'description' => 'Você pode se transformar em um animal de tamanho Médio ou menor. A transformação dura 1 hora por nível.'],
                    ['name' => 'Comunhão',            'description' => 'Você recebe visões e informações sobre criaturas e fenômenos em um raio de 1,5 km.'],
                    ['name' => 'Companheiro Animal',  'description' => 'Você tem um animal companheiro que o obedece e luta ao seu lado.'],
                    ['name' => 'Adaptação Natural',   'description' => 'Você recebe +5 em testes de Sobrevivência e não sofre efeitos negativos de clima natural.'],
                    ['name' => 'Veneno Natural',      'description' => 'Uma vez por cena, seu próximo ataque envenena o alvo, causando 1d4 de dano de Constituição.'],
                    ['name' => 'Afinidade Elemental', 'description' => 'Escolha um elemento (fogo, terra, água ou ar). Suas magias desse elemento custam 1 PM a menos.'],
                ],
                'available_spells'   => [
                    ['name' => 'Enredar',             'circle' => 1, 'mp_cost' => 1, 'description' => 'Plantas em uma área de 6m de raio agarram criaturas. CD Fortitude para resistir.'],
                    ['name' => 'Curar Ferimentos',    'circle' => 1, 'mp_cost' => 1, 'description' => 'Cura 1d8+mod. Sab de PV no alvo pelo toque.'],
                    ['name' => 'Falar com Animais',   'circle' => 1, 'mp_cost' => 1, 'description' => 'Você pode se comunicar com animais por 10 minutos por nível.'],
                    ['name' => 'Ventania',            'circle' => 1, 'mp_cost' => 1, 'description' => 'Um forte vento dispersa névoas, apaga chamas e dificulta o movimento.'],
                    ['name' => 'Produzir Chamas',     'circle' => 1, 'mp_cost' => 1, 'description' => 'Você cria chamas em sua mão que causam 1d6+nível de dano de fogo.'],
                ],
            ],

            'Guerreiro' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Ataque Especial',        'description' => 'Você pode substituir um de seus ataques por uma manobra ofensiva sem penalidade.'],
                    ['name' => 'Bloqueio com Escudo',    'description' => 'Quando usa escudo, você recebe +5 na Defesa (em vez de +2 ou +4 normais).'],
                    ['name' => 'Esquiva',                'description' => 'Você recebe +2 na Defesa e nos testes de Reflexos.'],
                    ['name' => 'Foco em Arma',           'description' => 'Escolha uma arma. Você recebe +2 nas jogadas de ataque com ela.'],
                    ['name' => 'Ataque Poderoso',        'description' => 'Você pode sofrer –2 no ataque para receber +1d6 de dano extra no acerto.'],
                    ['name' => 'Uso de Armadura Pesada', 'description' => 'Você pode usar armaduras pesadas sem receber penalidades de teste e sem redução do deslocamento.'],
                    ['name' => 'Combate com Duas Armas', 'description' => 'Você reduz a penalidade de lutar com duas armas para –2/–2 em vez de –4/–4.'],
                ],
                'available_spells'   => [],
            ],

            'Inventor' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => true,
                'spell_school'       => 'Arcana',
                'initial_spells'     => 2,
                'available_powers'   => [
                    ['name' => 'Construto',          'description' => 'Você pode criar um ajudante mecânico com 1 DV que o obedece. Custa 4h e materiais.'],
                    ['name' => 'Elixir',             'description' => 'Você pode preparar 2 elixires por dia com efeitos de magia de 1° círculo.'],
                    ['name' => 'Engenhoca',          'description' => 'Uma vez por cena, você cria um dispositivo com efeito aleatório de magia.'],
                    ['name' => 'Armadura Aprimorada','description' => 'Você pode adaptar armaduras. Escolha: +1 Defesa, silêncio ou +3m deslocamento.'],
                    ['name' => 'Arma Mágica',        'description' => 'Você pode encantar uma arma com +1 de ataque e dano por 24 horas.'],
                    ['name' => 'Análise Tática',     'description' => 'Você pode gastar 1 ação de movimento para analisar um inimigo e receber +2 no próximo ataque contra ele.'],
                ],
                'available_spells'   => [
                    ['name' => 'Mísseis Mágicos',  'circle' => 1, 'mp_cost' => 1, 'description' => 'Projéteis mágicos que causam 1d4+1 de dano de força.'],
                    ['name' => 'Escudo Arcano',    'circle' => 1, 'mp_cost' => 1, 'description' => '+4 na Defesa por 1 rodada/nível.'],
                    ['name' => 'Toque Chocante',   'circle' => 1, 'mp_cost' => 1, 'description' => 'Toque causa 1d6 por nível de dano elétrico (máx. 5d6).'],
                    ['name' => 'Detectar Magia',   'circle' => 1, 'mp_cost' => 1, 'description' => 'Detecta magias ativas e itens mágicos em 18m.'],
                ],
            ],

            'Ladino' => [
                'powers_at_creation' => 3,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Ataque Furtivo',      'description' => 'Quando ataca uma criatura desprevenida ou flanqueada, você causa +2d6 de dano extra.'],
                    ['name' => 'Evasão',              'description' => 'Quando passa em testes de Reflexos contra efeitos de área, você não sofre dano nenhum.'],
                    ['name' => 'Ladrão Habilidoso',   'description' => 'Você recebe +5 em testes de Ladragem e pode realizá-los como ação livre.'],
                    ['name' => 'Especialização',      'description' => 'Escolha uma perícia treinada. Você recebe +5 nela.'],
                    ['name' => 'Golpe Certeiro',      'description' => 'Uma vez por cena, um de seus ataques causa dano crítico automaticamente.'],
                    ['name' => 'Disfarce',            'description' => 'Você recebe +5 em Enganação para se disfarçar e o disfarce dura 1 dia.'],
                    ['name' => 'Veneno',              'description' => 'Você pode aplicar veneno em armas sem se arriscar. Causa efeito de nível 1 no alvo.'],
                ],
                'available_spells'   => [],
            ],

            'Lutador' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Soco Poderoso',        'description' => 'Seus ataques desarmados causam +1d6 de dano adicional.'],
                    ['name' => 'Técnica de Combate',   'description' => 'Você recebe +2 em manobras ofensivas (derrubar, desarmar, agarrar, empurrar).'],
                    ['name' => 'Resistência Interna',  'description' => 'Você recebe +5 em testes de Fortitude contra efeitos físicos e venenos.'],
                    ['name' => 'Golpe Imobilizante',   'description' => 'Quando acerta com um ataque desarmado, pode gastar 1 PM para prender o alvo.'],
                    ['name' => 'Esquiva Perfeita',     'description' => 'Uma vez por rodada, quando um ataque erra você por 5 ou menos, você pode fazer uma réplica imediata.'],
                    ['name' => 'Velocidade',           'description' => 'Seu deslocamento aumenta em +6m e você recebe +2 na Iniciativa.'],
                ],
                'available_spells'   => [],
            ],

            'Nobre' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Autoridade',     'description' => 'Você pode usar Diplomacia no lugar de Intimidar. Alvos que falham ficam dispostos a cooperar.'],
                    ['name' => 'Liderança',      'description' => 'Você atrai um seguidor de nível 1 que o serve lealmente. Pode recrutar mais com o tempo.'],
                    ['name' => 'Estrategista',   'description' => 'Uma vez por cena, você concede +2 no próximo teste a um aliado que possa ouvi-lo.'],
                    ['name' => 'Provocação',     'description' => 'Como ação padrão, você força um inimigo a atacar apenas você até o início de seu próximo turno.'],
                    ['name' => 'Influência',     'description' => 'Você recebe +5 em testes de Diplomacia e pode fazer Diplomacia em metade do tempo normal.'],
                    ['name' => 'Presença Nobre', 'description' => 'Criaturas com Int 3+ sentem sua autoridade. Elas hesitam 1 rodada antes de atacá-lo pela 1ª vez.'],
                ],
                'available_spells'   => [],
            ],

            'Paladino' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => true,
                'spell_school'       => 'Divina',
                'initial_spells'     => 1,
                'available_powers'   => [
                    ['name' => 'Aura de Coragem',   'description' => 'Aliados a até 9m são imunes a efeitos de medo enquanto você estiver consciente.'],
                    ['name' => 'Detectar o Mal',    'description' => 'Você pode detectar criaturas, objetos ou lugares de alinhamento maligno a até 18m.'],
                    ['name' => 'Cura pelas Mãos',   'description' => 'Você pode gastar 2 PM para curar 1d8+mod. Car de PV em um alvo pelo toque.'],
                    ['name' => 'Ira Sagrada',        'description' => 'Uma vez por cena, você recebe +2 em ataques e +1d6 de dano sagrado contra criaturas malignas por 1 rodada.'],
                    ['name' => 'Escudo Divino',      'description' => 'Você pode gastar 2 PM para conceder +2 na Defesa a um aliado adjacente por 1 rodada.'],
                    ['name' => 'Purificar',          'description' => 'Com um toque, você remove uma condição (envenenado, amedrontado ou paralisado) de uma criatura.'],
                ],
                'available_spells'   => [
                    ['name' => 'Bênção',           'circle' => 1, 'mp_cost' => 1, 'description' => 'Aliados recebem +1 nas jogadas de ataque e resistência por 1 min/nível.'],
                    ['name' => 'Proteção Divina',  'circle' => 1, 'mp_cost' => 1, 'description' => '+2 na Defesa e testes de resistência por 1 min/nível.'],
                    ['name' => 'Curar Ferimentos', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Cura 1d8+mod. Sab pelo toque.'],
                ],
            ],
        ];

        foreach ($data as $className => $classData) {
            DB::table('character_classes')
                ->where('name', $className)
                ->update([
                    'available_powers'   => json_encode($classData['available_powers']),
                    'powers_at_creation' => $classData['powers_at_creation'],
                    'is_spellcaster'     => $classData['is_spellcaster'],
                    'spell_school'       => $classData['spell_school'],
                    'available_spells'   => json_encode($classData['available_spells']),
                    'initial_spells'     => $classData['initial_spells'],
                ]);
        }
    }
}
