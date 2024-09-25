<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Recipe;
use App\Models\Category;

// RecipeCategorySeeder.php
class RecipeCategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('recipe_category')->truncate();

        // Buat kategori
        $categories = Category::factory()->count(5)->create();

        // Buat resep
        $recipes = Recipe::factory()->count(10)->create(); // Pastikan factory sudah benar

        foreach ($recipes as $recipe) {
            $categoriesToAttach = $categories->random(rand(1, 3))->pluck('id');
            $recipe->categories()->attach($categoriesToAttach);
        }
    }
}
