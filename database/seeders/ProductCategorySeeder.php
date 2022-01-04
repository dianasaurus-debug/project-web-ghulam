<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::insert([
                [
                    'nama_kategori' => 'Makanan'
                ],
                [
                    'nama_kategori' => 'Minuman Bersoda'
                ],
                [
                    'nama_kategori' => 'Kopi'
                ],
                [
                    'nama_kategori' => 'Camilan'
                ],
        ]
        );
    }
}
