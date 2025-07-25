<?php

namespace App\Http\Controllers\Api\Ikoa;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CartOrderResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCompletedUser;
use App\Mail\OrderCompletedAdmin;
use App\Models\User;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    // カート一覧
     public function index(Request $request)
    {
        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) {
            $cart = Cart::create(['user_id' => $userId]);
        }
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
    // 
    public function destroy(string $id)
    {
        $userId = Auth::id(); // ← 実際のログインユーザーIDを取得
        $cart = Cart::where('user_id', $userId)->first();

        // IDでカート商品を検索し、所有者チェック
        $cartProduct = CartProduct::where('product_id', $id)
            ->where('cart_id', $cart->id)
            ->first();

        $cartProduct->delete();

        return response()->json(['message' => '商品を削除しました']);
    }




    // 購入手続き処理
    public function purchase(Request $request)
    {
        $request->validate([
            //'user_id' => 'required|exists:users,id',
            'shipping_address' => 'required|string|max:225',
            'shipping_postal_code' => 'required|string|max:20',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'payment_method' => 'required|string|max:50',
        ]);

        DB::beginTransaction();

        try{
            $cart = Cart::where('user_id', Auth::id())->firstOrFail();
            $cartItems = $cart->cartProducts()->with('product')->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['message' => 'カートが空です'], 400);
            }

            $totalPrice = $cartItems->sum('amount_price');

            $order = Order::create([
                //'user_id' => $request->user_id,
                'user_id' => Auth::id(),
                'order_date' => now(),
                'status' => 'processing',
                'total_price' => $totalPrice,
                'shipping_address' => $request->shipping_address,
                'shipping_postal_code' => $request->shipping_postal_code,
                'recipient_name' => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
            ]);

            foreach ($cartItems as $item) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            // メール送信処理
            $user = User::find(Auth::id());
            $userName = $user->name;
            $orderItems = $cartItems->map(function($item) {
                return [
                    'name' => $item->product->name,
                    'quantity' => $item->quantity
                ];
            })->toArray();

            // ユーザーへ
            Mail::to($user->email)->send(new OrderCompletedUser($userName, $orderItems, $totalPrice));
            // 管理者へ
            $adminMail = config('mail.admin_address', 'admin@example.com');
            Mail::to($adminMail)->send(new OrderCompletedAdmin($userName, $orderItems, $totalPrice));

            $cart->cartProducts()->delete();

            DB::commit();

            return new CartOrderResource($order->load('orderProducts.product'));

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => '購入に失敗しました',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    // 支払い完了処理
    public function complete($orderId)
    {
        $order = Order::with('orderProducts.product')->findOrFail($orderId);

        return new CartOrderResource($order);
    }
}
