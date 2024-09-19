<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use Faker\Factory as Faker;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            Ingredient::create([
                'name' => $faker->word,
                'quantity' => $faker->randomNumber(2),
                'unit' => $faker->randomElement(['grams', 'liters', 'pieces']),
                'description' => $faker->sentence,
                'recipe_id' => $faker->numberBetween(1, 10), // Pastikan ID resep valid
            ]);
        }
    }
}
