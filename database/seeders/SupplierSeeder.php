<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::create([
            'nama_supplier' => 'PT Indofood Surabaya',
            'deskripsi' => 'Supplier produk-produk Indofood',
            'phone' => '087821119222',
            'email' => 'indofoodsurabaya@gmail.com',
            'alamat' => 'Jln Ngagel No. 05'
        ]);
        Supplier::create([
            'nama_supplier' => 'PT Cimory Malang',
            'deskripsi' => 'Supplier produk-produk Cimory',
            'phone' => '0218291811',
            'email' => 'cimory@gmail.com',
            'alamat' => 'Jln Singosari No. 05'
        ]);
        Supplier::create([
            'nama_supplier' => 'PT Wings Gresik',
            'deskripsi' => 'Supplier produk-produk Wings cabang Gresik',
            'phone' => '021829118211',
            'email' => 'wingsfoodgresik@gmail.com',
            'alamat' => 'Jln Veteran'
        ]);
        Supplier::create([
            'nama_supplier' => 'PT Wardah Distribusi Surabaya',
            'deskripsi' => 'Supplier produk-produk Wardah',
            'phone' => '02172119291811',
            'email' => 'wardahsby@gmail.com',
            'alamat' => 'Jln Kedungcowek No. 95'
        ]);
    }
}
