<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            UsersSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            CartSeeder::class,
            CartProductSeeder::class,
            FavoriteSeeder::class,
            ReviewSeeder::class,
            StockSeeder::class,
            OrderSeeder::class,
            OrderProductSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
