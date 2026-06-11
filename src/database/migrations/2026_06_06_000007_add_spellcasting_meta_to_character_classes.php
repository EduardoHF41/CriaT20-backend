<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * magic_tradition        → tradição mágica explícita: arcana | divina
     * spellcasting_attribute → atributo-chave da conjuração (intelligence|wisdom|charisma),
     *                          usado para calcular a CD das magias (10 + ½ nível + mod).
     */
    public function up(): void
    {
        Schema::table('character_classes', function (Blueprint $table) {
            $table->string('magic_tradition')->nullable()->after('spell_school');
            $table->string('spellcasting_attribute')->nullable()->after('magic_tradition');
        });
    }

    public function down(): void
    {
        Schema::table('character_classes', function (Blueprint $table) {
            $table->dropColumn(['magic_tradition', 'spellcasting_attribute']);
        });
    }
};
