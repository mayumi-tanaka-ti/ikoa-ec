<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCompletedUser;
use App\Mail\OrderCompletedAdmin;

class OrderController extends Controller
{
    public function index()
    {

        // 注文と注文商品をまとめて取得
        $orders = Order::with('order_products.product')->get();
        return response()->json($orders);
    }

    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            // 例: 'status' => 'required|string', 'shipping_address' => 'nullable|string', など
            'status' => 'sometimes|required|string',
            'shipping_address' => 'nullable|string',
            // 必要な項目を追加
        ]);

        $order->update($validated);

        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function completeOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        // ...その他の完了処理...

        // ユーザーに送信
        Mail::to($order->user->email)->send(new OrderCompletedUser($order));

        // 管理者に送信
        Mail::to(config('mail.admin_address'))->send(new OrderCompletedAdmin($order));
    }
}
