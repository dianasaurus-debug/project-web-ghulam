<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\KriteriaFuzzy;
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
                    'nama_kategori' => 'Mie Instan',
                    'max_harga' => '25000',
                    'min_harga' => '2000'
                ],
                [
                    'nama_kategori' => 'Minuman Bersoda',
                    'max_harga' => '20000',
                    'min_harga' => '3000'
                ],
                [
                    'nama_kategori' => 'Kopi',
                    'max_harga' => '15000',
                    'min_harga' => '3000'
                ],
                [
                    'nama_kategori' => 'Camilan',
                    'max_harga' => '30000',
                    'min_harga' => '1500'
                ],
        ]);
        $product_categories = ProductCategory::get();
        for ($k = 0; $k < count($product_categories); $k++) {
            $arr = range($product_categories[$k]->min_harga, $product_categories[$k]->max_harga);
            $new_arr = array_chunk($arr, ceil(count($arr) / 5));
            $fuzzy_nums = config('constants.bobot');
            $kriteria_word = config('constants.kriteria_harga');
            for ($i = 0; $i < count($new_arr); $i++) {
                $kriteria = Kriteria::create([
                    'kode' => 'C3',
                    'nama' => 'Harga',
                    'satuan' => 'RP',
                    'keterangan' => 'cost',
                    'category_id' => $product_categories[$k]->id,
                    'himpunan' => $kriteria_word[$i],
                    'interval_min' => min($new_arr[$i]),
                    'interval_max' => max($new_arr[$i]),
                ]);
                KriteriaFuzzy::create(
                    [
                        'id_kriteria' => $kriteria->id,
                        'fuzzy_num_a' => $fuzzy_nums[$i][0],
                        'fuzzy_num_b' => $fuzzy_nums[$i][1],
                        'fuzzy_num_c' => $fuzzy_nums[$i][2],
                    ]);
            }
        }

    }
}
