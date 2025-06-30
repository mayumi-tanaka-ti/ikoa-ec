<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;

class OrderProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $orders = Order::all();

        $count = 0;
        $target = 1000;

        foreach ($orders as $order) {
            // 注文ごとに1～5商品をランダムに追加
            $selectedProducts = $products->random(rand(1, 5));
            $total = 0;

            foreach ($selectedProducts as $product) {
                if ($count >= $target) break 2;

                $quantity = rand(1, 5);
                $price = $product->price;

                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $total += $price * $quantity;
                $count++;
            }

            // 合計金額更新
            $order->update(['total_price' => $total]);
        }

        echo "🔢 合計作成数: {$count}件の order_product レコードが作成されました。\n";
    }
}

