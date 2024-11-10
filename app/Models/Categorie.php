<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'categorie_type_id']; // Pastikan kolom yang dapat diisi

    /**
     * Relasi ke CategorieType.
     */
    public function categorieType()
    {
        return $this->belongsTo(CategorieType::class, 'categorie_type_id');
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
}
