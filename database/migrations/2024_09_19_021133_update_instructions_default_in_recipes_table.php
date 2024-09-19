<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Recipe;
use App\Models\Category;

class RecipeCategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Menghapus data yang sudah ada untuk mencegah duplikasi
        DB::table('recipe_category')->truncate();

        // Buat beberapa recipe dan category
        $recipes = Recipe::factory()->count(10)->create();
        $categories = Category::factory()->count(5)->create();

        // Buat relasi secara acak
        foreach ($recipes as $recipe) {
            $categoriesToAttach = $categories->random(rand(1, 3))->pluck('id');
            $recipe->categories()->attach($categoriesToAttach);
        }
    }
}
