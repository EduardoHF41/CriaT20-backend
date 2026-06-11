<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->string('nickname', 100)->nullable()->after('name');
            $table->string('gender', 40)->nullable()->after('nickname');
            $table->string('age', 30)->nullable()->after('gender');
            $table->string('height', 30)->nullable()->after('age');
            $table->string('weight', 30)->nullable()->after('height');
            $table->text('background')->nullable()->after('concept');
            $table->text('personality_traits')->nullable()->after('background');
        });
    }

    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn([
                'nickname',
                'gender',
                'age',
                'height',
                'weight',
                'background',
                'personality_traits',
            ]);
        });
    }
};
