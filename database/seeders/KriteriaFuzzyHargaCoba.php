<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\KriteriaFuzzy;
use Illuminate\Database\Seeder;

class KriteriaFuzzyHargaCoba extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //kriteria rating
        Kriteria::insert([
            [
                'id' => 11,
                'kode' => 'C3',
                'nama' => 'Harga',
                'satuan' => 'RP',
                'keterangan' => 'cost',
                'himpunan' => 'Murah',
                'interval_min' => 0,
                'interval_max' => 1,
            ],
            [
                'id' => 12,
                'kode' => 'C3',
                'nama' => 'Harga',
                'satuan' => 'RP',
                'keterangan' => 'cost',
                'himpunan' => 'Cukup Murah',
                'interval_min' => 1.1,
                'interval_max' => 2,
            ],
            [
                'id' => 13,
                'kode' => 'C3',
                'nama' => 'Harga',
                'satuan' => 'RP',
                'keterangan' => 'cost',
                'himpunan' => 'Sedang',
                'interval_min' => 2.1,
                'interval_max' => 3,
            ],
            [
                'id' => 14,
                'kode' => 'C3',
                'nama' => 'Harga',
                'satuan' => 'RP',
                'keterangan' => 'cost',
                'himpunan' => 'Mahal',
                'interval_min' => 3.1,
                'interval_max' => 4,
            ],
            [
                'id' => 15,
                'kode' => 'C3',
                'nama' => 'Harga',
                'satuan' => 'RP',
                'keterangan' => 'cost',
                'himpunan' => 'Sangat Mahal',
                'interval_min' => 4.1,
                'interval_max' => 5,
            ],
        ]);

        //fuzzy value kriteria supplier
        KriteriaFuzzy::insert([
            [
                'id_kriteria' => 11,
                'fuzzy_num_a' => 0.0,
                'fuzzy_num_b' => 0.1,
                'fuzzy_num_c' => 0.3,
            ],
            [
                'id_kriteria' => 12,
                'fuzzy_num_a' => 0.1,
                'fuzzy_num_b' => 0.3,
                'fuzzy_num_c' => 0.5,
            ],
            [
                'id_kriteria' => 13,
                'fuzzy_num_a' => 0.3,
                'fuzzy_num_b' => 0.5,
                'fuzzy_num_c' => 0.7,
            ],
            [
                'id_kriteria' => 14,
                'fuzzy_num_a' => 0.5,
                'fuzzy_num_b' => 0.7,
                'fuzzy_num_c' => 0.9,
            ],
            [
                'id_kriteria' => 15,
                'fuzzy_num_a' => 0.7,
                'fuzzy_num_b' => 0.9,
                'fuzzy_num_c' => 1.0,
            ],
        ]);
    }
}
