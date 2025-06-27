<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => '引き出し付きシングルベッド',
                'price' => 39900,
                'image_path' => 'products/image001.jpg',
                'description' => '限られたスペースを有効活用できる、引き出し付きのシングルベッド。衣類や寝具の収納に便利です。',
                'stock' => 20,
                'category_id' => 1,
            ],
            [
                'name' => 'レトロ本革カウチソファ',
                'price' => 79800,
                'image_path' => 'products/image002.jpg',
                'description' => '上質な本革を使用したレトロデザインのカウチソファ。3人掛けで、座り心地も抜群。',
                'stock' => 15,
                'category_id' => 2,
            ],
            [
                'name' => '北欧柄コットンラグ',
                'price' => 2999, 
                'image_path' => 'products/image003.jpg',
                'description' => '北欧スタイルの幾何学模様が特徴のコットンラグ。軽量で洗濯可能、ナチュラルな質感がリビングやベッドルームにぴったり。',
                'stock' => 30,
                'category_id' => 3, 
            ],
        ]);
    }
}
