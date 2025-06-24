<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'user_id' => 3,
                'product_id' => 1,
                'rating' => 5,
                'comment' => 'このソファはとても快適でデザインも素敵です！',
                'review_date' => Carbon::now()->subDays(5),
            ],
            [
                'user_id' => 4,
                'product_id' => 2,
                'rating' => 4,
                'comment' => 'ベッドの寝心地は良いですが、組み立てに少し時間がかかりました。',
                'review_date' => Carbon::now()->subDays(3),
            ],
            [
                'user_id' => 3,
                'product_id' => 3,
                'rating' => 3,
                'comment' => 'ラグは柔らかいですが、もう少し厚みがあると良かったです。',
                'review_date' => Carbon::now()->subDays(1),
            ],
        ]);
    }
}
