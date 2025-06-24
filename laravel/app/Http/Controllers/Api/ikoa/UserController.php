<?php

namespace App\Http\Controllers\Api\ikoa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function mypage(Request $request){
        $user = Auth::user(); // ログインユーザー取得

        // リレーションのロード
        $user->load([
            'orders.products',             // 注文履歴の注文ごとの商品も一緒に取得
            'favorite_products',           // お気に入り商品
            'review_products',             // レビュー商品とコメント
        ]);
        
        return response()->json([
            'user' => $user,
            'orders' => $user->orders,
            'favorites' => $user->favorite_products,
            'reviews' => $user->review_products,
        ]);
    }
}
