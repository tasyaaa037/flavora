<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('categorie_types', function (Blueprint $table) {
            $table->unsignedBigInteger('categorie_id')->after('recipe_id');
        });
    }

    public function down()
    {
        Schema::table('categorie_types', function (Blueprint $table) {
            $table->dropColumn('categorie_id');
        });
    }

};
