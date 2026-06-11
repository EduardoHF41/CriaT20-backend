<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassPowersSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            // ── ARCANISTA ──────────────────────────────────────────────────────
            // Começa sabendo magias de 3 escolas escolhidas pelo jogador
            'Arcanista' => [
                'powers_at_creation'      => 2,
                'is_spellcaster'          => true,
                'spell_school'            => 'Arcana',
                'spell_schools_to_choose' => 3,
                'initial_spells'          => 3,
                'available_powers'   => [
                    ['name' => 'Magia Aprimorada',        'description' => 'Escolha uma escola de magia. A CD para resistir às suas magias dessa escola aumenta em +2.'],
                    ['name' => 'Mago de Batalha',          'description' => 'Você pode conjurar magias e realizar um ataque na mesma rodada, sem penalidade.'],
                    ['name' => 'Resistência Arcana',       'description' => 'Você recebe +5 em testes de resistência contra efeitos mágicos.'],
                    ['name' => 'Arcano Extra',             'description' => 'Você recebe +2 PM (pontos de magia) adicionais por nível.'],
                    ['name' => 'Foco em Magia',            'description' => 'Escolha uma magia. Você a conjura gastando 1 PM a menos (mínimo 1).'],
                    ['name' => 'Conjurar Monstro',         'description' => 'Você pode evocar criaturas para combater a seu lado como ação padrão, gastando PM.'],
                    ['name' => 'Magia Silenciosa',         'description' => 'Você pode lançar magias sem componente verbal gastando +1 PM.'],
                    ['name' => 'Magia Discreta',           'description' => 'Você pode lançar magias sem componente gestual gastando +1 PM.'],
                    ['name' => 'Ampliar Magia',            'description' => 'Você pode dobrar o alcance ou área de uma magia gastando +2 PM.'],
                    ['name' => 'Especialização em Escola', 'description' => 'Escolha uma escola. Você recebe +1 círculo efetivo nessa escola para efeitos de dano e duração.'],
                ],
                'available_spells' => [
                    // ── Abjuração ──
                    ['name' => 'Alarme',             'school' => 'Abjuração', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Cria um alarme mágico numa área de 6m que dura 8 horas e alerta se alguém entrar.'],
                    ['name' => 'Escudo Arcano',       'school' => 'Abjuração', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Barreira invisível concede +4 de Defesa e nega projéteis de Mísseis Mágicos por 1 rodada/nível.'],
                    ['name' => 'Resistência',         'school' => 'Abjuração', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Alvo recebe +1 em todos os testes de resistência por 1 min/nível.'],
                    ['name' => 'Tranca Arcana',       'school' => 'Abjuração', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Fecha e tranca uma porta ou cofre magicamente. Difícil de forçar ou arrombar.'],
                    ['name' => 'Dissipar Magia',      'school' => 'Abjuração', 'circle' => 3, 'mp_cost' => 5, 'description' => 'Anula um efeito mágico ativo numa área de 9m de raio. Teste de Misticismo oposto.'],
                    ['name' => 'Cúpula de Repulsão',  'school' => 'Abjuração', 'circle' => 4, 'mp_cost' => 7, 'description' => 'Cria uma cúpula esférica de 3m que repele criaturas de até tamanho Grande.'],
                    ['name' => 'Prisão Dimensional',  'school' => 'Abjuração', 'circle' => 5, 'mp_cost' => 9, 'description' => 'Aprisiona um ser em bolso dimensional intransponível por 1 dia/nível. CD Vontade.'],
                    // ── Adivinhação ──
                    ['name' => 'Detectar Magia',      'school' => 'Adivinhação', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Detecta a presença de efeitos mágicos e itens mágicos em 18m à sua frente por concentração.'],
                    ['name' => 'Entender Idiomas',    'school' => 'Adivinhação', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Você entende qualquer idioma falado ou escrito por 10 min/nível.'],
                    ['name' => 'Ler Mentes',          'school' => 'Adivinhação', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Lê os pensamentos superficiais de um alvo em 9m por concentração. CD Vontade.'],
                    ['name' => 'Localizar Objeto',    'school' => 'Adivinhação', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Sente a direção de um objeto específico a até 400m + 40m/nível.'],
                    ['name' => 'Visão Verdadeira',    'school' => 'Adivinhação', 'circle' => 3, 'mp_cost' => 5, 'description' => 'Enxerga através de ilusões, invisibilidade e formas alternadas em até 18m.'],
                    ['name' => 'Prever o Futuro',     'school' => 'Adivinhação', 'circle' => 4, 'mp_cost' => 7, 'description' => 'Recebe uma visão simbólica do futuro próximo, dando +4 em um teste à sua escolha.'],
                    ['name' => 'Visão Remota',        'school' => 'Adivinhação', 'circle' => 5, 'mp_cost' => 9, 'description' => 'Observa qualquer local familiar em qualquer plano por concentração.'],
                    // ── Conjuração ──
                    ['name' => 'Mão do Mago',         'school' => 'Conjuração', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Cria uma mão de força invisível que manipula objetos leves a até 9m por concentração.'],
                    ['name' => 'Invocar Familiar',    'school' => 'Conjuração', 'circle' => 1, 'mp_cost' => 2, 'description' => 'Convoca um animal pequeno como familiar mágico permanente que compartilha seus sentidos.'],
                    ['name' => 'Nuvem Ácida',         'school' => 'Conjuração', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Nuvem de ácido em área 3m de raio causa 2d6 de dano ácido por rodada por concentração.'],
                    ['name' => 'Teia',                'school' => 'Conjuração', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Cria teias grudentascobre área 3m; criaturas presas testam Força para se libertar.'],
                    ['name' => 'Invocar Monstro',     'school' => 'Conjuração', 'circle' => 3, 'mp_cost' => 5, 'description' => 'Evoca uma criatura com até 4 DV para combater ao seu lado por 1 rodada/nível.'],
                    ['name' => 'Portal Menor',        'school' => 'Conjuração', 'circle' => 4, 'mp_cost' => 7, 'description' => 'Cria um portal para local familiar a até 100 km por 1 rodada.'],
                    ['name' => 'Teleporte',           'school' => 'Conjuração', 'circle' => 5, 'mp_cost' => 9, 'description' => 'Transporta você e até 5 aliados para qualquer local que você já visitou no mesmo plano.'],
                    // ── Encantamento ──
                    ['name' => 'Sono',                'school' => 'Encantamento', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Criaturas com até 4 DV/nível em 9m adormecem por 1 min/nível. CD Vontade.'],
                    ['name' => 'Fascinar',            'school' => 'Encantamento', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Uma criatura inteligente fica fascinada e não age hostilmente por 1 min/nível. CD Vontade.'],
                    ['name' => 'Sugestão',            'school' => 'Encantamento', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Planta uma sugestão razoável na mente do alvo; ele obedece por 1 hora/nível. CD Vontade.'],
                    ['name' => 'Hipnotismo',          'school' => 'Encantamento', 'circle' => 3, 'mp_cost' => 5, 'description' => 'Um alvo fica hipnotizado e obedece a sugestões simples por 1 hora. CD Vontade.'],
                    ['name' => 'Confusão',            'school' => 'Encantamento', 'circle' => 4, 'mp_cost' => 7, 'description' => 'Criaturas em área 6m de raio agem aleatoriamente por 1 rodada/nível. CD Vontade.'],
                    ['name' => 'Dominação',           'school' => 'Encantamento', 'circle' => 5, 'mp_cost' => 9, 'description' => 'Controla as ações de um ser inteligente por 1 dia/nível. CD Vontade toda rodada.'],
                    // ── Evocação ──
                    ['name' => 'Mísseis Mágicos',     'school' => 'Evocação', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Lança 1 projétil mágico (+1 por 2 PM extras) que causa 1d4+1 de dano de força. Nunca erra.'],
                    ['name' => 'Luz',                 'school' => 'Evocação', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Ilumina uma área de 9m ao redor do alvo tocado por 1 hora/nível.'],
                    ['name' => 'Toque Chocante',      'school' => 'Evocação', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Toque causa 1d6 de dano de eletricidade por nível do arcanista (máx. 5d6).'],
                    ['name' => 'Bola de Fogo',        'school' => 'Evocação', 'circle' => 3, 'mp_cost' => 5, 'description' => 'Explosão de fogo numa área de 6m de raio. Causa 5d6 dano de fogo. CD Reflexos para metade.'],
                    ['name' => 'Relâmpago',           'school' => 'Evocação', 'circle' => 3, 'mp_cost' => 5, 'description' => 'Linha de eletricidade de 18m. Causa 5d6 de dano elétrico. CD Reflexos para metade.'],
                    ['name' => 'Tempestade de Gelo',  'school' => 'Evocação', 'circle' => 4, 'mp_cost' => 7, 'description' => 'Granizo mágico em área 6m de raio causa 5d6 de dano de frio e dificulta movimento por 1 rodada.'],
                    ['name' => 'Meteoro',             'school' => 'Evocação', 'circle' => 5, 'mp_cost' => 9, 'description' => '4 esferas de fogo explodem causando 6d6 de dano cada em áreas de 1,5m de raio.'],
                    // ── Ilusionismo ──
                    ['name' => 'Ilusão Fantasmagórica','school' => 'Ilusionismo', 'circle' => 1, 'mp_cost' => 2, 'description' => 'Cria uma ilusão visual e auditiva de até tamanho Médio. CD Vontade para desacreditar.'],
                    ['name' => 'Luz Fantasma',        'school' => 'Ilusionismo', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Ilusão de luz intensa encega temporariamente criaturas em 3m. CD Fortitude.'],
                    ['name' => 'Imagem Espelhada',    'school' => 'Ilusionismo', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Cria 1d4+1 imagens suas que deflectem ataques; cada acerto destrói uma imagem.'],
                    ['name' => 'Invisibilidade',      'school' => 'Ilusionismo', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Alvo fica invisível por 1 min/nível ou até atacar.'],
                    ['name' => 'Ilusão Maior',        'school' => 'Ilusionismo', 'circle' => 3, 'mp_cost' => 5, 'description' => 'Ilusão persistente de cenário ou criatura até tamanho Grande; subsiste sem concentração.'],
                    ['name' => 'Criar Ilusão',        'school' => 'Ilusionismo', 'circle' => 4, 'mp_cost' => 7, 'description' => 'Ilusão completa (visual, sonora, olfativa) de qualquer objeto ou criatura até tamanho Grande.'],
                    ['name' => 'Invisibilidade Total','school' => 'Ilusionismo', 'circle' => 5, 'mp_cost' => 9, 'description' => 'Você e até 5 aliados ficam invisíveis mesmo ao atacar por 1 min/nível.'],
                    // ── Necromancia ──
                    ['name' => 'Enfraquecer',         'school' => 'Necromancia', 'circle' => 1, 'mp_cost' => 1, 'description' => 'O alvo sofre –2 em testes de Força e –1 em rolagens de dano por 1 hora. CD Fortitude.'],
                    ['name' => 'Causar Medo',         'school' => 'Necromancia', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Alvo fica apavorado e foge pelo maior caminho seguro por 1d4 rodadas. CD Vontade.'],
                    ['name' => 'Drenar Vida',         'school' => 'Necromancia', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Drena 1d8+nível de PV do alvo (máx. 5d8); você cura metade do dano causado. CD Fortitude.'],
                    ['name' => 'Animação de Mortos',  'school' => 'Necromancia', 'circle' => 3, 'mp_cost' => 5, 'description' => 'Anima cadáveres ou esqueletos como mortos-vivos com DV ≤ nível sob seu controle.'],
                    ['name' => 'Murchar',             'school' => 'Necromancia', 'circle' => 4, 'mp_cost' => 7, 'description' => 'Alvo envelhece magicamente: –2 em todos os atributos físicos por 1 hora. CD Fortitude.'],
                    ['name' => 'Forma Espectral',     'school' => 'Necromancia', 'circle' => 5, 'mp_cost' => 9, 'description' => 'Torna-se incorpóreo por 1 min/nível: imune a dano físico, atravessa paredes.'],
                    // ── Transmutação ──
                    ['name' => 'Levitar',             'school' => 'Transmutação', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Alvo flutua verticalmente até 6m; move-se mentalmente por concentração.'],
                    ['name' => 'Arma Mágica',         'school' => 'Transmutação', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Uma arma recebe +1 de bônus de aprimoramento em ataque e dano por 1 hora/nível.'],
                    ['name' => 'Acelerar',            'school' => 'Transmutação', 'circle' => 3, 'mp_cost' => 5, 'description' => 'Alvo age duas vezes por rodada (ação padrão extra) e recebe +2 Defesa por 1 rodada/nível.'],
                    ['name' => 'Forma Gasosa',        'school' => 'Transmutação', 'circle' => 4, 'mp_cost' => 7, 'description' => 'Transforma o alvo em névoa: imune a ataques físicos, voa 3m/rodada, por 1 min/nível.'],
                    ['name' => 'Desintegrar',         'school' => 'Transmutação', 'circle' => 5, 'mp_cost' => 9, 'description' => 'Raio verde desintegra alvo não-mágico de tamanho Grande ou menor, ou causa 2d6/nível. CD Fortitude.'],
                ],
            ],

            // ── BÁRBARO ────────────────────────────────────────────────────────
            'Bárbaro' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Carga',              'description' => 'Ao entrar em Fúria, pode se mover até o dobro do deslocamento e atacar na mesma ação.'],
                    ['name' => 'Bravura',             'description' => 'Você é imune a efeitos de medo e pânico.'],
                    ['name' => 'Espírito Animal',     'description' => 'Escolha um animal totêmico e receba um bônus especial relacionado a ele durante a Fúria.'],
                    ['name' => 'Força Colossal',      'description' => 'Enquanto em Fúria, você recebe +4 em rolagens de dano corpo a corpo.'],
                    ['name' => 'Pele de Urso',        'description' => 'Enquanto em Fúria, você recebe Redução de Dano 4 contra ataques físicos.'],
                    ['name' => 'Golpe Selvagem',      'description' => 'Em Fúria, seus ataques são tratados como arma mágica para efeito de superar resistências.'],
                    ['name' => 'Fúria Ampliada',      'description' => 'Você pode entrar em Fúria mais uma vez por cena.'],
                    ['name' => 'Pele de Pedra',       'description' => 'Em Fúria, sua Defesa aumenta +2 e você recebe +10 PV temporários.'],
                    ['name' => 'Rugido',              'description' => 'Ao entrar em Fúria, todos os inimigos adjacentes testam Vontade ou ficam abalados por 1 rodada.'],
                    ['name' => 'Faro de Predador',    'description' => 'Você recebe +2 em Percepção e nunca é surpreendido se não estiver inconsciente.'],
                ],
                'available_spells'   => [],
            ],

            // ── BARDO ──────────────────────────────────────────────────────────
            // Escolhe 3 escolas arcanas iniciais (pode chegar a 6 com Aulas de Magia)
            'Bardo' => [
                'powers_at_creation'      => 3,
                'is_spellcaster'          => true,
                'spell_school'            => 'Arcana',
                'spell_schools_to_choose' => 3,
                'initial_spells'          => 2,
                'available_powers'   => [
                    ['name' => 'Canção de Batalha',     'description' => 'Enquanto performa, aliados a até 9m recebem +1 em ataques e dano.'],
                    ['name' => 'Fascínio',              'description' => 'Você fascina criaturas inteligentes com música ou performance. CD Vontade.'],
                    ['name' => 'Conhecimento Bardônico','description' => 'Você pode fazer testes de Conhecimento (qualquer especialidade) mesmo sem treinamento.'],
                    ['name' => 'Inspiração Heroica',    'description' => 'Concede +2 em testes de perícia ou ataque a um aliado por ação padrão, válido por 1 hora.'],
                    ['name' => 'Versatilidade',         'description' => 'Escolha uma perícia de outra classe. Você a trata como perícia treinada.'],
                    ['name' => 'Canção de Cura',        'description' => 'Sua performance cura 1d6 PV de aliados a até 9m por rodada de performance.'],
                    ['name' => 'Contrariar',            'description' => 'Sua música anula efeitos de medo e confusão em aliados a 9m.'],
                    ['name' => 'Discurso Inflamado',    'description' => 'Um aliado que ouça seu discurso recebe +4 em ataques e Defesa por 3 rodadas (1x/cena).'],
                    ['name' => 'Presença Carismática',  'description' => 'Você recebe +2 em todos os testes de perícias de Carisma e como bônus de Defesa social.'],
                    ['name' => 'Aulas de Magia',        'description' => 'Você desbloqueia mais 3 escolas arcanas, totalizando acesso a 6 escolas.'],
                ],
                'available_spells' => [
                    // Abjuração
                    ['name' => 'Alarme',               'school' => 'Abjuração',   'circle' => 1, 'mp_cost' => 1, 'description' => 'Alarme mágico em área de 6m, dura 8 horas e alerta se alguém entrar.'],
                    ['name' => 'Silêncio',             'school' => 'Abjuração',   'circle' => 2, 'mp_cost' => 3, 'description' => 'Área de 4m de raio fica em silêncio absoluto por concentração.'],
                    ['name' => 'Dissipar Magia',       'school' => 'Abjuração',   'circle' => 3, 'mp_cost' => 5, 'description' => 'Anula um efeito mágico ativo numa área de 9m de raio.'],
                    // Adivinhação
                    ['name' => 'Entender Idiomas',     'school' => 'Adivinhação', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Você entende qualquer idioma falado ou escrito por 10 min/nível.'],
                    ['name' => 'Detectar Magia',       'school' => 'Adivinhação', 'circle' => 1, 'mp_cost' => 1, 'description' => 'Detecta a presença de efeitos e itens mágicos em 18m.'],
                    ['name' => 'Ler Mentes',           'school' => 'Adivinhação', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Lê os pensamentos superficiais de um alvo em 9m. CD Vontade.'],
                    // Conjuração
                    ['name' => 'Invocar Instrumento',  'school' => 'Conjuração',  'circle' => 1, 'mp_cost' => 1, 'description' => 'Cria um instrumento musical mágico à sua escolha que dura 1 hora/nível.'],
                    ['name' => 'Teia',                 'school' => 'Conjuração',  'circle' => 2, 'mp_cost' => 3, 'description' => 'Cria teias grudentes em área 3m; criaturas presas testam Força para se libertar.'],
                    // Encantamento
                    ['name' => 'Sono',                 'school' => 'Encantamento','circle' => 1, 'mp_cost' => 1, 'description' => 'Criaturas com até 4 DV em 9m adormecem por 1 min/nível. CD Vontade.'],
                    ['name' => 'Fascinar',             'school' => 'Encantamento','circle' => 2, 'mp_cost' => 3, 'description' => 'Criaturas inteligentes ficam encantadas e não agem hostilmente por 1 min/nível.'],
                    ['name' => 'Sugestão',             'school' => 'Encantamento','circle' => 2, 'mp_cost' => 3, 'description' => 'Planta uma sugestão razoável na mente do alvo. CD Vontade.'],
                    // Evocação
                    ['name' => 'Mísseis Mágicos',      'school' => 'Evocação',    'circle' => 1, 'mp_cost' => 1, 'description' => 'Projéteis mágicos que causam 1d4+1 de dano de força e nunca erram.'],
                    ['name' => 'Luz',                  'school' => 'Evocação',    'circle' => 1, 'mp_cost' => 1, 'description' => 'Ilumina área de 9m por 1 hora/nível.'],
                    ['name' => 'Toque Chocante',       'school' => 'Evocação',    'circle' => 1, 'mp_cost' => 1, 'description' => 'Toque causa 1d6/nível de dano elétrico (máx. 5d6).'],
                    // Ilusionismo
                    ['name' => 'Ilusão Fantasmagórica','school' => 'Ilusionismo', 'circle' => 1, 'mp_cost' => 2, 'description' => 'Cria ilusão visual e auditiva de até tamanho Médio. CD Vontade.'],
                    ['name' => 'Invisibilidade',       'school' => 'Ilusionismo', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Alvo fica invisível por 1 min/nível ou até atacar.'],
                    ['name' => 'Imagem Espelhada',     'school' => 'Ilusionismo', 'circle' => 2, 'mp_cost' => 3, 'description' => 'Cria 1d4+1 imagens suas que deflectem ataques.'],
                    // Transmutação
                    ['name' => 'Acelerar',             'school' => 'Transmutação','circle' => 3, 'mp_cost' => 5, 'description' => 'Alvo age duas vezes por rodada e recebe +2 Defesa por 1 rodada/nível.'],
                    ['name' => 'Levitar',              'school' => 'Transmutação','circle' => 2, 'mp_cost' => 3, 'description' => 'Alvo flutua verticalmente até 6m por concentração.'],
                ],
            ],

            // ── BUCANEIRO ──────────────────────────────────────────────────────
            'Bucaneiro' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Fanfarronice',            'description' => 'Você pode usar Blefar no lugar de Intimidar para assustar inimigos.'],
                    ['name' => 'Golpe Baixo',             'description' => 'Quando ataca um oponente que não agiu neste combate, causa +2d6 de dano extra.'],
                    ['name' => 'Sorte do Bucaneiro',      'description' => 'Uma vez por cena, você pode rolar novamente qualquer teste e ficar com o melhor resultado.'],
                    ['name' => 'Saraivada',               'description' => 'Você pode realizar um ataque contra cada inimigo adjacente como uma ação padrão.'],
                    ['name' => 'Pique',                   'description' => 'Seu deslocamento aumenta em +3m e você recebe +2 em testes de Atletismo.'],
                    ['name' => 'Esquiva do Bucaneiro',    'description' => 'Quando se esquiva de um ataque corpo a corpo, pode fazer uma réplica imediata como reação.'],
                    ['name' => 'Enganar o Inimigo',       'description' => 'Você pode gastar 1 PM para tratar seu próximo ataque como ataque de flanqueamento.'],
                    ['name' => 'Vida Marítima',           'description' => '+5 em Atletismo (natação) e não sofre penalidade de armadura ao nadar.'],
                    ['name' => 'Desafio',                 'description' => 'Provoca um inimigo para que ele só ataque você, recebendo –2 em ataques a outros.'],
                ],
                'available_spells'   => [],
            ],

            // ── CAÇADOR ────────────────────────────────────────────────────────
            'Caçador' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Inimigo Predileto',   'description' => 'Escolha um tipo de criatura. Recebe +2 em ataques, dano e testes de perícia contra esse tipo.'],
                    ['name' => 'Companheiro Animal',  'description' => 'Você tem um animal companheiro fiel que o auxilia em combate e exploração.'],
                    ['name' => 'Rastreamento',        'description' => 'Você recebe +5 em testes de Sobrevivência para rastrear criaturas.'],
                    ['name' => 'Tiro Certeiro',       'description' => 'Seus ataques à distância ignoram a cobertura parcial do alvo.'],
                    ['name' => 'Emboscada',           'description' => 'Quando ataca de surpresa, você causa +1d6 de dano adicional por nível.'],
                    ['name' => 'Terreno Favorito',    'description' => 'Escolha um tipo de terreno. Recebe +2 em Percepção e Sobrevivência nele.'],
                    ['name' => 'Chuva de Flechas',    'description' => 'Você pode atirar em dois alvos diferentes na mesma ação, com –2 em cada ataque.'],
                    ['name' => 'Sombra da Floresta',  'description' => 'Em terreno natural, você recebe +5 em Furtividade e pode se camuflar mesmo sem cobertura.'],
                    ['name' => 'Instinto Selvagem',   'description' => 'Você nunca é surpreendido e recebe +2 em Percepção e Iniciativa.'],
                ],
                'available_spells'   => [],
            ],

            // ── CAVALEIRO ──────────────────────────────────────────────────────
            'Cavaleiro' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Ataque Montado',      'description' => 'Você recebe +2 nas jogadas de ataque quando está montado.'],
                    ['name' => 'Código de Honra',     'description' => 'Enquanto cumpre seu código de conduta, recebe +2 em todos os testes e +1 de Defesa.'],
                    ['name' => 'Investida Poderosa',  'description' => 'Quando faz uma investida montado, causa +2d6 de dano de bônus.'],
                    ['name' => 'Proteção',            'description' => 'Você pode usar reação para absorver um ataque destinado a aliado adjacente.'],
                    ['name' => 'Estandarte',          'description' => 'Aliados a até 9m recebem +1 moral em ataques enquanto você brande seu estandarte.'],
                    ['name' => 'Desafio',             'description' => 'Desafia um inimigo: ele recebe –2 em ataques que não sejam contra você.'],
                    ['name' => 'Cavalgar Aperfeiçoado','description' => 'Você pode montar e desmontar como ação livre e seu corcel obedece a comandos mentais.'],
                    ['name' => 'Golpe de Escudo',     'description' => 'Você pode usar o escudo como arma causando 1d6+For de dano sem perder a bônus de defesa.'],
                    ['name' => 'Vanguarda',           'description' => 'Enquanto estiver na dianteira, aliados a até 6m recebem +1 em Defesa.'],
                ],
                'available_spells'   => [],
            ],

            // ── CLÉRIGO ────────────────────────────────────────────────────────
            // Acesso livre a todas as magias divinas; sem seleção de escola
            'Clérigo' => [
                'powers_at_creation'      => 2,
                'is_spellcaster'          => true,
                'spell_school'            => 'Divina',
                'spell_schools_to_choose' => 0,
                'initial_spells'          => 2,
                'available_powers'   => [
                    ['name' => 'Canalizar Energia',    'description' => 'Gaste 2 PM para curar 1d6 PV de criaturas vivas (ou causar a mortos-vivos) em 9m de raio.'],
                    ['name' => 'Aura de Fé',           'description' => 'Aliados adjacentes recebem +1 nas rolagens de dano enquanto você estiver ativo.'],
                    ['name' => 'Expulsar Mortos-Vivos','description' => 'Ação padrão: mortos-vivos em 9m testam Vontade ou fogem por 1d4 rodadas.'],
                    ['name' => 'Domínio Divino',       'description' => 'Você ganha um poder especial relacionado ao domínio de sua divindade.'],
                    ['name' => 'Escudo da Fé',         'description' => 'Gaste 1 PM para conceder +2 na Defesa a um aliado adjacente por 1 rodada.'],
                    ['name' => 'Punição Divina',       'description' => 'Uma vez por cena, próximo ataque causa +2d8 de dano sagrado ou profano.'],
                    ['name' => 'Oração',               'description' => 'Ação padrão: aliados a 9m recebem +1 em ataques, dano e resistências por 1 rodada/nível.'],
                    ['name' => 'Santidade',            'description' => 'Você e aliados adjacentes recebem +2 nas resistências contra criaturas malignas.'],
                    ['name' => 'Palavra Sagrada',      'description' => 'Ação padrão; gaste 3 PM: criaturas malignas em 9m testam Vontade ou ficam atordoadas 1 rodada.'],
                ],
                'available_spells'   => [
                    ['name' => 'Curar Ferimentos',      'circle' => 1, 'mp_cost' => 1, 'description' => 'Toque: cura 1d8+mod.Sab PV no alvo; +1d8 por PM extra gasto.'],
                    ['name' => 'Bênção',                'circle' => 1, 'mp_cost' => 1, 'description' => 'Aliados a até 9m recebem +1 em ataques e resistências por 1 min/nível.'],
                    ['name' => 'Luz',                   'circle' => 1, 'mp_cost' => 1, 'description' => 'Ilumina área de 9m por 1 hora/nível.'],
                    ['name' => 'Proteção Divina',       'circle' => 1, 'mp_cost' => 1, 'description' => 'Alvo recebe +2 na Defesa e nos testes de resistência por 1 min/nível.'],
                    ['name' => 'Purificar Alimento',    'circle' => 1, 'mp_cost' => 1, 'description' => 'Remove toxinas e doenças de comida e água para até 12 pessoas.'],
                    ['name' => 'Detectar o Mal',        'circle' => 1, 'mp_cost' => 1, 'description' => 'Detecta auras malignas a até 18m por concentração.'],
                    ['name' => 'Infligir Ferimentos',   'circle' => 1, 'mp_cost' => 1, 'description' => 'Toque: causa 1d8+mod.Sab de dano necrótico; +1d8 por PM extra. Cura mortos-vivos.'],
                    ['name' => 'Guia',                  'circle' => 1, 'mp_cost' => 1, 'description' => 'Um alvo recebe +2 em um tipo de teste por 1 hora/nível.'],
                    // 2° Círculo
                    ['name' => 'Auxílio',               'circle' => 2, 'mp_cost' => 3, 'description' => 'Alvo recebe +1 em ataques, resistências e +1d8 PV temporários por 1 min/nível.'],
                    ['name' => 'Silêncio',              'circle' => 2, 'mp_cost' => 3, 'description' => 'Área de 4m de raio em silêncio absoluto por concentração. Impede magias com componente verbal.'],
                    ['name' => 'Consecrar',             'circle' => 2, 'mp_cost' => 3, 'description' => 'Santifica área de 6m: mortos-vivos recebem –1 em ataques e testes; criaturas sagradas recebem +1.'],
                    // 3° Círculo
                    ['name' => 'Cura Moderada',         'circle' => 3, 'mp_cost' => 5, 'description' => 'Toque: cura 2d8+mod.Sab PV; +2d8 por PM extra gasto.'],
                    ['name' => 'Remover Maldição',      'circle' => 3, 'mp_cost' => 5, 'description' => 'Remove um efeito de maldição do alvo tocado.'],
                    ['name' => 'Oração',                'circle' => 3, 'mp_cost' => 5, 'description' => 'Aliados a 9m recebem +1 em ataques, dano e resistências por 1 rodada/nível. Inimigos –1.'],
                    // 4° Círculo
                    ['name' => 'Restauração',           'circle' => 4, 'mp_cost' => 7, 'description' => 'Restaura um atributo perdido e remove condições como cego, surdo ou paralisia.'],
                    ['name' => 'Controle de Mortos-Vivos','circle' => 4, 'mp_cost' => 7, 'description' => 'Assume controle de mortos-vivos com até seu nível de DV total.'],
                    // 5° Círculo
                    ['name' => 'Ressurreição',          'circle' => 5, 'mp_cost' => 9, 'description' => 'Retorna um ser morto há no máximo 1 dia/nível à vida, restaurando todos os PV.'],
                    ['name' => 'Palavra Sagrada',       'circle' => 5, 'mp_cost' => 9, 'description' => 'Criaturas malignas em 9m ficam cegas, ensurdecidas ou paralisadas conforme seus DV.'],
                ],
            ],

            // ── DRUIDA ─────────────────────────────────────────────────────────
            // Escolhe 3 domínios primais iniciais; restrição permanente
            'Druida' => [
                'powers_at_creation'      => 2,
                'is_spellcaster'          => true,
                'spell_school'            => 'Primal',
                'spell_schools_to_choose' => 3,
                'initial_spells'          => 2,
                'available_powers'   => [
                    ['name' => 'Forma Selvagem',       'description' => 'Você pode se transformar em animal de até tamanho Grande. Dura 1 hora/nível.'],
                    ['name' => 'Comunhão',             'description' => 'Recebe visões e informações sobre criaturas e fenômenos num raio de 1,5 km.'],
                    ['name' => 'Companheiro Animal',   'description' => 'Você tem um animal companheiro que obedece e luta ao seu lado.'],
                    ['name' => 'Adaptação Natural',    'description' => '+5 em Sobrevivência; não sofre efeitos negativos de clima natural.'],
                    ['name' => 'Veneno Natural',       'description' => 'Uma vez por cena, seu próximo ataque envenena o alvo, causando 1d4 de dano de Constituição.'],
                    ['name' => 'Afinidade Elemental',  'description' => 'Escolha um elemento. Suas magias desse elemento custam 1 PM a menos.'],
                    ['name' => 'Caminhos da Natureza', 'description' => 'Você não deixa rastros em terrenos naturais e ignora terreno difícil natural.'],
                    ['name' => 'Pele de Pedra',        'description' => 'Em Forma Selvagem, você ganha RD 5/—.'],
                    ['name' => 'Vigor Natural',        'description' => 'Você cura 1 PV por nível no início de cada rodada em terreno natural.'],
                ],
                'available_spells' => [
                    // Domínio: Natureza
                    ['name' => 'Enredar',              'school' => 'Natureza',    'circle' => 1, 'mp_cost' => 1, 'description' => 'Plantas numa área de 6m de raio agarram criaturas por 1 min/nível. CD Fortitude.'],
                    ['name' => 'Falar com Animais',    'school' => 'Natureza',    'circle' => 1, 'mp_cost' => 1, 'description' => 'Você se comunica com animais por 10 min/nível.'],
                    ['name' => 'Detectar Veneno',      'school' => 'Natureza',    'circle' => 1, 'mp_cost' => 1, 'description' => 'Detecta a presença de veneno em objetos, criaturas ou alimentos numa área de 9m.'],
                    ['name' => 'Controlar Plantas',    'school' => 'Natureza',    'circle' => 2, 'mp_cost' => 3, 'description' => 'Controla plantas numa área de 9m, podendo movê-las e usá-las como obstáculos.'],
                    ['name' => 'Falar com Plantas',    'school' => 'Natureza',    'circle' => 2, 'mp_cost' => 3, 'description' => 'Você se comunica com plantas por 10 min/nível e pode pedir informações.'],
                    // Domínio: Cura
                    ['name' => 'Curar Ferimentos',     'school' => 'Cura',        'circle' => 1, 'mp_cost' => 1, 'description' => 'Toque: cura 1d8+mod.Sab PV no alvo; +1d8 por PM extra.'],
                    ['name' => 'Purificar Veneno',     'school' => 'Cura',        'circle' => 1, 'mp_cost' => 1, 'description' => 'Remove um veneno ou doença do alvo tocado.'],
                    ['name' => 'Cura Moderada',        'school' => 'Cura',        'circle' => 3, 'mp_cost' => 5, 'description' => 'Toque: cura 2d8+mod.Sab PV no alvo; +2d8 por PM extra.'],
                    ['name' => 'Regeneração',          'school' => 'Cura',        'circle' => 4, 'mp_cost' => 7, 'description' => 'Alvo regenera 2 PV por rodada por 1 min/nível. Restaura membros perdidos.'],
                    // Domínio: Elementos
                    ['name' => 'Produzir Chamas',      'school' => 'Elementos',   'circle' => 1, 'mp_cost' => 1, 'description' => 'Cria chamas na mão que causam 1d6+nível de dano de fogo (arremesso ou toque).'],
                    ['name' => 'Ventania',             'school' => 'Elementos',   'circle' => 1, 'mp_cost' => 1, 'description' => 'Vento forte dispersa névoas, apaga chamas e dificulta movimento por concentração.'],
                    ['name' => 'Tempestade de Relâmpagos','school' => 'Elementos','circle' => 3, 'mp_cost' => 5, 'description' => 'Relâmpagos atingem criaturas numa área de 6m causando 3d6 de dano elétrico. CD Reflexos.'],
                    ['name' => 'Controlar o Clima',    'school' => 'Elementos',   'circle' => 4, 'mp_cost' => 7, 'description' => 'Altera condições climáticas numa área de 3 km de raio.'],
                    // Domínio: Transformação
                    ['name' => 'Pele de Casca',        'school' => 'Transformação','circle' => 1, 'mp_cost' => 1, 'description' => 'Pele do alvo endurece como casca de árvore: +2 de Defesa por 1 min/nível.'],
                    ['name' => 'Forma Animal',         'school' => 'Transformação','circle' => 3, 'mp_cost' => 5, 'description' => 'Transforma-se em animal de até tamanho Médio por 1 hora/nível.'],
                    ['name' => 'Forma de Árvore',      'school' => 'Transformação','circle' => 3, 'mp_cost' => 5, 'description' => 'Você se transforma em árvore: imóvel mas imune a dano não mágico por 1 hora/nível.'],
                    ['name' => 'Polimorfismo',         'school' => 'Transformação','circle' => 4, 'mp_cost' => 7, 'description' => 'Transforma alvo em criatura de até tamanho Grande por 1 hora/nível. CD Vontade.'],
                    // Domínio: Proteção
                    ['name' => 'Espinhos',             'school' => 'Proteção',    'circle' => 1, 'mp_cost' => 1, 'description' => 'Cria campo de espinhos mágicos ao redor do alvo: atacantes sofrem 1d6 de perfuração.'],
                    ['name' => 'Proteção da Natureza', 'school' => 'Proteção',    'circle' => 2, 'mp_cost' => 3, 'description' => '+2 em Defesa e +2 em testes de resistência para aliados em terreno natural.'],
                    ['name' => 'Escudo de Galhos',     'school' => 'Proteção',    'circle' => 3, 'mp_cost' => 5, 'description' => 'Barreira de galhos mágicos concede Redução de Dano 5/fogo por 1 rodada/nível.'],
                ],
            ],

            // ── GUERREIRO ──────────────────────────────────────────────────────
            'Guerreiro' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Ataque Especial',         'description' => 'Você pode substituir um ataque por uma manobra ofensiva sem penalidade.'],
                    ['name' => 'Bloqueio com Escudo',     'description' => 'Com escudo, você recebe +5 na Defesa em vez de +2 ou +4 normais.'],
                    ['name' => 'Esquiva',                 'description' => 'Você recebe +2 na Defesa e nos testes de Reflexos.'],
                    ['name' => 'Foco em Arma',            'description' => 'Escolha uma arma. Você recebe +2 nas jogadas de ataque com ela.'],
                    ['name' => 'Ataque Poderoso',         'description' => 'Sofra –2 no ataque para receber +1d6 de dano extra no acerto.'],
                    ['name' => 'Uso de Armadura Pesada',  'description' => 'Você usa armaduras pesadas sem penalidades de teste e sem redução do deslocamento.'],
                    ['name' => 'Combate com Duas Armas',  'description' => 'Reduz a penalidade de lutar com duas armas para –2/–2 em vez de –4/–4.'],
                    ['name' => 'Especialização em Arma',  'description' => 'Escolha uma arma já com Foco. Você recebe +2 em rolagens de dano com ela.'],
                    ['name' => 'Resistência Física',      'description' => 'Você recebe +5 em testes de Fortitude contra efeitos físicos.'],
                    ['name' => 'Contra-Ataque',           'description' => 'Uma vez por rodada, quando um inimigo erra você por 5 ou menos, você pode atacá-lo imediatamente.'],
                ],
                'available_spells'   => [],
            ],

            // ── INVENTOR ───────────────────────────────────────────────────────
            'Inventor' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => true,
                'spell_school'       => 'Arcana',
                'initial_spells'     => 2,
                'available_powers'   => [
                    ['name' => 'Construto',           'description' => 'Cria um ajudante mecânico com 1 DV que obedece a comandos. Custa 4 horas e materiais.'],
                    ['name' => 'Elixir',              'description' => 'Você pode preparar 2 elixires por dia com efeitos de magias de 1° círculo.'],
                    ['name' => 'Engenhoca',           'description' => 'Uma vez por cena, cria um dispositivo com efeito de magia aleatório (1d6 para determinar).'],
                    ['name' => 'Armadura Aprimorada', 'description' => 'Adapta armaduras. Escolha: +1 Defesa, movimento silencioso ou +3m deslocamento.'],
                    ['name' => 'Arma Mágica',         'description' => 'Encanta uma arma com +1 de ataque e dano por 24 horas.'],
                    ['name' => 'Análise Tática',      'description' => 'Gaste 1 ação de movimento para analisar inimigo e receber +2 no próximo ataque contra ele.'],
                    ['name' => 'Bomba Alquímica',     'description' => 'Cria bombas que causam 1d6 de dano de ácido/fogo/gelo por nível, área 1,5m de raio.'],
                    ['name' => 'Escudo de Força',     'description' => 'Ativa um escudo energético: +4 Defesa por 1 min/nível, gasta 2 PM.'],
                ],
                'available_spells'   => [
                    ['name' => 'Mísseis Mágicos',    'circle' => 1, 'mp_cost' => 1, 'description' => 'Projéteis mágicos que causam 1d4+1 de dano de força e nunca erram.'],
                    ['name' => 'Escudo Arcano',      'circle' => 1, 'mp_cost' => 1, 'description' => '+4 na Defesa por 1 rodada/nível.'],
                    ['name' => 'Toque Chocante',     'circle' => 1, 'mp_cost' => 1, 'description' => 'Toque causa 1d6/nível de dano elétrico (máx. 5d6).'],
                    ['name' => 'Detectar Magia',     'circle' => 1, 'mp_cost' => 1, 'description' => 'Detecta magias ativas e itens mágicos em 18m.'],
                    ['name' => 'Arma Mágica',        'circle' => 2, 'mp_cost' => 3, 'description' => 'Uma arma recebe +1 de aprimoramento em ataque e dano por 1 hora/nível.'],
                    ['name' => 'Levitar',            'circle' => 2, 'mp_cost' => 3, 'description' => 'Alvo flutua verticalmente até 6m por concentração.'],
                    ['name' => 'Relâmpago',          'circle' => 3, 'mp_cost' => 5, 'description' => 'Linha de 18m causa 5d6 de dano elétrico. CD Reflexos para metade.'],
                ],
            ],

            // ── LADINO ─────────────────────────────────────────────────────────
            'Ladino' => [
                'powers_at_creation' => 3,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Ataque Furtivo',      'description' => 'Quando ataca criatura desprevenida ou flanqueada, causa +2d6 de dano extra.'],
                    ['name' => 'Evasão',              'description' => 'Quando passa em testes de Reflexos contra efeitos de área, não sofre dano nenhum.'],
                    ['name' => 'Ladrão Habilidoso',   'description' => '+5 em testes de Ladragem e pode realizá-los como ação livre.'],
                    ['name' => 'Especialização',      'description' => 'Escolha uma perícia treinada. Você recebe +5 nela.'],
                    ['name' => 'Golpe Certeiro',      'description' => 'Uma vez por cena, um de seus ataques causa dano crítico automaticamente.'],
                    ['name' => 'Disfarce',            'description' => '+5 em Enganação para se disfarçar; o disfarce dura 1 dia.'],
                    ['name' => 'Veneno',              'description' => 'Você pode aplicar veneno em armas sem risco. O veneno causa efeito de nível 1 no alvo.'],
                    ['name' => 'Esconder na Sombra',  'description' => 'Você pode se esconder em qualquer local com sombra, mesmo sob observação direta.'],
                    ['name' => 'Reflexos Ágeis',      'description' => '+2 em Iniciativa e você nunca fica surpreendido se estiver consciente.'],
                    ['name' => 'Vantagem Tática',     'description' => 'Quando flanqueia, o bônus de Ataque Furtivo aumenta em +1d6.'],
                ],
                'available_spells'   => [],
            ],

            // ── LUTADOR ────────────────────────────────────────────────────────
            'Lutador' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Soco Poderoso',        'description' => 'Seus ataques desarmados causam +1d6 de dano adicional.'],
                    ['name' => 'Técnica de Combate',   'description' => '+2 em manobras ofensivas (derrubar, desarmar, agarrar, empurrar).'],
                    ['name' => 'Resistência Interna',  'description' => '+5 em testes de Fortitude contra efeitos físicos e venenos.'],
                    ['name' => 'Golpe Imobilizante',   'description' => 'Ao acertar com ataque desarmado, pode gastar 1 PM para prender o alvo.'],
                    ['name' => 'Esquiva Perfeita',     'description' => 'Uma vez por rodada, quando ataque erra por 5 ou menos, você pode replicar imediatamente.'],
                    ['name' => 'Velocidade',           'description' => 'Deslocamento +6m e +2 na Iniciativa.'],
                    ['name' => 'Golpe Atordoante',     'description' => 'Gaste 2 PM após acertar: alvo testa Fortitude ou fica atordoado por 1 rodada.'],
                    ['name' => 'Cem Golpes',           'description' => 'Uma vez por cena, pode realizar uma sequência de 4 ataques desarmados como ação padrão.'],
                    ['name' => 'Pele de Ferro',        'description' => 'Você recebe RD 2/— enquanto não usa armadura.'],
                ],
                'available_spells'   => [],
            ],

            // ── NOBRE ──────────────────────────────────────────────────────────
            'Nobre' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => false,
                'spell_school'       => null,
                'initial_spells'     => 0,
                'available_powers'   => [
                    ['name' => 'Autoridade',       'description' => 'Você pode usar Diplomacia no lugar de Intimidar. Alvos que falham ficam dispostos a cooperar.'],
                    ['name' => 'Liderança',        'description' => 'Você atrai um seguidor de nível 1 que o serve lealmente. Pode recrutar mais com o tempo.'],
                    ['name' => 'Estrategista',     'description' => 'Uma vez por cena, concede +2 no próximo teste a um aliado que possa ouvi-lo.'],
                    ['name' => 'Provocação',       'description' => 'Força um inimigo a atacar apenas você até início de seu próximo turno.'],
                    ['name' => 'Influência',       'description' => '+5 em testes de Diplomacia e pode fazer Diplomacia em metade do tempo normal.'],
                    ['name' => 'Presença Nobre',   'description' => 'Criaturas inteligentes hesitam 1 rodada antes de atacá-lo pela 1ª vez.'],
                    ['name' => 'Aliança',          'description' => 'Você recebe +2 em ataques e Defesa enquanto um aliado estiver adjacente.'],
                    ['name' => 'Golpe de Estado',  'description' => 'Uma vez por cena, seu próximo ataque recebe +2d6 de dano extra (influência transformada em golpe).'],
                ],
                'available_spells'   => [],
            ],

            // ── PALADINO ───────────────────────────────────────────────────────
            'Paladino' => [
                'powers_at_creation' => 2,
                'is_spellcaster'     => true,
                'spell_school'       => 'Divina',
                'initial_spells'     => 1,
                'available_powers'   => [
                    ['name' => 'Aura de Coragem',   'description' => 'Aliados a até 9m são imunes a efeitos de medo enquanto você estiver consciente.'],
                    ['name' => 'Detectar o Mal',    'description' => 'Detecta criaturas, objetos ou locais de alinhamento maligno a até 18m.'],
                    ['name' => 'Cura pelas Mãos',   'description' => 'Gaste 2 PM: cura 1d8+mod.Car PV em um alvo pelo toque.'],
                    ['name' => 'Ira Sagrada',        'description' => 'Uma vez por cena, recebe +2 em ataques e +1d6 de dano sagrado contra criaturas malignas por 1 rodada.'],
                    ['name' => 'Escudo Divino',      'description' => 'Gaste 2 PM: concede +2 na Defesa a um aliado adjacente por 1 rodada.'],
                    ['name' => 'Purificar',          'description' => 'Com toque, remove uma condição (envenenado, amedrontado ou paralisado).'],
                    ['name' => 'Esmagar o Mal',      'description' => 'Quando usa Ira Sagrada, o dano extra aumenta para +2d6 contra mortos-vivos e demônios.'],
                    ['name' => 'Montaria Sagrada',   'description' => 'Sua montaria recebe PV extras iguais ao seu nível e +2 em Defesa.'],
                ],
                'available_spells'   => [
                    ['name' => 'Bênção',              'circle' => 1, 'mp_cost' => 1, 'description' => 'Aliados a 9m recebem +1 em ataques e resistências por 1 min/nível.'],
                    ['name' => 'Proteção Divina',     'circle' => 1, 'mp_cost' => 1, 'description' => '+2 na Defesa e em testes de resistência por 1 min/nível.'],
                    ['name' => 'Curar Ferimentos',    'circle' => 1, 'mp_cost' => 1, 'description' => 'Toque: cura 1d8+mod.Sab PV no alvo.'],
                    ['name' => 'Detectar o Mal',      'circle' => 1, 'mp_cost' => 1, 'description' => 'Detecta auras malignas a até 18m.'],
                    ['name' => 'Auxílio',             'circle' => 2, 'mp_cost' => 3, 'description' => 'Alvo recebe +1 em ataques, resistências e +1d8 PV temporários por 1 min/nível.'],
                    ['name' => 'Arma Sagrada',        'circle' => 2, 'mp_cost' => 3, 'description' => 'Uma arma causa +1d6 de dano sagrado contra criaturas malignas por 1 min/nível.'],
                    ['name' => 'Restauração',         'circle' => 4, 'mp_cost' => 7, 'description' => 'Remove condições e restaura atributos perdidos.'],
                ],
            ],
        ];

        // Atributo de conjuração por classe (usado no cálculo da CD das magias).
        $castingAttribute = [
            'Arcanista' => 'intelligence',
            'Bardo'     => 'charisma',
            'Clérigo'   => 'wisdom',
            'Druida'    => 'wisdom',
            'Inventor'  => 'intelligence',
            'Paladino'  => 'charisma',
        ];

        foreach ($data as $className => $classData) {
            // Tradição mágica explícita derivada da escola/fonte da classe.
            $tradition = null;
            if (!empty($classData['is_spellcaster'])) {
                $tradition = $classData['spell_school'] === 'Arcana' ? 'arcana' : 'divina';
            }

            DB::table('character_classes')
                ->where('name', $className)
                ->update([
                    'available_powers'        => json_encode($classData['available_powers']),
                    'powers_at_creation'      => $classData['powers_at_creation'],
                    'is_spellcaster'          => $classData['is_spellcaster'],
                    'spell_school'            => $classData['spell_school'],
                    'magic_tradition'         => $tradition,
                    'spellcasting_attribute'  => $classData['is_spellcaster'] ? ($castingAttribute[$className] ?? null) : null,
                    'available_spells'        => json_encode($classData['available_spells']),
                    'initial_spells'          => $classData['initial_spells'],
                    'spell_schools_to_choose' => $classData['spell_schools_to_choose'] ?? 0,
                ]);
        }
    }
}
