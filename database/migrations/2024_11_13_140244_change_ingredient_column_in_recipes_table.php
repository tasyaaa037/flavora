<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIngredientColumnInRecipesTable extends Migration
{
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->json('ingredient')->nullable()->change(); // Pastikan nama kolom sesuai
        });
    }

    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->text('ingredient')->nullable()->change(); // Kembali ke tipe text jika rollback
        });
    }
}
