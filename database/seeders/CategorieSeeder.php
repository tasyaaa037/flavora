<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Categorie;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            // Tipe Kategori: Cara Memasak (tipe_kategori_id = 1)
            ['nama' => 'Serba Goreng', 'categorie_type_id' => 1],
            ['nama' => 'Serba Kukus', 'categorie_type_id' => 1],
            ['nama' => 'Serba Bakar', 'categorie_type_id' => 1],
            ['nama' => 'Serba Panggang', 'categorie_type_id' => 1],

            // Tipe Kategori: Jenis Hidangan (tipe_kategori_id = 2)
            ['nama' => 'Makanan Pembuka', 'categorie_type_id' => 2],
            ['nama' => 'Makanan Penutup', 'categorie_type_id' => 2],
            ['nama' => 'Hidangan Utama', 'categorie_type_id' => 2],
            ['nama' => 'Sarapan', 'categorie_type_id' => 2],

            // Tipe Kategori: Kategori Khas (tipe_kategori_id = 3)
            ['nama' => 'Makanan Tradisional', 'categorie_type_id' => 3],
            ['nama' => 'Makanan Internasional', 'categorie_type_id' => 3],

            // Tipe Kategori: Bahan Utama (tipe_kategori_id = 4)
            ['nama' => 'Daging Ayam', 'categorie_type_id' => 4],
            ['nama' => 'Daging Sapi', 'categorie_type_id' => 4],
            ['nama' => 'Ikan', 'categorie_type_id' => 4],
            ['nama' => 'Sayuran', 'categorie_type_id' => 4],
            ['nama' => 'Tahu dan Tempe', 'categorie_type_id' => 4],

            // Tipe Kategori: Tujuan Makanan (tipe_kategori_id = 5)
            ['nama' => 'Makanan Sehat', 'categorie_type_id' => 5],
            ['nama' => 'Makanan Diet', 'categorie_type_id' => 5],
            ['nama' => 'Makanan Balita', 'categorie_type_id' => 5],
            ['nama' => 'Makanan Ringan', 'categorie_type_id' => 5],
        ];

        foreach ($categories as $category) {
            Categorie::create($category);
        }
    }
}
