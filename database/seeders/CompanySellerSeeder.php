<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('company_seller')->insert([

            // January
            ['company_id' => 1, 'seller_id' => 8, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 42000],
            ['company_id' => 1, 'seller_id' => 7, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 42000],
            ['company_id' => 1, 'seller_id' => 10, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 64000],
            ['company_id' => 1, 'seller_id' => 3, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 55000],
            ['company_id' => 1, 'seller_id' => 6, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 65000],
            ['company_id' => 1, 'seller_id' => 2, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 68000],
            ['company_id' => 1, 'seller_id' => 9, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 48000],
            ['company_id' => 1, 'seller_id' => 13, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 43000],
            ['company_id' => 1, 'seller_id' => 1, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 46000],
            ['company_id' => 1, 'seller_id' => 14, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 60000],
            ['company_id' => 1, 'seller_id' => 5, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 18000],
            ['company_id' => 1, 'seller_id' => 4, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 33000],

            ['company_id' => 2, 'seller_id' => 37, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 25000],
            ['company_id' => 2, 'seller_id' => 31, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 30000],
            ['company_id' => 2, 'seller_id' => 29, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 35000],
            ['company_id' => 2, 'seller_id' => 30, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 35000],
            ['company_id' => 2, 'seller_id' => 36, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 35000],
            ['company_id' => 2, 'seller_id' => 28, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 25000],
            ['company_id' => 2, 'seller_id' => 27, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 35000],
            ['company_id' => 2, 'seller_id' => 33, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 25000],
            ['company_id' => 2, 'seller_id' => 32, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 20000],
            ['company_id' => 2, 'seller_id' => 39, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 25000],
            ['company_id' => 2, 'seller_id' => 34, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 17000],
            ['company_id' => 2, 'seller_id' => 41, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 20000],

            ['company_id' => 3, 'seller_id' => 58, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 45000],
            ['company_id' => 3, 'seller_id' => 54, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 20000],
            ['company_id' => 3, 'seller_id' => 57, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 50000],
            ['company_id' => 3, 'seller_id' => 59, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 50000],
            ['company_id' => 3, 'seller_id' => 60, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 125000],
            ['company_id' => 3, 'seller_id' => 56, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 125000],
            ['company_id' => 3, 'seller_id' => 61, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 42000],
            ['company_id' => 3, 'seller_id' => 53, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 10000],
            ['company_id' => 3, 'seller_id' => 52, 'period_start' => '2024-01-01', 'period_end' => '2024-01-31', 'goal' => 38000],

            //Febrary
            ['company_id' => 1, 'seller_id' => 8, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 42000],
            ['company_id' => 1, 'seller_id' => 7, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 47000],
            ['company_id' => 1, 'seller_id' => 10, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 64000],
            ['company_id' => 1, 'seller_id' => 3, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 52000],
            ['company_id' => 1, 'seller_id' => 6, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 62000],
            ['company_id' => 1, 'seller_id' => 2, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 65000],
            ['company_id' => 1, 'seller_id' => 9, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 48000],
            ['company_id' => 1, 'seller_id' => 13, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 43000],
            ['company_id' => 1, 'seller_id' => 1, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 50000],
            ['company_id' => 1, 'seller_id' => 14, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 55000],
            ['company_id' => 1, 'seller_id' => 5, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 20000],
            ['company_id' => 1, 'seller_id' => 4, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 35000],

            ['company_id' => 2, 'seller_id' => 37, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 25000],
            ['company_id' => 2, 'seller_id' => 31, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 30000],
            ['company_id' => 2, 'seller_id' => 29, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 35000],
            ['company_id' => 2, 'seller_id' => 30, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 35000],
            ['company_id' => 2, 'seller_id' => 36, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 35000],
            ['company_id' => 2, 'seller_id' => 28, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 25000],
            ['company_id' => 2, 'seller_id' => 27, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 38000],
            ['company_id' => 2, 'seller_id' => 33, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 26000],
            ['company_id' => 2, 'seller_id' => 32, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 22000],
            ['company_id' => 2, 'seller_id' => 39, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 28000],
            ['company_id' => 2, 'seller_id' => 34, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 20000],
            ['company_id' => 2, 'seller_id' => 41, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 22000],

            ['company_id' => 3, 'seller_id' => 58, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 48000],
            ['company_id' => 3, 'seller_id' => 54, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 20000],
            ['company_id' => 3, 'seller_id' => 57, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 48000],
            ['company_id' => 3, 'seller_id' => 59, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 52000],
            ['company_id' => 3, 'seller_id' => 60, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 126000],
            ['company_id' => 3, 'seller_id' => 56, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 126000],
            ['company_id' => 3, 'seller_id' => 61, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 40000],
            ['company_id' => 3, 'seller_id' => 53, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 15000],
            ['company_id' => 3, 'seller_id' => 52, 'period_start' => '2024-02-01', 'period_end' => '2024-02-29', 'goal' => 40000],

            //March
            ['company_id' => 1,  'seller_id' => 8, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 42000],
            ['company_id' => 1,  'seller_id' => 7, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 47000],
            ['company_id' => 1, 'seller_id' => 10, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 64000],
            ['company_id' => 1,  'seller_id' => 3, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 52000],
            ['company_id' => 1,  'seller_id' => 6, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 62000],
            ['company_id' => 1,  'seller_id' => 2, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 65000],
            ['company_id' => 1,  'seller_id' => 9, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 48000],
            ['company_id' => 1, 'seller_id' => 13, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 43000],
            ['company_id' => 1,  'seller_id' => 1, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 50000],
            ['company_id' => 1, 'seller_id' => 15, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 53000],
            ['company_id' => 1,  'seller_id' => 5, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 22000],
            ['company_id' => 1,  'seller_id' => 4, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 36000],

            ['company_id' => 2, 'seller_id' => 37, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 26000],
            ['company_id' => 2, 'seller_id' => 31, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 30000],
            ['company_id' => 2, 'seller_id' => 29, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 36000],
            ['company_id' => 2, 'seller_id' => 30, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 35000],
            ['company_id' => 2, 'seller_id' => 36, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 35000],
            ['company_id' => 2, 'seller_id' => 28, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 25000],
            ['company_id' => 2, 'seller_id' => 27, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 38000],
            ['company_id' => 2, 'seller_id' => 33, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 27000],
            ['company_id' => 2, 'seller_id' => 32, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 22000],
            ['company_id' => 2, 'seller_id' => 39, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 27000],
            ['company_id' => 2, 'seller_id' => 34, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 20000],
            ['company_id' => 2, 'seller_id' => 42, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 23000],

            ['company_id' => 3, 'seller_id' => 58, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 50000],
            ['company_id' => 3, 'seller_id' => 54, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 23000],
            ['company_id' => 3, 'seller_id' => 57, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 48000],
            ['company_id' => 3, 'seller_id' => 59, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 52000],
            ['company_id' => 3, 'seller_id' => 55, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 132000],
            ['company_id' => 3, 'seller_id' => 56, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 132000],
            ['company_id' => 3, 'seller_id' => 62, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 40000],
            ['company_id' => 3, 'seller_id' => 53, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 20000],
            ['company_id' => 3, 'seller_id' => 52, 'period_start' => '2024-03-01', 'period_end' => '2024-03-31', 'goal' => 44000],

            //April
            ['company_id' => 1,  'seller_id' => 8, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 40000],
            ['company_id' => 1,  'seller_id' => 7, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 45000],
            ['company_id' => 1, 'seller_id' => 10, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 60000],
            ['company_id' => 1,  'seller_id' => 3, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 52000],
            ['company_id' => 1,  'seller_id' => 6, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 60000],
            ['company_id' => 1,  'seller_id' => 2, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 60000],
            ['company_id' => 1,  'seller_id' => 9, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 45000],
            ['company_id' => 1, 'seller_id' => 13, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 50000],
            ['company_id' => 1,  'seller_id' => 1, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 50000],
            ['company_id' => 1, 'seller_id' => 15, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 53000],
            ['company_id' => 1,  'seller_id' => 5, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 22000],
            ['company_id' => 1,  'seller_id' => 4, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 36000],

            ['company_id' => 2, 'seller_id' => 37, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 26000],
            ['company_id' => 2, 'seller_id' => 31, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 30000],
            ['company_id' => 2, 'seller_id' => 29, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 37000],
            ['company_id' => 2, 'seller_id' => 30, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 35000],
            ['company_id' => 2, 'seller_id' => 36, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 32000],
            ['company_id' => 2, 'seller_id' => 28, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 25000],
            ['company_id' => 2, 'seller_id' => 27, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 38000],
            ['company_id' => 2, 'seller_id' => 33, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 27000],
            ['company_id' => 2, 'seller_id' => 32, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 22000],
            ['company_id' => 2, 'seller_id' => 39, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 28000],
            ['company_id' => 2, 'seller_id' => 34, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 20000],
            ['company_id' => 2, 'seller_id' => 42, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 23000],

            ['company_id' => 3, 'seller_id' => 58, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 50000],
            ['company_id' => 3, 'seller_id' => 54, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 23000],
            ['company_id' => 3, 'seller_id' => 57, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 50000],
            ['company_id' => 3, 'seller_id' => 59, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 55000],
            ['company_id' => 3, 'seller_id' => 60, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 132000],
            ['company_id' => 3, 'seller_id' => 56, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 132000],
            ['company_id' => 3, 'seller_id' => 62, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 40000],
            ['company_id' => 3, 'seller_id' => 53, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 20000],
            ['company_id' => 3, 'seller_id' => 52, 'period_start' => '2024-04-01', 'period_end' => '2024-04-30', 'goal' => 44000],

        ]);
    }
}
