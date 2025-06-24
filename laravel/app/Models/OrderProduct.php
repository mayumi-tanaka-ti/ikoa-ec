<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
     /** @use HasFactory<\Database\Factories\Order_productFactory> */
    use HasFactory;
    protected $fillable = ['quantity','price'];
    protected $table = 'order_product';
}
