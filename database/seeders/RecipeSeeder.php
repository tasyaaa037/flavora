<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;  // Pastikan model Recipe sudah ada
use App\Models\Category; // Pastikan ini diimpor
use App\Models\User; // Pastikan ini diimpor
use Faker\Factory as Faker;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        // Buat instance faker
        $faker = Faker::create();

        // Loop untuk membuat beberapa recipe
        for ($i = 0; $i < 10; $i++) {
            Recipe::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'instructions' => $faker->paragraph,
                'image' => $faker->imageUrl(),
                'prep_time' => $faker->numberBetween(5, 120),
                'cook_time' => $faker->numberBetween(5, 120),
                'servings' => $faker->numberBetween(1, 10),
                'category_id' => Category::inRandomOrder()->first()->id,
                'user_id' => User::inRandomOrder()->first()->id,
            ]);
        }
    }
}
