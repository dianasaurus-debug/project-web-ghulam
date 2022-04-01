<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\KriteriaFuzzy;
use Illuminate\Database\Seeder;

class KriteriaFuzzySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //kriteria supplier
        Kriteria::insert([
                [
                    'id' => 1,
                    'kode' => 'C1',
                    'nama' => 'Supplier',
                    'satuan' => 'buah',
                    'keterangan' => 'benefit',
                    'himpunan' => 'Tidak direkomendasikan',
                    'interval_min' => 1,
                    'interval_max' => 3,
                ],
                [
                    'id' => 2,
                    'kode' => 'C1',
                    'nama' => 'Supplier',
                    'satuan' => 'buah',
                    'keterangan' => 'benefit',
                    'himpunan' => 'Kurang direkomendasikan',
                    'interval_min' => 4,
                    'interval_max' => 7,
                ],
                [
                    'id' => 3,
                    'kode' => 'C1',
                    'nama' => 'Supplier',
                    'satuan' => 'buah',
                    'keterangan' => 'benefit',
                    'himpunan' => 'Cukup direkomendasikan',
                    'interval_min' => 8,
                    'interval_max' => 11,
                ],
                [
                    'id' => 4,
                    'kode' => 'C1',
                    'nama' => 'Supplier',
                    'satuan' => 'buah',
                    'keterangan' => 'benefit',
                    'himpunan' => 'Direkomendasikan',
                    'interval_min' => 12,
                    'interval_max' => 15,
                ],
                [
                    'id' => 5,
                    'kode' => 'C1',
                    'nama' => 'Supplier',
                    'satuan' => 'buah',
                    'keterangan' => 'benefit',
                    'himpunan' => 'Sangat direkomendasikan',
                    'interval_min' => 16,
                    'interval_max' => 19,
                ],
            ]);

        //kriteria rating
        Kriteria::insert([
            [
                'id' => 6,
                'kode' => 'C2',
                'nama' => 'Rating',
                'satuan' => 'score',
                'keterangan' => 'benefit',
                'himpunan' => 'Tidak direkomendasikan',
                'interval_min' => 0,
                'interval_max' => 1,
            ],
            [
                'id' => 7,
                'kode' => 'C2',
                'nama' => 'Rating',
                'satuan' => 'score',
                'keterangan' => 'benefit',
                'himpunan' => 'Kurang direkomendasikan',
                'interval_min' => 1.1,
                'interval_max' => 2,
            ],
            [
                'id' => 8,
                'kode' => 'C2',
                'nama' => 'Rating',
                'satuan' => 'score',
                'keterangan' => 'benefit',
                'himpunan' => 'Cukup direkomendasikan',
                'interval_min' => 2.1,
                'interval_max' => 3,
            ],
            [
                'id' => 9,
                'kode' => 'C2',
                'nama' => 'Rating',
                'satuan' => 'score',
                'keterangan' => 'benefit',
                'himpunan' => 'Direkomendasikan',
                'interval_min' => 3.1,
                'interval_max' => 4,
            ],
            [
                'id' => 10,
                'kode' => 'C2',
                'nama' => 'Rating',
                'satuan' => 'score',
                'keterangan' => 'benefit',
                'himpunan' => 'Sangat direkomendasikan',
                'interval_min' => 4.1,
                'interval_max' => 5,
            ],
        ]);

        //fuzzy value kriteria supplier
        KriteriaFuzzy::insert([
            [
                'id_kriteria' => 1,
                'fuzzy_num_a' => 0.1,
                'fuzzy_num_b' => 0.1,
                'fuzzy_num_c' => 0.3,
            ],
            [
                'id_kriteria' => 2,
                'fuzzy_num_a' => 0.1,
                'fuzzy_num_b' => 0.3,
                'fuzzy_num_c' => 0.5,
            ],
            [
                'id_kriteria' => 3,
                'fuzzy_num_a' => 0.3,
                'fuzzy_num_b' => 0.5,
                'fuzzy_num_c' => 0.7,
            ],
            [
                'id_kriteria' => 3,
                'fuzzy_num_a' => 0.5,
                'fuzzy_num_b' => 0.7,
                'fuzzy_num_c' => 0.9,
            ],
            [
                'id_kriteria' => 3,
                'fuzzy_num_a' => 0.7,
                'fuzzy_num_b' => 0.9,
                'fuzzy_num_c' => 1.0,
            ],
        ]);

        //fuzzy value rating
        KriteriaFuzzy::insert([
            [
                'id_kriteria' => 6,
                'fuzzy_num_a' => 0.1,
                'fuzzy_num_b' => 0.1,
                'fuzzy_num_c' => 0.3,
            ],
            [
                'id_kriteria' => 7,
                'fuzzy_num_a' => 0.1,
                'fuzzy_num_b' => 0.3,
                'fuzzy_num_c' => 0.5,
            ],
            [
                'id_kriteria' => 8,
                'fuzzy_num_a' => 0.3,
                'fuzzy_num_b' => 0.5,
                'fuzzy_num_c' => 0.7,
            ],
            [
                'id_kriteria' => 9,
                'fuzzy_num_a' => 0.5,
                'fuzzy_num_b' => 0.7,
                'fuzzy_num_c' => 0.9,
            ],
            [
                'id_kriteria' => 10,
                'fuzzy_num_a' => 0.7,
                'fuzzy_num_b' => 0.9,
                'fuzzy_num_c' => 1.0,
            ],
        ]);
    }
}
