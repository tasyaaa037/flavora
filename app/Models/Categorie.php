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
    public function categoryTypes()
    {
        return $this->hasMany(CategoryType::class);
    }
    
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'categorie_types', 'categorie_id', 'recipe_id');
    }

}
