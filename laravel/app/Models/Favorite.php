<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /** @use HasFactory<\Database\Factories\FavoriteFactory> */
    use HasFactory;
      protected $fillable = ['name',
                             'user_id',
                             'protected_id'
                            ];
        // $tableで設定する (中間テーブルの名前を変える場合などに使う)
    protected $table = ['favorites'];
}
