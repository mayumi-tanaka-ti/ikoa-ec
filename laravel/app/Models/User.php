<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'gender',
        'birthday',
        'phone_number',
        'post_code',
        'address',
        'email',
        'is_admin',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

     public function orders()      // 1:N
    {
        return $this->hasMany(Order::class);
    }

     public function favorite_products()      // N:N
    {
        // 中間テーブルの外部キー以外の列を取得するには
        // withPivotで設定必要
        return $this->belongsToMany(Product::class,'favorites');
    }
     
     public function review_products()      // N:N
    {
        // 中間テーブルの外部キー以外の列を取得するには
        // withPivotで設定必要
        return $this->belongsToMany(Product::class,'reviews')
            ->withPivot('rating', 'comment','reviewdate');
    }
}
