<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('races', function (Blueprint $table) {
            $table->json('attribute_modifiers')->nullable()->after('description');
        });

        Schema::table('character_classes', function (Blueprint $table) {
            $table->unsignedSmallInteger('hp_per_level')->default(12)->after('description');
            $table->unsignedSmallInteger('mp_per_level')->default(3)->after('hp_per_level');
            $table->string('key_attribute')->default('Força')->after('mp_per_level');
            $table->string('initial_skills')->nullable()->after('key_attribute');
        });
    }

    public function down(): void
    {
        Schema::table('races', function (Blueprint $table) {
            $table->dropColumn('attribute_modifiers');
        });

        Schema::table('character_classes', function (Blueprint $table) {
            $table->dropColumn(['hp_per_level', 'mp_per_level', 'key_attribute', 'initial_skills']);
        });
    }
};
