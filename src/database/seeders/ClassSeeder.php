<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    // Dados da Tabela 1-3 (Tormenta 20, pág. 32-33)
    // hp_per_level = PV ganho por nível (igual ao PV do 1º nível)
    // mp_per_level = PM ganho por nível
    // Fórmula HP total: (hp_per_level + modificador_Con) × nível
    // Fórmula PM total: mp_per_level × nível

    public function run(): void
    {
        DB::table('character_classes')->insert([
            [
                'name'           => 'Arcanista',
                'description'    => 'Conjurador de magia arcana por estudo ou talento natural. Pode dominar diferentes escolas e estilos de magia. É uma das maiores fontes de poder mágico em Arton.',
                'hp_per_level'   => 8,
                'mp_per_level'   => 6,
                'key_attribute'  => 'Inteligência',
                'initial_skills' => 'Misticismo e Vontade, mais 2',
            ],
            [
                'name'           => 'Bárbaro',
                'description'    => 'Guerreiro primitivo que luta guiado por instinto e fúria. Confia em força bruta e resistência extraordinária. Muitos vêm de culturas tribais ou regiões selvagens.',
                'hp_per_level'   => 24,
                'mp_per_level'   => 3,
                'key_attribute'  => 'Força',
                'initial_skills' => 'mais 4',
            ],
            [
                'name'           => 'Bardo',
                'description'    => 'Artista, viajante e contador de histórias que canaliza magia por música ou performance. Inspira aliados e confunde inimigos. Conhecido por sua versatilidade e carisma.',
                'hp_per_level'   => 12,
                'mp_per_level'   => 4,
                'key_attribute'  => 'Inteligência ou Carisma',
                'initial_skills' => 'mais 8',
            ],
            [
                'name'           => 'Bucaneiro',
                'description'    => 'Aventureiro ousado frequentemente associado à vida no mar e à pirataria. Mestre da espada e da astúcia, confia em agilidade, sorte e audácia para vencer desafios.',
                'hp_per_level'   => 16,
                'mp_per_level'   => 4,
                'key_attribute'  => 'Destreza',
                'initial_skills' => 'Reflexos, mais 6',
            ],
            [
                'name'           => 'Caçador',
                'description'    => 'Especialista em rastrear, sobreviver na natureza e eliminar alvos perigosos. Conhece bem criaturas e ambientes selvagens. Comum em florestas, montanhas e regiões isoladas.',
                'hp_per_level'   => 16,
                'mp_per_level'   => 4,
                'key_attribute'  => 'Força ou Destreza',
                'initial_skills' => 'Luta ou Pontaria, Sobrevivência, mais 2',
            ],
            [
                'name'           => 'Cavaleiro',
                'description'    => 'Combatente disciplinado que segue códigos de honra e lealdade. Muitos servem reinos ou ordens militares. Sua presença no campo de batalha inspira aliados e impõe respeito.',
                'hp_per_level'   => 20,
                'mp_per_level'   => 3,
                'key_attribute'  => 'Força ou Destreza',
                'initial_skills' => 'Luta e Cavalgar, mais 2',
            ],
            [
                'name'           => 'Clérigo',
                'description'    => 'Servo devoto de uma divindade do panteão de Arton. Recebe poderes divinos para curar, proteger aliados e combater inimigos da fé. Age como representante de seu deus no mundo.',
                'hp_per_level'   => 16,
                'mp_per_level'   => 4,
                'key_attribute'  => 'Sabedoria',
                'initial_skills' => 'Religião e Vontade, mais 2',
            ],
            [
                'name'           => 'Druida',
                'description'    => 'Sacerdote da natureza que venera forças naturais e divindades do mundo selvagem. Protege o equilíbrio entre civilização e natureza. Seus poderes incluem magias naturais e habilidades ligadas a animais.',
                'hp_per_level'   => 16,
                'mp_per_level'   => 3,
                'key_attribute'  => 'Sabedoria',
                'initial_skills' => 'Sobrevivência, mais 4',
            ],
            [
                'name'           => 'Guerreiro',
                'description'    => 'Combatente altamente treinado que domina armas e técnicas de batalha. Especialista em combate direto e pode se adaptar a diferentes estilos de luta. Está entre os aventureiros mais comuns de Arton.',
                'hp_per_level'   => 20,
                'mp_per_level'   => 3,
                'key_attribute'  => 'Força ou Destreza',
                'initial_skills' => 'Luta e Pontaria, mais 4',
            ],
            [
                'name'           => 'Inventor',
                'description'    => 'Gênio criativo que utiliza ciência, alquimia e engenharia para criar dispositivos extraordinários. Suas engenhocas podem substituir magia ou produzir efeitos semelhantes. São raros e frequentemente excêntricos.',
                'hp_per_level'   => 12,
                'mp_per_level'   => 4,
                'key_attribute'  => 'Inteligência',
                'initial_skills' => 'Ofício e Vontade, mais 4',
            ],
            [
                'name'           => 'Ladino',
                'description'    => 'Especialista em furtividade, truques e habilidades sociais. Pode atuar como ladrão, espião, explorador ou caçador de tesouros. Sua versatilidade e astúcia são valiosas em muitas situações.',
                'hp_per_level'   => 12,
                'mp_per_level'   => 4,
                'key_attribute'  => 'Destreza ou Carisma',
                'initial_skills' => 'Ladragem e Reflexos, mais 8',
            ],
            [
                'name'           => 'Lutador',
                'description'    => 'Mestre do combate desarmado e das artes marciais. Usa o próprio corpo como instrumento de batalha. É um combatente rápido, disciplinado e perigoso em confrontos corpo a corpo.',
                'hp_per_level'   => 20,
                'mp_per_level'   => 4,
                'key_attribute'  => 'Força',
                'initial_skills' => 'Luta e Atletismo, mais 4',
            ],
            [
                'name'           => 'Nobre',
                'description'    => 'Líder natural, diplomata e estrategista. Em vez de depender apenas da força, utiliza influência, autoridade e inteligência para alcançar objetivos. Frequentemente comanda aliados ou manipula situações a seu favor.',
                'hp_per_level'   => 16,
                'mp_per_level'   => 3,
                'key_attribute'  => 'Força ou Carisma',
                'initial_skills' => 'Diplomacia ou Intimidação, Vontade, mais 4',
            ],
            [
                'name'           => 'Paladino',
                'description'    => 'Guerreiro sagrado que jurou servir à justiça e às divindades bondosas. Combina habilidade marcial com poderes divinos. É defensor dos inocentes e inimigo implacável do mal.',
                'hp_per_level'   => 20,
                'mp_per_level'   => 3,
                'key_attribute'  => 'Força ou Destreza',
                'initial_skills' => 'Fortitude, mais 2',
            ],
        ]);
    }
}
