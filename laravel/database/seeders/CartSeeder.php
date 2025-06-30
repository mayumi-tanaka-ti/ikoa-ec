<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::where('id', '>=', 3)->pluck('id');

        foreach ($userIds as $userId) {
            DB::table('carts')->insert([
                'user_id' => $userId,
            ]);
        }
    }
}

