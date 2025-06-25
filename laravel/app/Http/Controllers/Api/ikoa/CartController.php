<?php

namespace App\Http\ikoa\Controllers;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    // カート一覧
     public function index(Request $request)
    {
        $userId = $request->user_id;
        $cart = Cart::where('user_id', $userId)->firstOrFail();
        $items = $cart->cartProducts()->with('product')->get();

        return response()->json([
            'items' => CartResource::collection($items),
            'total' => $items->sum('amount_price'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    // カートに商品を追加する
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => $request->user_id]);
        $product = Product::findOrFail($request->product_id);

        $cartProduct = CartProduct::firstOrNew([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);

        $cartProduct->quantity += $request->quantity;
        $cartProduct->amount_price = $cartProduct->quantity * $product->price;
        $cartProduct->save();

        return response()->json(['message' => '商品をカートに追加しました']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    // 数量の変更
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartProduct = CartProduct::with('product')->findOrFail($id);
        $cartProduct->quantity = $request->quantity;
        $cartProduct->amount_price = $cartProduct->quantity * $cartProduct->product->price;
        $cartProduct->save();

        return response()->json(['message' => '数量を更新しました']);
    }

    /**
     * Remove the specified resource from storage.
     */

    // 商品削除
    public function destroy(string $id)
    {
        $cartProduct = CartProduct::findOrFail($id);
        $cartProduct->delete();

        return response()->json(['message' => '商品を削除しました']);
    }
}
