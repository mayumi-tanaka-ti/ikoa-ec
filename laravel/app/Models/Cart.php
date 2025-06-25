<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;

    protected $fillable = ['user_id'];

        public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

       public function products()      // N:N
    {
        // 中間テーブルの外部キー以外の列を取得するには
        // withPivotで設定必要
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity','amount_price');
    }

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }
}
