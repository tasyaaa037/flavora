<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Recipe;
use App\Models\Categorie;
use App\Models\CategorieType;

// RecipeCategorySeeder.php
class CategorieTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['nama' => 'Cara Memasak'],
            ['nama' => 'Jenis Hidangan'],
            ['nama' => 'Kategori Khas'],
            ['nama' => 'Bahan Utama'],
            ['nama' => 'Tujuan Makanan'],
            ['nama' => 'Rekomendasi Resep'],
        ];

        foreach ($types as $type) {
            CategorieType::create($type);
        }
    }
}
