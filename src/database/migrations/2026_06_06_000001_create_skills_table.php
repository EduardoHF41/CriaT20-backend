<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Catálogo de referência das perícias do Tormenta 20.
     *
     * key_attribute → atributo-chave (strength|dexterity|constitution|intelligence|wisdom|charisma)
     * trained_only  → só pode ser usada se o personagem for treinado nela
     * armor_penalty → sofre a penalidade de armadura
     * is_variable   → admite especialização (Ofício, Atuação)
     */
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('key_attribute');
            $table->boolean('trained_only')->default(false);
            $table->boolean('armor_penalty')->default(false);
            $table->boolean('is_variable')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
