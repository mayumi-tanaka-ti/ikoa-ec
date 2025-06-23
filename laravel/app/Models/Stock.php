<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /** @use HasFactory<\Database\Factories\StockFactory> */
    use HasFactory;
    protected $fillable = ['order_id',
                           'product_id',
                           'quantity',
                           'price'
                           ];
    public function product()      // 1:N
    {
        return $this->belongsTo(Product::class);
    }
}
