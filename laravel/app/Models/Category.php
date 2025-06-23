<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];
    //
    public function products()      // 1:N
    {
        return $this->hasMany(Product::class);
    }

}
