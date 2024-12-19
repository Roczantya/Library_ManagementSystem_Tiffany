<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan model User sudah diimport
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Buat admin user
        User::create([
            'name' => 'Admin User', // Nama admin
            'email' => 'admin@gmail.com', // Email admin
            'password' => Hash::make('password'), // Ganti password sesuai kebutuhan
            'role' => 'admin', // Role admin
        ]);
    }
}
