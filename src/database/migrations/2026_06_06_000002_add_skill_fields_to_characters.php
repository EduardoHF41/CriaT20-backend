<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * armor_penalty  → penalidade de armadura aplicada às perícias marcadas (valor positivo, subtraído no cálculo)
     * skill_bonuses  → bônus variados por perícia: { "Acrobacia": 2, "Ofício (Alquimia)": 1 }
     */
    public function up(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->unsignedInteger('armor_penalty')->default(0)->after('trained_skills');
            $table->json('skill_bonuses')->nullable()->after('armor_penalty');
        });
    }

    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn(['armor_penalty', 'skill_bonuses']);
        });
    }
};
