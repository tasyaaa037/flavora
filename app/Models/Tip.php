<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    use HasFactory;

    // Nama tabel disesuaikan dengan 'tips'
    protected $table = 'tips';

    // Tentukan kolom-kolom yang dapat diisi (fillable)
    protected $fillable = [
        'title',       // Sesuaikan dengan migration dan controller
        'description', // Sesuaikan
        'image_url'    // Sesuaikan
    ];

    // Jika ingin menonaktifkan timestamps (created_at, updated_at)
    // public $timestamps = false;
}
