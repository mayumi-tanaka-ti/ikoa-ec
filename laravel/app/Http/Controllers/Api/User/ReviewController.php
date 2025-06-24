<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         $reviews = Review::all();
        // 取得したデータを ProductResource に変換し、統一フォーマットで返却
        return ReviewResource::collection($reviews);
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
        return  (new ReviewResource($cafe))
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
