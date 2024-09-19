<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Recipe;
use App\Models\Favorite;

class FavoriteSeeder extends Seeder
{
    public function run()
    {
        // Ambil beberapa pengguna dan resep yang ada
        $users = User::all();
        $recipes = Recipe::all();

        // Cek jika ada pengguna dan resep
        if ($users->isEmpty() || $recipes->isEmpty()) {
            $this->command->info('No users or recipes found. Seeder skipped.');
            return;
        }

        // Tambahkan data favorit
        foreach ($users as $user) {
            foreach ($recipes as $recipe) {
                // Tambahkan data favorit untuk setiap pengguna dan resep
                Favorite::create([
                    'user_id' => $user->id,
                    'recipe_id' => $recipe->id,
                ]);
            }
        }
    }
}
