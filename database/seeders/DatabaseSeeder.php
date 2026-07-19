<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat ulang Akun Admin
        User::create([
            'name' => 'Admin Diskominfo',
            'email' => 'admin@diskominfo.com',
            'password' => Hash::make('password'), // Password default: password
        ]);

        // 2. Isi ulang data tabel Jenis Konten
        DB::table('jenis_konten')->insert([
            ['nama_jenis' => 'Foto'],
            ['nama_jenis' => 'Video'],
            ['nama_jenis' => 'Infografis'],
            ['nama_jenis' => 'Flyer'],
            ['nama_jenis' => 'Rilis Berita'],
        ]);

        // 3. Isi ulang data tabel Sumber Konten
        DB::table('sumber_konten')->insert([
            ['nama_sumber' => 'IG Diskominfo'],
            ['nama_sumber' => 'IG Pemkot'],
            ['nama_sumber' => 'Website'],
        ]);
    }
}