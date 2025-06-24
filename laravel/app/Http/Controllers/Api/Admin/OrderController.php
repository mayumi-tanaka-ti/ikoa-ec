<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 注文と注文商品をまとめて取得
        $orders = Order::with('order_products.product')->get();
        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 注文と注文商品をまとめて取得
        $order = Order::with('order_products.product')->findOrFail($id);
        return response()->json($order);
    }    

    /**
     * Update the specified resource in storage.
     */
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
}
