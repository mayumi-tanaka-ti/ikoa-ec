<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('<対象テーブル名>')->insert([<カラム名> => <値>]);
        DB::table('categories')->insert([
            [
                'name' => 'ベッド',
            ],
            [
                'name' => 'ソファ',
            ],
            [
                'name' => 'ラグ・カーペット',
            ],
        ]);
    }
}
