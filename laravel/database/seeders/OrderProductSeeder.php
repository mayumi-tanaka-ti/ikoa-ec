<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $orders = Order::all();
        $products = Product::all();


        $count = 0;
        while ($count < 1000) {
        foreach ($orders as $order) {
            foreach ($products as $product) {
                OrderProduct::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => fake()->numberBetween(1, 5),
                    'price' => fake()->numberBetween(1000, 100000), // 価格
                ]);
                $count++;
                if ($count >= 1000) {
                    break 3;
                }
            }
        }}
    }
}