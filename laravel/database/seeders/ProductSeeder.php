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
                'name' => 'シングルサイズ木製ベッドフレーム',
                'price' => 25000,
                'image_path' => 'products/image001.jpg',
                'description' => 'ナチュラルな木目調でお部屋に馴染むシンプルなベッドフレーム。',
                'stock' => 8,
                'category_id' => 1,
            ],
            [
                'name' => '収納付きセミダブルベッド',
                'price' => 45000,
                'image_path' => 'products/image002.jpg',
                'description' => '引き出し収納付きで、省スペースに最適なセミダブルサイズ。',
                'stock' => 5,
                'category_id' =>1,
            ],
            [
                'name' => '低反発マットレス付きダブルベッド',
                'price' => 60000,
                'image_path' => 'products/image003.jpg',
                'description' => '快適な低反発マットレス付きのダブルベッドセット。',
                'stock' => 3,
                'category_id' => 1,
            ],
                        
            // ソファ（3点）
            [
                'name' => 'レトロ本革カウチソファ',
                'price' => 79800,
                'image_path' => 'products/image004.jpg',
                'description' => '上質な本革を使用したレトロデザインのカウチソファ。',
                'stock' => 10,
                'category_id' => 2,
            ],
            [
                'name' => '北欧風2人掛けソファ',
                'price' => 59800,
                'image_path' => 'products/image005.jpg',
                'description' => 'ナチュラルな木脚とシンプルなデザインが魅力。',
                'stock' => 12,
                'category_id' => 2,
            ],
            [
                'name' => 'ファブリックソファ',
                'price' => 45000,
                'image_path' => 'products/image006.jpg',
                'description' => '通気性の良い生地で快適な座り心地。',
                'stock' => 8,
                'category_id' => 2,
            ],

            // ラグ（2点）
            [
                'name' => '北欧柄コットンラグ',
                'price' => 2999,
                'image_path' => 'products/image007.jpg',
                'description' => '幾何学模様が特徴の軽量コットンラグ。',
                'stock' => 15,
                'category_id' => 3,
            ],
            [
                'name' => 'ふわふわシャギーラグ',
                'price' => 5500,
                'image_path' => 'products/image008.jpg',
                'description' => '肌触りが柔らかくリラックス空間に最適。',
                'stock' => 10,
                'category_id' => 3,
            ],

            // テーブル（3点）
            [
                'name' => '折りたたみローテーブル',
                'price' => 6800,
                'image_path' => 'products/image009.jpg',
                'description' => '収納にも便利なコンパクト設計。',
                'stock' => 14,
                'category_id' => 4,
            ],
            [
                'name' => 'オーク材ダイニングテーブル',
                'price' => 35800,
                'image_path' => 'products/image010.jpg',
                'description' => '天然木の温もりが感じられるダイニング用。',
                'stock' => 9,
                'category_id' => 4,
            ],
            [
                'name' => 'アイアン脚カフェテーブル',
                'price' => 12000,
                'image_path' => 'products/image011.jpg',
                'description' => 'モダンな空間に合うシンプルなデザイン。',
                'stock' => 6,
                'category_id' => 4,
            ],

            // 収納家具（2点）
            [
                'name' => '木製シェルフ',
                'price' => 9800,
                'image_path' => 'products/image012.jpg',
                'description' => '組み替え自由なオープンタイプ。',
                'stock' => 10,
                'category_id' => 5,
            ],
            [
                'name' => 'チェスト収納ボックス',
                'price' => 7200,
                'image_path' => 'products/image013.jpg',
                'description' => '衣類や雑貨をすっきり収納。',
                'stock' => 7,
                'category_id' => 5,
            ],
        ]);
    }
}