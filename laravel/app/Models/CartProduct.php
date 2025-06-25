<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_product extends Model
{
     /** @use HasFactory<\Database\Factories\Cart_productFactory> */
    use HasFactory;
    protected $fillable = ['quantity','amount_price'];
    protected $table = 'cart_products';

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
