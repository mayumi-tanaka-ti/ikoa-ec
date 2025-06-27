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
        // $userId = Auth::id(); // ログインしてるユーザーのid取得
        
        // // 方法1: Reviewモデルから直接取得（商品情報も含める）
        // $review = Review::where('user_id', $userId)
        //     ->with('product') // 商品情報も一緒に取得
        //     ->orderBy('review_date', 'desc')
        //     ->get();
        
        // return response()->json($reviews);

    }

    public function create()
    {
        return response()->json(['message' => 'レビュー作成画面'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        // バリデーション
        $validated = $request->validate([
            
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string',
        ]);

        $review = Review::create([
            'user_id' => Auth::id(),
            'product_id' => $id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'review_date' => now(),
        ]);
        return (new ReviewResource($review))
            ->additional(['message' => 'レビューが保存されました'])
            ->response()
            ->setStatusCode(201);
    }

    // public function edit($id)
    // {
    //     // APIの場合、画面表示用のeditは不要ですが、空メソッドとして残します
    //     return response()->json(['message' => 'レビュー編集画面'], 200);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $review_id)
    {
        $review = Review::findOrFail($review_id);
        // 本人のみ編集可
        if ($review->user_id !== Auth::id()) {
            return response()->json(['message' => '権限がありません'], 403);
        }
        $validated = $request->validate([
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'sometimes|required|string',
        ]);
        $review->update($validated);
        return (new ReviewResource($review))
            ->additional(['message' => 'レビューが更新されました']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $review_id)
    {
        $review = Review::findOrFail($review_id);
        // 本人のみ削除可
        if ($review->user_id !== Auth::id()) {
            return response()->json(['message' => '権限がありません'], 403);
        }
        $review->delete();
        return response()->json(['message' => 'レビューが削除されました']);
    }
}

