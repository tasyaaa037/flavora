<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Recipe;
use App\Models\Category;

class RecipeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipes = Recipe::all();
        $categories = Category::all();

        foreach ($recipes as $recipe) {
            foreach ($categories as $category) {
                DB::table('recipe_category')->insert([
                    'recipe_id' => $recipe->id,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
