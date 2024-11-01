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
        Schema::table('tips', function (Blueprint $table) {
            $table->text('steps')->after('description'); // Menambahkan kolom steps
        });
    }
    public function down()
    {
        Schema::table('tips', function (Blueprint $table) {
            $table->dropColumn('steps'); // Menghapus kolom steps jika rollback
        });
    }
};