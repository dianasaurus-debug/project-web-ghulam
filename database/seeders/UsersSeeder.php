<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Ghulam',
            'last_name' => 'Alvi',
            'email' => 'ghulam_owner@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '083162718171',
            'role' => 1,
        ]);
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Faisal',
            'email' => 'adminfaisal@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '083168718171',
            'role' => 2,
        ]);
    }
}
