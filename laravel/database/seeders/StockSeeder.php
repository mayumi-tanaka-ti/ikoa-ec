<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stocks')->insert([
            [
                'product_id' => 1,
                'change_quantity' => -1,
                'reason' => '購入による出庫',
                'stock_quantity' => 14,
            ],
            [
                'product_id' => 3,
                'change_quantity' => 5,
                'reason' => '仕入れによる入庫',
                'stock_quantity' =>  35,
            ],
        ]);
    }
}
