<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Catálogo de itens do Tormenta 20 (exceto armas, que ficam em weapons_catalog).
     *
     * type    → armor | shield | gear | consumable | material | esoteric | modification
     * subtype → categoria interna (ex.: armor: 'leve'|'pesada'; gear: 'ferramenta')
     * price   → preço em T$ (tibares)
     * spaces  → espaços de carga ocupados (regra T20; itens pequenos podem ocupar 0)
     * data    → atributos específicos do tipo, ex.:
     *   armor  → { "defense_bonus": 2, "armor_penalty": 1, "max_dex": null }
     *   shield → { "defense_bonus": 1, "armor_penalty": 1 }
     *   consumable → { "effect": "Recupera 2d8+2 PV." }
     *   material   → { "effect": "...", "price_multiplier": 2 }
     *   modification → { "effect": "...", "price_add": 150 }
     */
    public function up(): void
    {
        Schema::create('items_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type');
            $table->string('subtype')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->decimal('spaces', 4, 1)->default(1);
            $table->json('data')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['type', 'subtype']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items_catalog');
    }
};
