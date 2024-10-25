<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tips', function (Blueprint $table) { // Nama tabel 'tips'
            $table->id();
            $table->string('title', 255); // Judul sesuai dengan model dan controller
            $table->text('description');  // Deskripsi sesuai
            $table->string('image_url')->nullable(); // Gambar opsional
            $table->timestamps();  // Menambahkan created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tips'); // Drop tabel 'tips' jika di-reverse
    }
};
