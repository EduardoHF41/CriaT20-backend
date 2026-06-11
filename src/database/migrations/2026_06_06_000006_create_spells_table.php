<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Banco de magias do Tormenta 20 (catálogo de referência).
     *
     * tradition    → arcana | divina
     * school       → Abjuração, Adivinhação, Conjuração, Encantamento,
     *                Evocação, Ilusionismo, Necromancia, Transmutação
     * circle       → círculo da magia (1 a 5)
     * mp_cost      → custo base em pontos de mana
     * execution    → tempo de execução (Padrão, Movimento, Completa, Reação, Livre)
     * range        → alcance (Pessoal, Toque, Curto, Médio, Longo, Ilimitado)
     * target_area  → alvo ou área
     * duration     → duração (Instantânea, Cena, Sustentada...)
     * resistance   → teste de resistência (Vontade, Fortitude, Reflexos, —)
     * enhancements → aprimoramentos: [{ "cost": int, "description": string }]
     */
    public function up(): void
    {
        Schema::create('spells', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tradition');
            $table->string('school');
            $table->unsignedTinyInteger('circle');
            $table->unsignedInteger('mp_cost');
            $table->string('execution')->default('Padrão');
            $table->string('range')->default('Curto');
            $table->string('target_area')->nullable();
            $table->string('duration')->default('Instantânea');
            $table->string('resistance')->nullable();
            $table->text('description');
            $table->json('enhancements')->nullable();
            $table->timestamps();

            $table->unique(['name', 'tradition']);
            $table->index(['tradition', 'school', 'circle']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spells');
    }
};
