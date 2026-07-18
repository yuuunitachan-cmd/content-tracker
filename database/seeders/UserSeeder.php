<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin Diskominfo',
            'email' => 'admin@diskominfo.com',
            'password' => bcrypt('password123'),
        ]);
      
    }
}
/*
  // Optional: Create another user
        User::create([
            'name' => 'Petugas Input',
            'email' => 'petugas@diskominfo.com',
            'password' => bcrypt('password123'),
        ]);

