<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe;
use App\Models\Ingredient; 
use App\Models\Step;       
use App\Models\Comment;    
use App\Models\User;       
use App\Models\Category;   
use App\Models\Subcategory; 
use App\Models\Purpose;    
use App\Models\Favorite;    

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
        return $this->hasMany(Ingredient::class);
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

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function purpose()
    {
        return $this->belongsTo(Purpose::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
     
    protected static function booted()
    {
        static::saved(function ($recipe) {
            $instructions = explode("\n", $recipe->instructions);
            $recipe->steps()->delete(); 
            foreach ($instructions as $index => $instruction) {
                Step::create([
                    'recipe_id' => $recipe->id,
                    'instruction' => trim($instruction),
                    'step_number' => $index + 1,
                ]);
            }
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
}
