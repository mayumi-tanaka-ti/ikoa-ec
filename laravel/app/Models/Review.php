<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;
    protected $fillable = ['user_id',
                           'name',
                           'product_id',
                           'rating',
                           'comment',
                           'review_date'];
        // $tableで設定する (中間テーブルの名前を変える場合などに使う)
    protected $table = 'reviews';

        public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
