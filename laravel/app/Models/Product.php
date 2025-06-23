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
                          ];
    
 

     public function users()      // N:N
    {
        // 中間テーブルの外部キー以外の列を取得するには
        // withPivotで設定必要
        return $this->belongsToMany(User::class)
            ->withPivot('rating', 'comment','reviewdate');
    }

}
