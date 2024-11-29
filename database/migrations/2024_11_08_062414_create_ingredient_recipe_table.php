<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Periksa apakah tabel sudah ada sebelum membuatnya
        if (!Schema::hasTable('ingredient_recipe')) {
            Schema::create('ingredient_recipe', function (Blueprint $table) {
                $table->id();
                $table->foreignId('recipe_id')
                      ->constrained('recipes')
                      ->onDelete('cascade');
                $table->foreignId('ingredient_id')
                      ->constrained('ingredients')
                      ->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_recipe');
    }
};
