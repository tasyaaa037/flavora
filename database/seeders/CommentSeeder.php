<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User; // Pastikan model User diimpor
use Faker\Factory as Faker;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ambil semua ID resep yang ada di tabel recipes
        // Ambil ID pengguna secara acak
        $userIds = User::pluck('id')->toArray();

        // Jika tidak ada pengguna, jangan lanjutkan
        if (empty($userIds)) {
            return;
        }

        // Misalkan kita ingin membuat 50 komentar
        foreach (range(1, 50) as $index) {
            DB::table('comments')->insert([
                'user_id' => $faker->randomElement($userIds),  // Mengambil user_id acak dari pengguna
                'recipe_id' => DB::table('recipes')->inRandomOrder()->first()->id, // Mengambil recipe_id acak dari resep
                'content' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
