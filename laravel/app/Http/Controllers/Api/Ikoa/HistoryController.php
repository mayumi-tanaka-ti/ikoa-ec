<?php

namespace App\Http\Controllers\Api\Ikoa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\HistoryResource;


class HistoryController extends Controller
{
    public function history()
    {
        //$userId = 3;

        $userId = Auth::id();

        $orders = Order::with('order_products.product')
                        ->where('user_id', $userId)
                        ->latest()
                        ->get();

        return HistoryResource::collection($orders);
    }
}