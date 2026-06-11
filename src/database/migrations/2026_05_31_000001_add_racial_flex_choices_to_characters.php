<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            // Armazena quais atributos o jogador escolheu receber o bônus racial flexível
            // Ex: Humano +1 em 3 attrs → ["strength","intelligence","charisma"]
            $table->json('racial_flex_choices')->nullable()->after('charisma');
        });
    }

    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn('racial_flex_choices');
        });
    }
};
