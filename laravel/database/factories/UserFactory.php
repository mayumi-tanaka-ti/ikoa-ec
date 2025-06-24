<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('ja_JP');
        return [
            'name' => fake('ja_JP')->name(),  // 性別指定も可能ですが省略可
            'gender' => fake('ja_JP')->randomElement(['男性', '女性']),
            'birthday' => fake('ja_JP')->date('Y-m-d', '2005-01-01'),
            'phone_number' => fake('ja_JP')->phoneNumber(),
            'post_code' => fake('ja_JP')->postcode(),
            'address' => fake('ja_JP')->address(),
            'email' => fake('ja_JP')->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // 固定パスワード
            'remember_token' => Str::random(10),
            'is_admin' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];

    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
