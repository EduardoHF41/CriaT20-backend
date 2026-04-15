<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->foreignId('origin_id')->nullable()->after('class_id')->constrained('origins')->nullOnDelete();

            $table->string('deity')->nullable()->after('name');
            $table->text('concept')->nullable()->after('deity');

            $table->enum('attribute_method', ['point_buy', 'rolled'])->default('point_buy')->after('concept');
            $table->tinyInteger('strength')->default(0)->after('attribute_method');
            $table->tinyInteger('dexterity')->default(0)->after('strength');
            $table->tinyInteger('constitution')->default(0)->after('dexterity');
            $table->tinyInteger('intelligence')->default(0)->after('constitution');
            $table->tinyInteger('wisdom')->default(0)->after('intelligence');
            $table->tinyInteger('charisma')->default(0)->after('wisdom');

            $table->json('origin_benefits')->nullable()->after('charisma');
            $table->json('trained_skills')->nullable()->after('origin_benefits');
            $table->json('powers')->nullable()->after('trained_skills');
            $table->json('equipment')->nullable()->after('powers');
            $table->json('spells')->nullable()->after('equipment');

            $table->integer('max_hp')->default(1)->after('spells');
            $table->integer('max_mp')->default(0)->after('max_hp');
            $table->integer('defense')->default(10)->after('max_mp');
            $table->string('size')->default('Médio')->after('defense');
            $table->string('displacement')->default('9m')->after('size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropConstrainedForeignId('origin_id');
            $table->dropColumn([
                'deity',
                'concept',
                'attribute_method',
                'strength',
                'dexterity',
                'constitution',
                'intelligence',
                'wisdom',
                'charisma',
                'origin_benefits',
                'trained_skills',
                'powers',
                'equipment',
                'spells',
                'max_hp',
                'max_mp',
                'defense',
                'size',
                'displacement',
            ]);
        });
    }
};
