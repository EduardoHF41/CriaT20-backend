<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('origins')->insert([

       
            [
                'name' => 'Amnésico',
                'description' => 'Você não se lembra de quem era antes de começar sua vida de aventureiro. Fragmentos do passado surgem ocasionalmente em sonhos ou lembranças confusas. Sua história perdida pode esconder segredos importantes sobre sua verdadeira identidade.',
                'origin_trait' => 'Lembranças Graduais'
            ],

            [
                'name' => 'Aristocrata',
                'description' => 'Você nasceu em uma família nobre ou influente, cercado por riqueza e privilégios. Aprendeu etiqueta, política e diplomacia desde cedo. Mesmo como aventureiro, carrega consigo o peso e as vantagens de seu nome.',
                'origin_trait' => 'Sangue Azul'
            ],
            
            [
                'name' => 'Artista',
                'description' => 'Você viveu da arte, seja música, pintura, teatro ou outra forma de expressão. Sua criatividade e sensibilidade o destacam entre as pessoas comuns. Muitas vezes, artistas também são excelentes comunicadores e observadores do mundo.',
                'origin_trait' => 'Dom Artístico'
            ],
            [
                'name' => 'Batedor',
                'description' => 'Você atuava como explorador ou mensageiro, percorrendo terrenos perigosos e desconhecidos. Sua habilidade de se mover rapidamente e observar o ambiente era essencial para sobreviver. Batedores são especialistas em reconhecer rotas e perigos.',
                'origin_trait' => 'À Prova de Tudo'
            ],

            [
                'name' => 'Capanga',
                'description' => 'Você trabalhou como guarda-costas, segurança ou executor para alguém poderoso. Acostumado a resolver problemas pela força, aprendeu a intimidar e proteger. Lealdade e força costumam definir seu passado.',
                'origin_trait' => 'Confissão'
            ],

            [
                'name' => 'Charlatão',
                'description' => 'Você viveu de truques, mentiras e manipulação. Seja vendendo falsas curas ou aplicando golpes elaborados, desenvolveu grande habilidade em enganar e persuadir pessoas. Sua astúcia é sua principal ferramenta.',
                'origin_trait' => 'Alpinista Social'
            ],

            [
                'name' => 'Circense',
                'description' => 'Você cresceu ou trabalhou em um circo itinerante. Acrobacias, apresentações e truques fazem parte da sua vida. Essa experiência lhe deu agilidade, criatividade e habilidade para entreter ou surpreender os outros.',
                'origin_trait' => 'Truque de Mágica'
            ],
            [
                'name' => 'Criminoso',
                'description' => 'Você viveu no submundo do crime, participando de roubos, contrabando ou outras atividades ilegais. Conhece bem as sombras das cidades e as regras não escritas do submundo. Essa experiência o tornou esperto e cauteloso.',
                'origin_trait' => 'Punguista'
            ],

            [
                'name' => 'Curandeiro',
                'description' => 'Você dedicou sua vida a cuidar dos feridos e doentes. Usando conhecimento de ervas, medicina ou fé, ajudou muitas pessoas necessitadas. Essa experiência lhe deu compaixão e conhecimento sobre o corpo e suas fraquezas.',
                'origin_trait' => 'Médico de Campo'
            ],

            [
                'name' => 'Eremita',
                'description' => 'Você viveu isolado da sociedade por muito tempo. Em solidão, aprendeu a sobreviver e refletir sobre o mundo. Esse isolamento pode ter sido escolha pessoal ou resultado de circunstâncias difíceis.',
                'origin_trait' => 'Busca Interior'
            ],

            [
                'name' => 'Escravo',
                'description' => 'Você passou parte da vida sob domínio de outra pessoa. O sofrimento e as dificuldades moldaram sua força e determinação. Sua liberdade, conquistada ou conquistada recentemente, tem grande valor para você.',
                'origin_trait' => 'Desejo de Liberdade'
            ],

            [
                'name' => 'Estudioso',
                'description' => 'Você dedicou sua vida ao aprendizado, seja em bibliotecas, templos ou academias. Livros e conhecimento foram seus maiores companheiros. Sua curiosidade e intelecto o levam a buscar respostas para os mistérios do mundo.',
                'origin_trait' => 'Palpite Fundamentado'
            ],

            [
                'name' => 'Fazendeiro',
                'description' => 'Você cresceu trabalhando na terra, cuidando de plantações e animais. A vida simples e o trabalho duro moldaram seu caráter. Essa experiência lhe deu resistência e uma visão prática da vida.',
                'origin_trait' => 'Água no Feijão'
            ],

            [
                'name' => 'Forasteiro',
                'description' => 'Você veio de uma terra distante ou cultura diferente da maioria das pessoas ao seu redor. Sua origem incomum faz com que seja visto com curiosidade ou desconfiança. Ao mesmo tempo, você traz conhecimentos e costumes únicos.',
                'origin_trait' => 'Cultura Exótica'
            ],

            [
                'name' => 'Gladiador',
                'description' => 'Você lutou em arenas para entreter multidões. Cada combate era uma questão de vida ou morte diante de espectadores. A experiência lhe deu habilidade em combate e familiaridade com a fama.',
                'origin_trait' => 'Pão e Circo'
            ],

            [
                'name' => 'Guarda',
                'description' => 'Você serviu como guarda de uma cidade, fortaleza ou autoridade importante. Sua função era manter a ordem e proteger os cidadãos. Isso lhe deu disciplina e experiência em lidar com conflitos.',
                'origin_trait' => 'Detetive'
            ],

            [
                'name' => 'Herdeiro',
                'description' => 'Você herdou riquezas, propriedades ou uma posição social importante. Essa herança pode trazer privilégios, mas também responsabilidades e inimigos. Sua vida mudou ao assumir esse legado.',
                'origin_trait' => 'Herança'
            ],

            [
                'name' => 'Herói Camponês',
                'description' => 'Você nasceu entre pessoas simples, mas realizou um ato heroico que mudou sua vida. Talvez tenha defendido sua aldeia ou enfrentado um grande perigo. Sua coragem o transformou em exemplo para outros.',
                'origin_trait' => 'Coração Heroico'
            ],

            [
                'name' => 'Marujo',
                'description' => 'Você passou anos navegando pelos mares de Arton. Tempestades, portos exóticos e perigos marítimos fizeram parte da sua vida. Essa experiência o tornou resistente e acostumado à vida em navios.',
                'origin_trait' => 'Passagem de Navio'
            ],

            [
                'name' => 'Mateiro',
                'description' => 'Você viveu nas fronteiras da civilização, explorando florestas e regiões selvagens. Conhece bem a natureza e seus perigos. Sua habilidade de sobreviver em ambientes hostis é sua maior força.',
                'origin_trait' => 'Vendedor de Carcaças'
            ],

            [
                'name' => 'Membro de Guilda',
                'description' => 'Você pertenceu a uma guilda ou organização profissional. Essa associação lhe trouxe contatos, treinamento e oportunidades. Mesmo como aventureiro, ainda pode manter laços com essa organização.',
                'origin_trait' => 'Rede de Contatos'
            ],

            [
                'name' => 'Mercador',
                'description' => 'Você trabalhou negociando bens, viajando entre cidades e mercados. Aprendeu a avaliar preços, negociar e lidar com diferentes culturas. Sua experiência lhe deu habilidade para negócios e diplomacia.',
                'origin_trait' => 'Negociação'
            ],

            [
                'name' => 'Minerador',
                'description' => 'Você passou anos explorando minas em busca de metais e pedras preciosas. O trabalho duro em túneis escuros exigia coragem e resistência. Essa vida moldou sua força física e perseverança.',
                'origin_trait' => 'Escavador'
            ],

            [
                'name' => 'Nômade',
                'description' => 'Você cresceu viajando constantemente, sem um lar fixo. Seu povo se move de lugar em lugar, seguindo rotas antigas ou buscando recursos. Essa vida lhe deu grande adaptabilidade.',
                'origin_trait' => 'Mochileiro'
            ],

            [
                'name' => 'Pivete',
                'description' => 'Você cresceu nas ruas, sobrevivendo com astúcia e rapidez. Pequenos furtos, truques e improviso eram necessários para sobreviver. Essa experiência o tornou rápido e desconfiado.',
                'origin_trait' => 'Quebra-Galho'
            ],

            [
                'name' => 'Refugiado',
                'description' => 'Você foi forçado a abandonar sua terra natal por guerra, desastre ou perseguição. A perda de seu lar marcou profundamente sua vida. Agora você busca reconstruir seu futuro em outro lugar.',
                'origin_trait' => 'Estoico'
            ],

            [
                'name' => 'Seguidor',
                'description' => 'Você dedicou sua vida a servir alguém importante ou uma causa maior. Essa devoção moldou sua identidade e valores. Mesmo agora, sua lealdade continua sendo parte fundamental de quem você é.',
                'origin_trait' => 'Antigo Mestre'
            ],

            [
                'name' => 'Selvagem',
                'description' => 'Você cresceu longe da civilização, vivendo em ambientes naturais ou tribais. A natureza sempre foi seu lar. Essa vida lhe deu instintos aguçados e grande resistência.',
                'origin_trait' => 'Vida Rústica'
            ],

            [
                'name' => 'Soldado',
                'description' => 'Você serviu em um exército ou milícia. Disciplina, treinamento e batalhas fazem parte da sua história. Essa experiência lhe ensinou estratégia, trabalho em equipe e sobrevivência em combate.',
                'origin_trait' => 'Influência Militar'
            ],

            [
                'name' => 'Taverneiro',
                'description' => 'Você administrou ou trabalhou em uma taverna. Entre viajantes, histórias e confusões, aprendeu muito sobre pessoas e rumores. Tavernes são centros de informação e encontros.',
                'origin_trait' => 'Gororoba'
            ],

            [
                'name' => 'Trabalhador',
                'description' => 'Você passou a vida realizando trabalhos pesados e honestos. Construção, transporte ou outras tarefas exigiam esforço constante. Essa rotina lhe deu força e perseverança.',
                'origin_trait' => 'Esforçado'
            ],
       
        ]);
    }
}
