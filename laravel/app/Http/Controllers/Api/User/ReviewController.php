<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Resources\ReviewResource;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id(); // ログインしてるユーザーのid取得
        
        // 方法1: Reviewモデルから直接取得（商品情報も含める）
        $reviews = Review::where('user_id', $userId)
            ->with('product') // 商品情報も一緒に取得
            ->orderBy('review_date', 'desc')
            ->get();
        
        return response()->json($reviews);

    }

    public function create()
    {
        
        $review = Auth()->user->product()->attach(
            $product->id,
            [
                'rating' => $request->input('rating'),
                'comment' => $request->input('comment'),
                'review_date' => now(),
            ]
        );
        return  (new ReviewResource($review))
        ->additional(['message' => '投稿が登録されました'])
        ->response()
        ->setStatusCode(201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
                 // 該当する商品データ1件を取得(なければ404を返す)
        $review = Review::findOrFail($id);
        // 単一データの場合は、ProductResource を適用
        return new ReviewResource($review);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
