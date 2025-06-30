<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartProductSeeder extends Seeder
{
    public function run(): void
    {
        $carts = DB::table('carts')->get();
        $products = DB::table('products')->get();

        foreach ($carts as $cart) {
            // 0〜5個のカート商品数をランダム決定
            $count = rand(0, 5);

            // 商品をシャッフルして重複なしで取得
            $shuffledProducts = $products->shuffle()->take($count);

            foreach ($shuffledProducts as $product) {
                $quantity = rand(1, 3);
                $amount_price = $product->price * $quantity;

                DB::table('cart_product')->insert([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'amount_price' => $amount_price,
                ]);
            }
        }
    }
}

