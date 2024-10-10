<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientRecipeTable extends Migration
{
    public function up()
    {
        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade'); // Relasi ke tabel ingredients
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade'); // Relasi ke tabel recipes
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredient_recipe');
    }
}
