<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCategorieIdInRecipesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            // Mengubah kolom categorie_id untuk memberikan nilai default
            $table->unsignedBigInteger('categorie_id')->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            // Mengembalikan perubahan, misalnya tanpa default
            $table->unsignedBigInteger('categorie_id')->nullable()->change();
        });
    }
}
