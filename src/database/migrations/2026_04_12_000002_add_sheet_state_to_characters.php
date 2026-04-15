<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->smallInteger('current_hp')->nullable()->after('max_hp');
            $table->smallInteger('current_mp')->nullable()->after('max_mp');
            $table->unsignedSmallInteger('money_gold')->default(0)->after('displacement');
            $table->unsignedSmallInteger('money_silver')->default(0)->after('money_gold');
            $table->unsignedSmallInteger('money_copper')->default(0)->after('money_silver');
            $table->json('weapons')->nullable()->after('equipment');
        });
    }

    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn([
                'current_hp', 'current_mp',
                'money_gold', 'money_silver', 'money_copper',
                'weapons',
            ]);
        });
    }
};
