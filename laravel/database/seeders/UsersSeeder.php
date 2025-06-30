<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('ja_JP');

        DB::table('users')->insert([
            // オーナー2名
            [
                'name' => '店舗オーナー A',
                'gender' => '男性',
                'birthday' => '1980-04-10',
                'phone_number' => '09011112222',
                'post_code' => '100-0001',
                'address' => '東京都千代田区千代田1-1',
                'email' => 'owner_a@example.com',
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'is_admin' => true,
                'role' => true,
            ],
            [
                'name' => '店舗オーナー B',
                'gender' => '女性',
                'birthday' => '1985-08-15',
                'phone_number' => '09022223333',
                'post_code' => '150-0001',
                'address' => '東京都渋谷区神宮前1-1-1',
                'email' => 'owner_b@example.com',
                'password' => Hash::make('password123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'is_admin' => true,
                'role' => true,
            ],

            // 既存一般ユーザー2名
            [
                'name' => '田中 一郎',
                'gender' => '男性',
                'birthday' => '1990-01-01',
                'phone_number' => '08033334444',
                'post_code' => '160-0022',
                'address' => '東京都新宿区新宿1-1-1',
                'email' => 'ichiro@example.com',
                'password' => Hash::make('userpass'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'is_admin' => false,
                'role' => false,
            ],
            [
                'name' => '鈴木 花子',
                'gender' => '女性',
                'birthday' => '1992-05-10',
                'phone_number' => '08055556666',
                'post_code' => '530-0001',
                'address' => '大阪府大阪市北区梅田1-1-1',
                'email' => 'hanako@example.com',
                'password' => Hash::make('userpass'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'is_admin' => false,
                'role' => false,
            ],
        ]);

        // ここから21名分の追加ユーザー生成
        $users = [];
        for ($i = 0; $i < 21; $i++) {
            $gender = $faker->randomElement(['男性', '女性']);
            $users[] = [
                'name' => $faker->name($gender === '男性' ? 'male' : 'female'),
                'gender' => $gender,
                'birthday' => $faker->date('Y-m-d', '2004-01-01'), // 18歳以上に設定
                'phone_number' => $faker->phoneNumber(),
                'post_code' => $faker->postcode(),
                'address' => $faker->address(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('userpass'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'is_admin' => false,
                'role' => false,
            ];
        }

        DB::table('users')->insert($users);
    }
}

