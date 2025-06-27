<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;

class IkoaProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        // 取得したデータを ProductResource に変換し、統一フォーマットで返却
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function list()
    {
         $categories = Category::with(['products' => function($query) {
             $query->where('is_visible', 1);
         }])->get();

        return response()->json($categories);
    }
        // public function list(Request $request)
        // {
        //     // クエリパラメータから category_id を取得
        //     $categoryId = $request->query('category_id');

        //     // category_id が指定されていれば絞り込み
        //     if ($categoryId) {
        //         $products = Product::where('category_id', $categoryId)->get();
        //     } else {
        //         $products = Product::all();
        //     }

        //     return ProductResource::collection($products);
        // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
         // 該当する商品データ1件を取得(なければ404を返す)
        $product = Product::with('review_users')->find($id);

        if (!$product) {
            return response()->json(['message' => '商品が見つかりません'], 404);
        }

        // ProductResourceにレビュー情報も含まれるようになったので、シンプルに返す
        return new ProductResource($product);
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
