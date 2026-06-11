<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Mesas de jogo (campanhas) para o Painel do Mestre.
     *
     * gm_user_id  → mestre da mesa
     * invite_code → código que os jogadores usam para entrar
     */
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('gm_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('invite_code', 12)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
