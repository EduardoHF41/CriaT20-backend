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
        Schema::create('origin_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('origin_id')->constrained('origins')->cascadeOnDelete();
            $table->enum('category', ['item', 'skill', 'power', 'status']);
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_unique')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['origin_id', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('origin_features');
    }
};
