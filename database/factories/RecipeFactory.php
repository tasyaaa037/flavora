<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\Category; 
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
            'image' => $this->faker->imageUrl(),
            'prep_time' => $this->faker->numberBetween(5, 120),
            'cook_time' => $this->faker->numberBetween(5, 120),
            'servings' => $this->faker->numberBetween(1, 10),
            'category_id' => Category::factory(), // jika menggunakan relasi
            'user_id' => null, // atau atur sesuai kebutuhan
        ];
    }
}