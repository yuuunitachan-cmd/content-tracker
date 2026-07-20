<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Menggunakan facades Hash lebih disarankan untuk best practice

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Amankan Akun Admin Diskominfo
        User::updateOrCreate(
            ['email' => 'admin@diskominfo.com'],
            [
                'name' => 'Admin Diskominfo',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Amankan Akun Super Admin (Sesuai data terdeteksi di phpMyAdmin Anda)
        User::updateOrCreate(
            ['email' => 'super@diskominfo.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
            ]
        );

    }
}

/*
        // 3. Aktifkan Akun Petugas Input (Untuk Staf / Anak PKL sesuai SRS)
        User::updateOrCreate(
            ['email' => 'petugas@diskominfo.com'],
            [
                'name' => 'Petugas Input',
                'password' => Hash::make('password123'),
            ]
        );