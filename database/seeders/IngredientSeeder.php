<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Faker\Factory as Faker;

class IngredientSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Fetch all recipe IDs from the recipes table
        $recipeIds = DB::table('recipes')->pluck('id');

        foreach (range(1, 20) as $index) {
            DB::table('ingredients')->insert([
                'name' => $faker->word, // Nama bahan
                'quantity' => rand(1, 100), // Kuantitas
                'unit' => $faker->randomElement(['grams', 'ml', 'pieces', 'cups']), // Unit bahan
                'recipe_id' => $faker->randomElement($recipeIds), // Random recipe_id from the recipes table
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
