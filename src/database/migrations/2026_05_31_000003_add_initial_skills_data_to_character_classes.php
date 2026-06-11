<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('character_classes', function (Blueprint $table) {
            // Estrutura:
            // fixed      → perícias obrigatórias (já treinadas, sem escolha)
            // or_groups  → grupos de escolha exclusiva: [[A, B], [C, D]]
            // free_count → quantas perícias adicionais o jogador escolhe livremente
            $table->json('initial_skills_data')->nullable()->after('initial_skills');
        });
    }

    public function down(): void
    {
        Schema::table('character_classes', function (Blueprint $table) {
            $table->dropColumn('initial_skills_data');
        });
    }
};
