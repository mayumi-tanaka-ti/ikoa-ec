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
    
 
    // $tableで設定する (中間テーブルの名前を変える場合などに使う)
    protected $table = ['favorites',
                        'reviews'
                       ];
}
