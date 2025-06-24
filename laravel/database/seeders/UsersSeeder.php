<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // 管理者ユーザー 1
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
                'role'=> true,//管理者
            ],

            // 管理者ユーザー 2
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
                'role'=> true,//管理者
            ],

            // 一般ユーザー 1
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
                'role'=> false,//利用者
            ],
            // 一般ユーザー 2
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
                'role'=> false,//利用者
            ],
        ]);

    }
}
