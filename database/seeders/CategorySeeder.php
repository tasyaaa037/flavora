<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Breakfast', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lunch', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dinner', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Snack', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dessert', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
