<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * temp_attack_modifier → modificador temporário somado a TODOS os ataques (buffs/debuffs)
     * temp_damage_modifier → modificador temporário somado a TODO o dano
     * extra_attacks        → ataques adicionais por rodada concedidos por poderes/habilidades
     */
    public function up(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->integer('temp_attack_modifier')->default(0)->after('weapons');
            $table->integer('temp_damage_modifier')->default(0)->after('temp_attack_modifier');
            $table->unsignedInteger('extra_attacks')->default(0)->after('temp_damage_modifier');
        });
    }

    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn(['temp_attack_modifier', 'temp_damage_modifier', 'extra_attacks']);
        });
    }
};
