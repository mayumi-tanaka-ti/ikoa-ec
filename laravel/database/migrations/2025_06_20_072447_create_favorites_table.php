<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id') // team_id というカラムを作成する
                ->nullable() // 外部キーにnull を設定できるようにする
                ->constrained('userss');
            $table->foreignId('product_id') // team_id というカラムを作成する
                ->nullable() // 外部キーにnull を設定できるようにする
                ->constrained('products'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
