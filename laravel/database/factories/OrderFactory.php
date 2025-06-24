<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_date' => fake()->dateTimeBetween('-1 years', 'now'),
            'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered']),
            'total_price' => fake()->numberBetween(1000, 100000),
            'shipping_address' => fake('ja_JP')->address(),
            'shipping_postal_code' => fake('ja_JP')->postcode(),
            'recipient_name' => fake('ja_JP')->name(),
            'recipient_phone' => fake('ja_JP')->phoneNumber(),
            'payment_method' => fake()->randomElement(['credit_card', 'bank_transfer', 'cash_on_delivery']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed']),
        ];

    }
}
