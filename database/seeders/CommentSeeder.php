<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ambil semua ID resep yang ada di tabel recipes
        $recipeIds = DB::table('recipes')->pluck('id')->toArray();
        
        // Jika tidak ada resep, jangan lanjutkan
        if (empty($recipeIds)) {
            return;
        }

        foreach (range(1, 10) as $index) {
            DB::table('comments')->insert([
                'user_id' => $faker->numberBetween(1, 10), // Asumsi ada 10 pengguna
                'recipe_id' => $faker->randomElement($recipeIds), // Pilih ID resep acak dari yang ada
                'content' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
