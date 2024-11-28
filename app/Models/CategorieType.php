<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Nama tipe kategori
    ];

    /**
     * Define a relationship with the Categorie model.
     */
    public function categories()
    {
        return $this->hasMany(Categorie::class, 'categorie_type_id');
    }

    /**
     * Define a many-to-many relationship with the Recipe model.
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'categorie_type_recipe', 'categorie_type_id', 'recipe_id');
    }

}
