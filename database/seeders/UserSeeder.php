<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@toko.com', // Ganti sesuai keinginan
            'password' => Hash::make('password123'), // Passwordnya nanti ini
            'role' => 'admin', // Sesuaikan dengan kolom role kamu
        ]);
    }
}