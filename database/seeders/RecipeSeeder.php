<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Category; // Pastikan ini diimpor
use App\Models\User; // Pastikan ini diimpor

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Menghasilkan data contoh
        for ($i = 0; $i < 20; $i++) {
            DB::table('recipes')->insert([
                'name' => $faker->sentence,
                'description' => $faker->paragraph,
                'instructions' => $faker->paragraph,
                'image' => $faker->imageUrl,
                'category_id' => Category::inRandomOrder()->first()->id, // Pastikan Category diimpor
                'user_id' => User::inRandomOrder()->first()->id, // Pastikan User diimpor
                'prep_time' => $faker->numberBetween(5, 120),
                'cook_time' => $faker->numberBetween(5, 120),
                'servings' => $faker->numberBetween(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
