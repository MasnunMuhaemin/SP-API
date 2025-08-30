<?php

namespace Database\Seeders;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Loan::create([
            'user_id' => 1, // sesuai user admin
            'book_id' => 1, // buku pertama
            'tanggal_pinjam' => Carbon::now()->subDays(3),
            'tanggal_kembali' => null,
            'status' => 'dipinjam'
        ]);

        Loan::create([
            'user_id' => 1, // user kedua
            'book_id' => 2, // buku kedua
            'tanggal_pinjam' => Carbon::now()->subDays(5),
            'tanggal_kembali' => null,
            'status' => 'dipinjam'
        ]);

        Loan::create([
            'user_id' => 1,
            'book_id' => 1,
            'tanggal_pinjam' => Carbon::now()->subDays(2),
            'tanggal_kembali' => Carbon::now()->addDays(5),
            'status' => 'dikembalikan'
        ]);
    }
}
