<?php

namespace Database\Seeders;

use App\Models\LetakBarang;
use Illuminate\Database\Seeder;

class LetakBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LetakBarang::insert([
                [
                    'name' => 'Rak 1',
                    'description' => 'Rak yang berisi makanan berat'
                ],
                [
                    'name' => 'Rak 2',
                    'description' => 'Rak yang berisi berbagai macam snack'
                ],
                [
                    'name' => 'Kulkas 1',
                    'description' => 'Kulkas yang berisi berbagai macam kopi'
                ],
                [
                    'name' => 'Kulkas 2',
                    'description' => 'Kulkas yang berisi soft drinks'
                ],
            ]
        );
    }
}
