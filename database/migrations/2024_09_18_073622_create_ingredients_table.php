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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');
            $table->string('unit');
            $table->text('description')->nullable();
            $table->foreignId('recipe_id')->constrained();
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade'); // Relasi ke tabel ingredients
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade'); // Relasi ke tabel recipes
            $table->timestamps();
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
