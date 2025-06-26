<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::all();
        return response()->json([
            'data' => $products
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 画像バリデーション
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        // 画像ファイルがアップロードされた場合の処理
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('products', 'public');
            $validated['image_path'] = $imagePath;
        }

        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    
    public function show(string $id)
    {
        return Product::findOrFail($id);
    }

    
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|integer',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'stock' => 'sometimes|required|integer',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('products', 'public');
            $validated['image_path'] = $imagePath;
        }

        $product->update($validated);

        return response()->json($product);
    }

    
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        // 画像ファイルが存在すれば削除
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();

        return response()->json(null, 204);
    }
}
