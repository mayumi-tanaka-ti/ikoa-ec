<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('ja_JP');
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            $isIncoming = rand(0, 1); // 入庫 or 出庫
            $change = rand(1, 20);
            $changeQuantity = $isIncoming ? $change : -$change;
            $reason = $isIncoming ? '仕入れによる入庫' : '購入による出庫';

            $currentStock = DB::table('products')->where('id', $product->id)->value('stock') ?? 0;
            $newStock = max(0, $currentStock + $changeQuantity);

            DB::table('stocks')->insert([
                'product_id' => $product->id,
                'change_quantity' => $changeQuantity,
                'reason' => $reason,
                'stock_quantity' => $newStock,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // productテーブルの在庫も更新（任意）
            DB::table('products')->where('id', $product->id)->update(['stock' => $newStock]);
        }
    }
}

