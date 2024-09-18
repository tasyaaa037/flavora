<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = User::all();
        $categories = Category::all();

        // Menggunakan faker untuk mengisi data resep secara otomatis
        Recipe::factory(20)->create()->each(function ($recipe) use ($categories, $users) {
            $recipe->categories()->attach(
                $categories->random(1)->pluck('id')->toArray()
            );
            $recipe->user_id = $users->random()->id;
            $recipe->save();
        });
    }
}
