<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIngredientToRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            // Modifikasi kolom 'ingredient' jika kolom sudah ada
            $table->text('ingredient')->nullable()->change();
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
            // Mengembalikan kolom 'ingredient' ke tipe sebelumnya jika rollback
            $table->string('ingredient')->nullable()->change();
        });
    }
}
