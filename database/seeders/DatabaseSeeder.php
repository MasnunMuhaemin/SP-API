<?php

namespace Database\Seeders;

use App\Models\Loan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Memanggil UserSeeder
        $this->call([
            UserSeeder::class,
            BookSeeder::class,
            LoanSeeder::class,
        ]);

        // User::factory(10)->create();


    }
}
