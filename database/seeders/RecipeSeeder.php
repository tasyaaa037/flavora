<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\User;
use Faker\Factory as Faker;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        // Buat instance faker
        $faker = Faker::create();

        // Daftar kategori manual
        $categories = [
            'Breakfast',
            'Lunch',
            'Dinner',
            'Snack',
            'Dessert'
        ];

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
                // Pilih kategori acak dari daftar tetap
                'category_id' => array_search($faker->randomElement($categories), $categories) + 1,
                'user_id' => User::inRandomOrder()->first()->id,
            ]);
        }
    }
}
