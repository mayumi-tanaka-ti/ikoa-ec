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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users');
            $table->datetime('order_date');
            $table->varchar(20)('status');
            $table->integer('total_price');
            $table->varchar(225)('shipping_address');
            $table->varchar(20)('shipping_postal_code');
            $table->varchar(255)('recipient_name');
            $table->varchar(20)('recipient_phone');
            $table->varvhar(50)('payment_method');
            $table->varchar(20)('payment_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
