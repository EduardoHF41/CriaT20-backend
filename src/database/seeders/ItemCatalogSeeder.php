<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemCatalogSeeder extends Seeder
{
    /**
     * Catálogo de itens do Tormenta 20 (armaduras, escudos, equipamento geral,
     * consumíveis, materiais especiais, itens esotéricos e modificações).
     *
     * Colunas: [name, type, subtype, price (T$), spaces, data, description]
     */
    public function run(): void
    {
        $now = now();
        $rows = [];

        $add = function (string $name, string $type, ?string $subtype, int $price, float $spaces, ?array $data, string $desc) use (&$rows, $now) {
            $rows[] = [
                'name'        => $name,
                'type'        => $type,
                'subtype'     => $subtype,
                'price'       => $price,
                'spaces'      => $spaces,
                'data'        => $data ? json_encode($data) : null,
                'description' => $desc,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        };

        // ── Armaduras ──────────────────────────────────────────────────────────
        $add('Acolchoada', 'armor', 'leve', 10, 2, ['defense_bonus' => 1, 'armor_penalty' => 0],
            'Camadas de tecido grosso. Defesa +1.');
        $add('Couro', 'armor', 'leve', 25, 2, ['defense_bonus' => 2, 'armor_penalty' => 0],
            'Peças de couro endurecido. Defesa +2.');
        $add('Couro Batido', 'armor', 'leve', 80, 3, ['defense_bonus' => 3, 'armor_penalty' => 1],
            'Couro reforçado com rebites. Defesa +3.');
        $add('Brunea', 'armor', 'pesada', 100, 4, ['defense_bonus' => 4, 'armor_penalty' => 2],
            'Camisa de malha sob a roupa. Defesa +4.');
        $add('Cota de Malha', 'armor', 'pesada', 300, 5, ['defense_bonus' => 5, 'armor_penalty' => 3],
            'Malha de anéis de metal. Defesa +5.');
        $add('Armadura Completa', 'armor', 'pesada', 1500, 6, ['defense_bonus' => 6, 'armor_penalty' => 4],
            'Placas de aço articuladas. Defesa +6.');

        // ── Escudos ────────────────────────────────────────────────────────────
        $add('Broquel', 'shield', null, 5, 1, ['defense_bonus' => 1, 'armor_penalty' => 0],
            'Pequeno escudo de braço. Defesa +1.');
        $add('Escudo Leve', 'shield', null, 10, 1, ['defense_bonus' => 1, 'armor_penalty' => 1],
            'Escudo de madeira ou metal. Defesa +1.');
        $add('Escudo Pesado', 'shield', null, 20, 2, ['defense_bonus' => 2, 'armor_penalty' => 2],
            'Escudo grande e resistente. Defesa +2.');

        // ── Equipamento geral ──────────────────────────────────────────────────
        $add('Mochila', 'gear', 'recipiente', 2, 0, null, 'Bolsa de transporte; não conta seus próprios espaços.');
        $add('Corda de Cânhamo (15m)', 'gear', 'ferramenta', 1, 1, null, 'Corda resistente de 15 metros.');
        $add('Tocha', 'gear', 'iluminação', 1, 0, null, 'Ilumina 6m por 1 hora.');
        $add('Lampião', 'gear', 'iluminação', 10, 1, null, 'Ilumina 9m; consome óleo.');
        $add('Saco de Dormir', 'gear', 'acampamento', 1, 1, null, 'Bolsa de dormir para viagens.');
        $add('Kit de Escalada', 'gear', 'ferramenta', 30, 1, null, '+2 em testes de Atletismo para escalar.');
        $add('Gazuas', 'gear', 'ferramenta', 30, 0, null, 'Necessário para abrir fechaduras com Ladinagem.');
        $add('Rações de Viagem (1 dia)', 'gear', 'provisão', 1, 0, null, 'Comida seca para um dia.');
        $add('Cantil', 'gear', 'recipiente', 1, 0, null, 'Armazena água para um dia.');
        $add('Pé de Cabra', 'gear', 'ferramenta', 2, 1, null, '+2 em testes de Força para arrombar.');

        // ── Consumíveis ────────────────────────────────────────────────────────
        $add('Poção de Cura Menor', 'consumable', 'poção', 50, 0, ['effect' => 'Recupera 2d8+2 pontos de vida.'],
            'Líquido vermelho que sela ferimentos.');
        $add('Poção de Cura', 'consumable', 'poção', 150, 0, ['effect' => 'Recupera 4d8+4 pontos de vida.'],
            'Cura ferimentos graves.');
        $add('Antídoto', 'consumable', 'poção', 50, 0, ['effect' => 'Concede +5 contra um veneno por uma cena.'],
            'Neutraliza venenos comuns.');
        $add('Fogo Alquímico', 'consumable', 'alquímico', 30, 0, ['effect' => '2d6 de dano de fogo em área pequena.'],
            'Frasco que se incendeia ao quebrar.');
        $add('Ácido', 'consumable', 'alquímico', 20, 0, ['effect' => '1d6 de dano de ácido.'],
            'Frasco de ácido corrosivo.');
        $add('Água Benta', 'consumable', 'alquímico', 25, 0, ['effect' => '2d6 de dano a mortos-vivos e demônios.'],
            'Água abençoada por um templo.');

        // ── Materiais especiais ────────────────────────────────────────────────
        $add('Prata', 'material', null, 0, 0, ['effect' => 'Arma de prata ignora a redução de dano de licantropos e alguns mortos-vivos.', 'price_multiplier' => 2],
            'Aplicada a uma arma; dobra o preço base.');
        $add('Mitral', 'material', null, 0, 0, ['effect' => 'Equipamento de mitral reduz a penalidade de armadura em 3 e os espaços pela metade.', 'price_multiplier' => 5],
            'Metal élfico leve e resistente.');
        $add('Adamante', 'material', null, 0, 0, ['effect' => 'Concede redução de dano à armadura ou ignora RD de armas.', 'price_multiplier' => 10],
            'O metal mais duro conhecido.');
        $add('Madeira Negra', 'material', null, 0, 0, ['effect' => 'Itens de madeira tão resistentes quanto aço, porém mais leves.', 'price_multiplier' => 3],
            'Madeira mágica reforçada.');

        // ── Itens esotéricos ───────────────────────────────────────────────────
        $add('Pergaminho Arcano', 'esoteric', null, 100, 0, ['effect' => 'Permite lançar uma magia registrada uma única vez.'],
            'Pergaminho com uma magia inscrita.');
        $add('Varinha', 'esoteric', null, 300, 0, ['effect' => 'Armazena cargas de uma magia de baixo círculo.'],
            'Bastão mágico com cargas limitadas.');
        $add('Símbolo Sagrado', 'esoteric', null, 25, 0, ['effect' => 'Foco divino necessário para alguns poderes concedidos.'],
            'Amuleto de uma divindade.');
        $add('Reagentes Alquímicos', 'esoteric', null, 50, 0, ['effect' => 'Componentes para criar itens alquímicos com Ofício.'],
            'Conjunto de reagentes para alquimia.');

        // ── Modificações de itens ──────────────────────────────────────────────
        $add('Obra-Prima', 'modification', null, 0, 0, ['effect' => '+1 em testes de ataque (arma) ou −1 na penalidade (armadura).', 'price_add' => 300],
            'Acabamento superior feito por um mestre artesão.');
        $add('Reforçada', 'modification', null, 0, 0, ['effect' => 'Aumenta a resistência do item; mais difícil de quebrar.', 'price_add' => 100],
            'Estrutura reforçada contra danos.');
        $add('Cruel', 'modification', null, 0, 0, ['effect' => 'A arma causa +1 de dano, mas impõe desvantagem moral.', 'price_add' => 200],
            'Lâminas serrilhadas que dilaceram.');
        $add('Élfica', 'modification', null, 0, 0, ['effect' => 'Reduz os espaços do item; acabamento leve e gracioso.', 'price_add' => 150],
            'Artesanato élfico leve.');

        DB::table('items_catalog')->insert($rows);
    }
}
