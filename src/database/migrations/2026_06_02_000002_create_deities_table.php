<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('title')->nullable();          // ex: "Deus da Guerra"
            $table->text('description')->nullable();
            $table->json('obligations')->nullable();        // obrigações (array de strings)
            $table->json('restrictions')->nullable();       // restrições (array de strings)
            $table->json('granted_powers')->nullable();     // poderes concedidos
            $table->json('devout_weapons')->nullable();     // armas preferidas (opcional)
            $table->boolean('is_homebrew')->default(false);
            $table->timestamps();
        });

        Schema::table('characters', function (Blueprint $table) {
            $table->foreignId('deity_id')->nullable()->after('deity')->constrained('deities')->nullOnDelete();
            $table->json('deity_obligations')->nullable()->after('deity_id'); // obrigações aceitas pelo personagem
        });
    }

    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropForeign(['deity_id']);
            $table->dropColumn(['deity_id', 'deity_obligations']);
        });

        Schema::dropIfExists('deities');
    }
};
