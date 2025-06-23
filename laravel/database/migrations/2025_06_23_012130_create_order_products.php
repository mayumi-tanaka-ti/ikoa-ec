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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id') // team_id というカラムを作成する
                ->nullable() // 外部キーにnull を設定できるようにする
                ->constrained('orders');  
            $table->foreignId('product_id') // team_id というカラムを作成する
                ->nullable() // 外部キーにnull を設定できるようにする
                ->constrained('products');  
            $table->integer('quantity');
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
