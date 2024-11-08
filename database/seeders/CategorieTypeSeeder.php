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
            ['nama' => 'cara_memasak'],
            ['nama' => 'jenis_hidangan'],
            ['nama' => 'kategori_khas'],
            ['nama' => 'bahan_utama'],
            ['nama' => 'tujuan_makanan'],
        ];

        foreach ($types as $type) {
            CategorieType::create($type);
        }
    }
}
