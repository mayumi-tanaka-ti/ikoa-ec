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
                            'recipient_phone',
                            'payment_status'
                           ];
    //
    public function user()      // 1:N
    {
        return $this->belongsTo(User::class);
    }
}
