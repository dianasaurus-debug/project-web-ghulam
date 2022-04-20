<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\KriteriaFuzzy;
use App\Models\ProductCategory;
use App\Models\SubCategory;
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
                    'id' => 1,
                    'nama_kategori' => 'Mie Instan',
                ],
                [
                    'id' => 2,
                    'nama_kategori' => 'Minuman',
                ],
                [
                    'id' => 3,
                    'nama_kategori' => 'Kosmetik',
                ],
                [
                    'id' => 4,
                    'nama_kategori' => 'Camilan',
                ],
        ]);
        //mie
        SubCategory::insert([
            [
                'category_id' => 1,
                'nama_kategori' => 'Mie Goreng',
                'max_harga' => '25000',
                'min_harga' => '2500'
            ],
            [
                'category_id' => 1,
                'nama_kategori' => 'Mie Kuah',
                'max_harga' => '30000',
                'min_harga' => '1500'
            ],
        ]);
        //camilan
        SubCategory::insert([
            [
                'category_id' => 4,
                'nama_kategori' => 'Keripik',
                'min_harga' => '3000',
                'max_harga' => '17000'
            ],
            [
                'category_id' => 4,
                'nama_kategori' => 'Pilus',
                'min_harga' => '500',
                'max_harga' => '10000'
            ],
            [
                'category_id' => 4,
                'nama_kategori' => 'Biskuit',
                'min_harga' => '2000',
                'max_harga' => '30000'
            ],
        ]);
        //minuman
        SubCategory::insert([
            [
                'category_id' => 2,
                'nama_kategori' => 'Softdrink',
                'min_harga' => '3000',
                'max_harga' => '35000'
            ],
            [
                'category_id' => 2,
                'nama_kategori' => 'Kopi',
                'min_harga' => '1000',
                'max_harga' => '15000'
            ],
            [
                'category_id' => 2,
                'nama_kategori' => 'Yoghurt',
                'min_harga' => '5000',
                'max_harga' => '25000'
            ],
            [
                'category_id' => 2,
                'nama_kategori' => 'Susu',
                'min_harga' => '4000',
                'max_harga' => '30000'
            ],
        ]);
        //kosmetik
        SubCategory::insert([
            [
                'category_id' => 3,
                'nama_kategori' => 'Facial Foam',
                'min_harga' => '1500',
                'max_harga' => '31000'
            ],
            [
                'category_id' => 3,
                'nama_kategori' => 'Pelembab',
                'min_harga' => '2000',
                'max_harga' => '50000'
            ],
            [
                'category_id' => 3,
                'nama_kategori' => 'Handbody',
                'min_harga' => '3000',
                'max_harga' => '35000'
            ],
            [
                'category_id' => 3,
                'nama_kategori' => 'Masker',
                'min_harga' => '6000',
                'max_harga' => '23000'
            ],
        ]);
        $product_categories = SubCategory::get();
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
