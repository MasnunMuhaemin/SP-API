<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User biasa
       DB::table('users')->insert([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user', // role user
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Petugas
        DB::table('users')->insert([
            'name' => 'Petugas Perpustakaan',
            'email' => 'petugas@example.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas', // role petugas
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Admin
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin', // role admin
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
