<?php

namespace Database\Seeders;

use App\Models\JenisKonten;
use App\Models\SumberKonten;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User LANGSUNG (bukan via UserSeeder)
        User::create([
            'name' => 'Admin Diskominfo',
            'email' => 'admin@diskominfo.com',
            'password' => bcrypt('password123'),
        ]);

        User::create([
            'name' => 'Petugas Input',
            'email' => 'petugas@diskominfo.com',
            'password' => bcrypt('password123'),
        ]);

        // Seed Jenis Konten
        JenisKonten::create(['nama' => 'Foto']);
        JenisKonten::create(['nama' => 'Video']);
        JenisKonten::create(['nama' => 'Infografis']);
        JenisKonten::create(['nama' => 'Flyer']);

        // Seed Sumber Konten
        SumberKonten::create(['nama' => 'IG Discominfo']);
        SumberKonten::create(['nama' => 'IG Pemkot']);
        SumberKonten::create(['nama' => 'Website']);
    }
}