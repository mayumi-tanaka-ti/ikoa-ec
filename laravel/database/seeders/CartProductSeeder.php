<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('cart_product')->insert([
            [
                'cart_id' => 1,
                'product_id' => 4, // ソファ商品ID例
                'quantity' => 1,
                'amount_price' => 79800,
            ],
             [
                'cart_id' => 1,
                'product_id' => 6,       // ラグの商品ID例
                'quantity' => 1,
                'amount_price' => 2999,
            ],
            [
                'cart_id' => 2,
                'product_id' => 5,       // ベッドの商品ID例
                'quantity' => 1,
                'amount_price' => 39900,
            ],
        ]);
    }
}
