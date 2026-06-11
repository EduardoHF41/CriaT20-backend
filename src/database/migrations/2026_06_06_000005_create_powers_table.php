<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Catálogo de poderes do Tormenta 20 (gerais, da Tormenta e raciais).
     * Poderes de classe permanecem em character_classes.available_powers (JSON).
     *
     * type          → geral | tormenta | racial
     * category      → para gerais: combate | destino | magia | concedido (nulo nos demais)
     * race_id       → para raciais: raça a que pertence
     * prerequisites → JSON estruturado:
     *   {
     *     "min_level": 3,
     *     "attributes": {"strength": 2},
     *     "skills": ["Luta"],            // perícias que precisam estar treinadas
     *     "powers": ["Ataque Poderoso"], // poderes que o personagem precisa ter
     *     "deity": "Khalmyr",            // divindade exigida
     *     "text": "requisito descritivo extra"
     *   }
     */
    public function up(): void
    {
        Schema::create('powers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('geral');
            $table->string('category')->nullable();
            $table->foreignId('race_id')->nullable()->constrained('races')->nullOnDelete();
            $table->json('prerequisites')->nullable();
            $table->text('description');
            $table->timestamps();

            $table->unique(['name', 'type', 'race_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('powers');
    }
};
