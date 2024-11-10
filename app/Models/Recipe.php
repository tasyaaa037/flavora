<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ingredient;
use App\Models\Comment;
use App\Models\User;
use App\Models\Categorie;
use App\Models\CategorieType;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'instructions',
        'ingredients',
        'image',
        'categorie_id',
        'cook_time',
    ];

    /**
     * Get the user that owns the recipe.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ingredients for the recipe.
     */
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_recipe');
    }

    /**
     * Get the comments for the recipe.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relasi dengan kategori metode
    public function method()
    {
        return $this->belongsTo(Categorie::class, 'method_id');
    }

    // Relasi dengan kategori jenis hidangan
    public function type()
    {
        return $this->belongsTo(Categorie::class, 'type_id');
    }

    // Relasi dengan kategori makanan khas
    public function cuisine()
    {
        return $this->belongsTo(Categorie::class, 'cuisine_id');
    }

    // Relasi dengan kategori bahan utama
    public function ingredient()
    {
        return $this->belongsTo(Categorie::class, 'ingredient_id');
    }

    // Relasi dengan kategori tujuan makanan
    public function purpose()
    {
        return $this->belongsTo(Categorie::class, 'purpose_id');
    }

    // Relasi dengan kategori umum
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }


    /**
     * Get the categories for the recipe.
     */
    public function categories()
    {
        return $this->belongsToMany(Categorie::class, 'Categorie_Type');
    }

    /**
     * Get users who favorited the recipe.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    protected static function booted()
    {
        static::saved(function ($recipe) {
            // Process ingredients only
            $ingredients = explode(",", $recipe->ingredients);
            $recipe->ingredients()->delete(); 
            foreach ($ingredients as $ingredient) {
                Ingredient::create([
                    'recipe_id' => $recipe->id,
                    'name' => trim($ingredient),
                    'quantity' => null, 
                ]);
            }
        });
    }

    /**
     * Scope a query to only include recipes with a specific ingredient.
     */
    public function scopeWithIngredient($query, $ingredientName)
    {
        return $query->whereHas('ingredients', function ($query) use ($ingredientName) {
            $query->where('name', 'LIKE', "%{$ingredientName}%");
        });
    }

    /**
     * Get recipes by the specified ingredient from the request.
     */
    public function getRecipesByIngredient(Request $request) 
    {
        $ingredientName = $request->input('ingredient'); // selected ingredient name
        
        // Query to get recipes based on the selected ingredient
        $recipesQuery = Recipe::withIngredient($ingredientName);
        
        $total = $recipesQuery->count(); // Total matching recipes
        $recipes = $recipesQuery->paginate(15); // Paginate for display
    
        return view('recipes.index', compact('recipes', 'total', 'ingredientName'));
    }
}
