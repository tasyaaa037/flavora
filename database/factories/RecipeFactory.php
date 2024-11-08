<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'instructions' => $this->faker->paragraph,
            'ingredient' => $this->faker->words(5, true), 
            'image' => $this->faker->imageUrl(640, 480, 'food'),
            'cook_time' => $this->faker->numberBetween(10, 100),
            'categorie_id' => Categorie::factory(), 
            'user_id' => User::factory(), 
        ];
    }
}
