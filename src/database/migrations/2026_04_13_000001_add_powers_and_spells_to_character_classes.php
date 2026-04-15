<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('character_classes', function (Blueprint $table) {
            $table->json('available_powers')->nullable()->after('initial_skills');
            $table->unsignedTinyInteger('powers_at_creation')->default(2)->after('available_powers');
            $table->boolean('is_spellcaster')->default(false)->after('powers_at_creation');
            $table->string('spell_school')->nullable()->after('is_spellcaster');
            $table->json('available_spells')->nullable()->after('spell_school');
            $table->unsignedTinyInteger('initial_spells')->default(0)->after('available_spells');
        });
    }

    public function down(): void
    {
        Schema::table('character_classes', function (Blueprint $table) {
            $table->dropColumn([
                'available_powers',
                'powers_at_creation',
                'is_spellcaster',
                'spell_school',
                'available_spells',
                'initial_spells',
            ]);
        });
    }
};
