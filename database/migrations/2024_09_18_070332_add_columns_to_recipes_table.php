<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->string('title');
            $table->text('description');
            $table->text('instructions');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('prep_time');
            $table->integer('cook_time');
            $table->integer('servings');
            
            // Optionally add foreign key constraints if necessary
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
            $table->dropColumn([
                'title',
                'description',
                'instructions',
                'image',
                'category_id',
                'user_id',
                'prep_time',
                'cook_time',
                'servings',
            ]);
        });
    }
}
