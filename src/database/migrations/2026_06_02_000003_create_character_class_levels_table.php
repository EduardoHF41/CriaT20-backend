<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('character_class_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained('characters')->cascadeOnDelete();
            $table->foreignId('character_class_id')->constrained('character_classes')->cascadeOnDelete();
            $table->unsignedTinyInteger('level')->default(1);
            $table->timestamps();

            $table->unique(['character_id', 'character_class_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('character_class_levels');
    }
};
