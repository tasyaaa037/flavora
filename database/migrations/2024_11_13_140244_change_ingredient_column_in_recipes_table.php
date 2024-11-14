<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIngredientColumnInRecipesTable extends Migration
{
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->json('ingredients')->nullable()->change();
        });
    }


    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            // Mengembalikan kolom ingredients ke string dengan nullable
            $table->string('ingredient')->nullable()->change();
        });
    }
}
