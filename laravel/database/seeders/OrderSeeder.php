<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(200)
            ->state([
                'is_admin' => false,
            ])
            ->create()
            ->each(function ($user) {
                // 各ユーザーに1～5件の注文を作成
                $orderCount = rand(1, 5);
                Order::factory()->count($orderCount)->create([
                    'user_id' => $user->id,
                ]);
            });
    }
}
