<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ingredient;
use App\Models\Step;
use App\Models\Comment;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Purpose;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'instructions',
        'ingredients',
        'cook_method',
        'image',
        'category_id',
        'subcategory_id',
        'prep_time',
        'cook_time',
        'price',
        'time',
        'servings',
        'cuisine',
        'purpose_id',
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
     * Get the steps for the recipe.
     */
    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    /**
     * Get the comments for the recipe.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the categories for the recipe.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'recipe_category');
    }

    /**
     * Get the subcategory for the recipe.
     */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    /**
     * Get the purpose for the recipe.
     */
    public function purpose()
    {
        return $this->belongsTo(Purpose::class);
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
            // Process instructions into steps
            $instructions = explode("\n", $recipe->instructions);
            $recipe->steps()->delete(); 
            foreach ($instructions as $index => $instruction) {
                Step::create([
                    'recipe_id' => $recipe->id,
                    'instruction' => trim($instruction),
                    'step_number' => $index + 1,
                ]);
            }

            // Process ingredients
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
