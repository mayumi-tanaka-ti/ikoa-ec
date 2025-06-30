<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;


class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();

        foreach ($users as $user) {
            $orderCount = rand(1, 3);

            for ($i = 0; $i < $orderCount; $i++) {
                Order::factory()->create([
                    'user_id' => $user->id,
                    'shipping_address' => $user->address ?? fake('ja_JP')->address(),
                    'shipping_postal_code' => fake('ja_JP')->postcode(),
                    'recipient_name' => $user->name,
                    'recipient_phone' => fake('ja_JP')->phoneNumber(),
                ]);
            }
        }
    }
}

