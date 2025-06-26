<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
     protected $fillable = ['name',
                            'user_id',
                            'order_date',
                            'status',
                            'total_price',
                            'shipping_address',
                            'shipping_postal_code',
                            'recipient_name',
                            'recipient_phone',
                            'payment_method', 
                            'payment_status'
                           ];
    //
    public function user()      // 1:N
    {
        return $this->belongsTo(User::class);
    }

      public function products()      // N:N
    {
        // 中間テーブルの外部キー以外の列を取得するには
        // withPivotで設定必要
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity','price');
    }


    public function order_products()
    {
        return $this->hasMany(OrderProduct::class);
    }
}


