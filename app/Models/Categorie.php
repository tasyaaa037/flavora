<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategorieType;
use App\Models\Recipe;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'categorie_type_id', 'categories'];
    protected $table = 'categories';

    /**
     * Relasi ke CategorieType (each category has one CategorieType).
     */
    public function categorieType()
    {
        return $this->belongsTo(CategorieType::class, 'categorie_type_id');
    }

    /**
     * Relasi ke Recipe (many-to-many).
     */
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'category_recipe', 'categorie_id', 'recipe_id');
    }

    // In App\Models\Categorie
    public function categorieTypes()
    {
        return $this->hasMany(CategorieType::class); // Or the appropriate relation type
    }

}
