<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultToCategorieIdInCategorieTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categorie_types', function (Blueprint $table) {
            // Menambahkan default value pada kolom 'categorie_id'
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
        Schema::table('categorie_types', function (Blueprint $table) {
            // Menghapus default value dari kolom 'categorie_id'
            $table->unsignedBigInteger('categorie_id')->default(null)->change();
        });
    }
}
