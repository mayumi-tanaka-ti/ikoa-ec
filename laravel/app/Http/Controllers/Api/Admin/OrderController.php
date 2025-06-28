<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * 月別売上を取得
     */
    public function monthlySales()
    {
        $monthlySales = Order::select(
                DB::raw("DATE_FORMAT(order_date, '%Y-%m') as month"),
                DB::raw("SUM(total_price) as total")
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        return response()->json($monthlySales);
    }

    /**
     * 日別売上を取得
     */
    public function dailySales()
    {
        $dailySales = Order::select(
                DB::raw("DATE(order_date) as date"),
                DB::raw("SUM(total_price) as total")
            )
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($dailySales);
    }
}