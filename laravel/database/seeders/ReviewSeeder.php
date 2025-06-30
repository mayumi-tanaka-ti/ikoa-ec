<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('ja_JP');

        $users = User::where('is_admin', false)->pluck('id')->toArray();
        $products = Product::all();

        $comments = [
            'この商品は期待以上の品質でした。非常に満足しています。',
            '配送が速くて助かりました。また利用したいと思います。',
            'サイズが思っていたより小さかったですが、デザインは素敵です。',
            '使いやすく、とても便利で気に入っています。',
            '値段の割に高品質でコスパが良いと思います。',
            '素材がしっかりしていて、長持ちしそうです。',
            '色味が写真と少し違いましたが、問題なく使えています。',
            '初めての購入でしたが、対応も丁寧で安心しました。',
            '子どもも喜んで使っており、買ってよかったです。',
            '組み立てが簡単で、説明書もわかりやすかったです。',
        ];

        foreach ($products as $product) {
            DB::table('reviews')->insert([
                'user_id' => $faker->randomElement($users),
                'product_id' => $product->id,
                'rating' => rand(3, 5),
                'comment' => $faker->randomElement($comments),
                'review_date' => Carbon::now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
