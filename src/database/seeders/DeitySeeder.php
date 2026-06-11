<?php

namespace Database\Seeders;

use App\Models\Deity;
use Illuminate\Database\Seeder;

class DeitySeeder extends Seeder
{
    public function run(): void
    {
        $deities = [
            [
                'name' => 'Allihanna',
                'title' => 'A Senhora da Natureza',
                'description' => 'Deusa da natureza, dos druidas e dos ciclos da vida selvagem.',
                'obligations' => ['Respeitar e proteger a natureza', 'Honrar os ciclos naturais da vida e morte'],
                'restrictions' => ['Não pode poluir ou destruir ambientes naturais sem necessidade', 'Não pode comer carne de animais inteligentes'],
                'granted_powers' => ['Compaixão Natural', 'Forma Selvagem'],
                'devout_weapons' => ['Foice'],
            ],
            [
                'name' => 'Arsenal',
                'title' => 'O Deus da Guerra',
                'description' => 'Deus da guerra, da batalha justa e dos guerreiros.',
                'obligations' => ['Nunca recusar um desafio honrado', 'Manter-se sempre treinado para o combate'],
                'restrictions' => ['Não pode atacar um oponente desarmado ou indefeso', 'Não pode recuar de uma batalha justa'],
                'granted_powers' => ['Fôlego para a Batalha', 'Tropas de Choque'],
                'devout_weapons' => ['Machado de Batalha'],
            ],
            [
                'name' => 'Azgher',
                'title' => 'O Senhor do Sol',
                'description' => 'Deus do sol, do deserto e da verdade implacável.',
                'obligations' => ['Combater os mortos-vivos e as trevas', 'Espalhar a luz e a verdade'],
                'restrictions' => ['Não pode mentir', 'Não pode recusar abrigo a viajantes do deserto'],
                'granted_powers' => ['Castigo Solar', 'Sentidos do Predador'],
                'devout_weapons' => ['Cimitarra'],
            ],
            [
                'name' => 'Hyninn',
                'title' => 'O Deus da Trapaça',
                'description' => 'Deus dos ladrões, trapaceiros e da sorte.',
                'obligations' => ['Pregar uma peça em alguém ao menos uma vez por dia', 'Valorizar a esperteza acima da força'],
                'restrictions' => ['Não pode recusar uma aposta', 'Não pode revelar segredos de outro fiel de Hyninn'],
                'granted_powers' => ['Disfarce Divino', 'Distração Divina'],
                'devout_weapons' => ['Adaga'],
            ],
            [
                'name' => 'Kallyadranoch',
                'title' => 'O Senhor dos Dragões',
                'description' => 'Deus dos dragões, da tirania e da dominação.',
                'obligations' => ['Buscar poder e dominação', 'Honrar a linhagem dracônica'],
                'restrictions' => ['Não pode se submeter a quem considera inferior', 'Não pode demonstrar misericórdia desnecessária'],
                'granted_powers' => ['Sopro Dracônico', 'Resistência a Elemento'],
                'devout_weapons' => ['Lança'],
            ],
            [
                'name' => 'Khalmyr',
                'title' => 'O Deus da Justiça',
                'description' => 'Deus da justiça, da ordem e dos paladinos.',
                'obligations' => ['Defender os inocentes e punir os culpados', 'Manter sua palavra sempre'],
                'restrictions' => ['Não pode mentir ou agir de forma desonrosa', 'Não pode permitir que um injustiçado sofra sem agir'],
                'granted_powers' => ['Cura dos Devotos', 'Golpe Sagrado'],
                'devout_weapons' => ['Espada Longa'],
            ],
            [
                'name' => 'Lena',
                'title' => 'A Mãe Donzela',
                'description' => 'Deusa da vida, da fertilidade e da compaixão.',
                'obligations' => ['Proteger a vida e os indefesos', 'Oferecer ajuda a quem precisa'],
                'restrictions' => ['Não pode causar a morte de inocentes', 'Não pode recusar ajuda a um ferido'],
                'granted_powers' => ['Cura dos Devotos', 'Dádiva da Vida'],
                'devout_weapons' => ['Bordão'],
            ],
            [
                'name' => 'Lin-Wu',
                'title' => 'O Deus da Honra',
                'description' => 'Deus da honra, da disciplina e dos samurais.',
                'obligations' => ['Seguir um código de honra rígido', 'Respeitar a tradição e os ancestrais'],
                'restrictions' => ['Não pode agir com desonra ou covardia', 'Não pode quebrar um juramento'],
                'granted_powers' => ['Caminho da Espada', 'Disciplina'],
                'devout_weapons' => ['Katana (Espada Longa)'],
            ],
            [
                'name' => 'Marah',
                'title' => 'A Deusa da Paz',
                'description' => 'Deusa da paz, do amor e da harmonia.',
                'obligations' => ['Promover a paz e a reconciliação', 'Demonstrar amor e bondade'],
                'restrictions' => ['Não pode iniciar um conflito violento', 'Não pode portar armas de guerra em tempos de paz'],
                'granted_powers' => ['Aura de Paz', 'Compaixão de Marah'],
                'devout_weapons' => ['Nenhuma (pacifista)'],
            ],
            [
                'name' => 'Megalokk',
                'title' => 'O Deus dos Monstros',
                'description' => 'Deus dos monstros, da fúria e da natureza selvagem e brutal.',
                'obligations' => ['Demonstrar força e ferocidade', 'Respeitar a lei do mais forte'],
                'restrictions' => ['Não pode demonstrar fraqueza', 'Não pode poupar quem o desafia'],
                'granted_powers' => ['Fúria Bestial', 'Brado Aterrorizante'],
                'devout_weapons' => ['Clava'],
            ],
            [
                'name' => 'Nimb',
                'title' => 'O Deus da Loucura',
                'description' => 'Deus do caos, da sorte e da imprevisibilidade.',
                'obligations' => ['Agir de forma imprevisível', 'Abraçar o caos e o acaso'],
                'restrictions' => ['Não pode seguir rotinas rígidas', 'Não pode recusar um ato impulsivo do destino'],
                'granted_powers' => ['Sorte de Nimb', 'Caos Mágico'],
                'devout_weapons' => ['Qualquer arma improvisada'],
            ],
            [
                'name' => 'Oceano',
                'title' => 'O Senhor dos Mares',
                'description' => 'Deus dos mares, das tempestades e dos marinheiros.',
                'obligations' => ['Respeitar e proteger os mares', 'Ajudar marinheiros em perigo'],
                'restrictions' => ['Não pode poluir as águas', 'Não pode abandonar um companheiro no mar'],
                'granted_powers' => ['Fôlego Aquático', 'Filho dos Mares'],
                'devout_weapons' => ['Tridente'],
            ],
            [
                'name' => 'Sszzaas',
                'title' => 'O Deus da Traição',
                'description' => 'Deus da traição, das serpentes e das conspirações.',
                'obligations' => ['Tecer intrigas e manipular os outros', 'Buscar poder pela traição'],
                'restrictions' => ['Não pode ser leal além de seus próprios interesses', 'Não pode confiar plenamente em alguém'],
                'granted_powers' => ['Presas Venenosas', 'Palavras Sussurradas'],
                'devout_weapons' => ['Chicote'],
            ],
            [
                'name' => 'Tanna-Toh',
                'title' => 'A Deusa do Conhecimento',
                'description' => 'Deusa do conhecimento, da civilização e dos sábios.',
                'obligations' => ['Buscar e preservar o conhecimento', 'Difundir a civilização e a cultura'],
                'restrictions' => ['Não pode destruir livros ou fontes de saber', 'Não pode recusar o ensino a quem busca aprender'],
                'granted_powers' => ['Conhecimento Enciclopédico', 'Erudição'],
                'devout_weapons' => ['Bordão'],
            ],
            [
                'name' => 'Tenebra',
                'title' => 'A Senhora da Noite',
                'description' => 'Deusa da noite, da lua e dos mistérios das trevas.',
                'obligations' => ['Honrar a noite e seus mistérios', 'Proteger aqueles que vivem nas sombras'],
                'restrictions' => ['Não pode trair os segredos confiados', 'Não pode agir contra os mortos-vivos inteligentes aliados'],
                'granted_powers' => ['Manto da Noite', 'Visão nas Trevas'],
                'devout_weapons' => ['Foice'],
            ],
            [
                'name' => 'Thwor',
                'title' => 'O Deus da Tirania',
                'description' => 'Deus da guerra brutal, da conquista e da escravidão (deus dos orcs).',
                'obligations' => ['Conquistar e dominar pela força', 'Liderar pela imposição'],
                'restrictions' => ['Não pode demonstrar piedade aos derrotados', 'Não pode se curvar a um igual'],
                'granted_powers' => ['Brado de Guerra', 'Liderança Brutal'],
                'devout_weapons' => ['Machado Grande'],
            ],
            [
                'name' => 'Thyatis',
                'title' => 'O Deus da Ressurreição',
                'description' => 'Deus da magia, da ressurreição e do renascimento.',
                'obligations' => ['Preservar o equilíbrio entre vida e morte', 'Estudar e respeitar a magia'],
                'restrictions' => ['Não pode abusar do poder da ressurreição', 'Não pode criar mortos-vivos'],
                'granted_powers' => ['Centelha da Vida', 'Domínio da Magia'],
                'devout_weapons' => ['Adaga'],
            ],
            [
                'name' => 'Valkaria',
                'title' => 'A Deusa da Ambição',
                'description' => 'Deusa da ambição, da humanidade e da superação.',
                'obligations' => ['Buscar sempre superar seus limites', 'Perseguir seus sonhos e ambições'],
                'restrictions' => ['Não pode se acomodar ou desistir de um objetivo', 'Não pode impedir alguém de buscar seus sonhos'],
                'granted_powers' => ['Ambição Desmedida', 'Vontade Indômita'],
                'devout_weapons' => ['Espada Curta'],
            ],
            [
                'name' => 'Wynna',
                'title' => 'A Deusa da Magia',
                'description' => 'Deusa da magia arcana e de todos os conjuradores.',
                'obligations' => ['Estudar e disseminar a magia', 'Proteger as fontes de magia'],
                'restrictions' => ['Não pode destruir itens ou conhecimentos mágicos', 'Não pode negar magia a quem dela necessita para o bem'],
                'granted_powers' => ['Dádiva Mágica', 'Surto Arcano'],
                'devout_weapons' => ['Adaga'],
            ],
            [
                'name' => 'Aharadak',
                'title' => 'A Tormenta',
                'description' => 'A entidade caótica e destruidora conhecida como a Tormenta.',
                'obligations' => ['Espalhar o caos e a destruição', 'Servir à expansão da Tormenta'],
                'restrictions' => ['Não pode agir em prol da ordem ou da preservação', 'Sofre rejeição e perseguição da sociedade'],
                'granted_powers' => ['Poderes da Tormenta'],
                'devout_weapons' => ['Qualquer'],
            ],
        ];

        foreach ($deities as $deity) {
            Deity::updateOrCreate(['name' => $deity['name']], $deity);
        }
    }
}
