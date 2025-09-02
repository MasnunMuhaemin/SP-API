<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'judul' => 'Pemrograman Kotlin untuk Android',
            'penulis' => 'Andi Pratama',
            'penerbit' => 'Informatika Press',
            'tahun_terbit' => 2023,
            'stok' => 10,
            'image' => 'kotlin_android.jpg',
            'kategori' => 'Pemrograman'
        ]);

        Book::create([
            'judul' => 'Laravel untuk Pemula',
            'penulis' => 'Budi Santoso',
            'penerbit' => 'Gramedia',
            'tahun_terbit' => 2022,
            'stok' => 5,
            'image' => 'laravel_pemula.jpg',
            'kategori' => 'Web Development'
        ]);
    }
}
