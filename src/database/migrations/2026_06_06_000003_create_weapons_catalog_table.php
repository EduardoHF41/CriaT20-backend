<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Catálogo de referência das armas do Tormenta 20 (Tabela de Armas).
     *
     * category           → melee (corpo a corpo) | ranged (à distância)
     * proficiency        → simples | marcial | exotica
     * threat_range       → menor valor no d20 que ameaça crítico (20 = só 20; 19 = 19-20)
     * crit_multiplier    → multiplicador de dano no crítico (2, 3, 4)
     * attack_attribute   → atributo padrão do ataque (strength p/ Luta, dexterity p/ Pontaria)
     * add_strength_damage→ soma o modificador de Força ao dano (corpo a corpo e armas de arremesso)
     * two_handed         → empunhada a duas mãos (1,5× mod. de Força no dano)
     * properties         → propriedades T20 (Ágil, Arremesso, Alongada, Duas Mãos...)
     */
    public function up(): void
    {
        Schema::create('weapons_catalog', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('category');
            $table->string('proficiency')->nullable();
            $table->string('damage_dice');
            $table->string('damage_type');
            $table->unsignedTinyInteger('threat_range')->default(20);
            $table->unsignedTinyInteger('crit_multiplier')->default(2);
            $table->string('range')->nullable();
            $table->string('attack_attribute')->default('strength');
            $table->boolean('add_strength_damage')->default(false);
            $table->boolean('two_handed')->default(false);
            $table->json('properties')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weapons_catalog');
    }
};
