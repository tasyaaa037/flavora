<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Nama kategori
        'categorie_type_id', // ID Tipe Kategori
    ];

    /**
     * Define a relationship with the CategorieType model.
     */
    public function categorieType()
    {
        return $this->belongsTo(CategorieType::class);
    }
}
