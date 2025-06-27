<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = ['name',
                           'price',
                           'image_path',
                           'description',
                           'stock',
                           'category_id',
                           'is_visible', //表示・非表示
                          ];
    
 

     public function favorite_users()      // N:N
    {
        // 中間テーブルの外部キー以外の列を取得するには
        // withPivotで設定必要
        return $this->belongsToMany(User::class,'favorites');
    }
     
     public function review_users()      // N:N
    {
        // 中間テーブルの外部キー以外の列を取得するには
        // withPivotで設定必要
        return $this->belongsToMany(User::class,'reviews')
            ->withPivot('rating', 'comment','review_date');
    }

     public function carts()      // N:N
    {
        // 中間テーブルの外部キー以外の列を取得するには
        // withPivotで設定必要
        return $this->belongsToMany(Cart::class)
            ->withPivot('quantity','amount_price');
    }
     
     public function orders()      // N:N
    {
        // 中間テーブルの外部キー以外の列を取得するには
        // withPivotで設定必要
        return $this->belongsToMany(Order::class)
            ->withPivot('quantity','price');
    }

     public function category()      // 1:N
    {
        return $this->belongsTo(Category::class);
    }

     public function stocks()      // 1:N
    {
        return $this->hasMany(Stock::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

}
