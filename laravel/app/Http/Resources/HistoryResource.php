<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'order_date'        => $this->order_date,
            'status'            => $this->status,
            'total_price'       => $this->total_price,
            'shipping_address'  => $this->shipping_address,

            // 注文商品の一覧を自分で配列に変換
            'order_products' => $this->order_products->map(function($orderProduct) {
                return [
                    'product_name' => $orderProduct->product->name,
                    'price'        => $orderProduct->price,
                    'quantity'     => $orderProduct->quantity,
                    'subtotal'     => $orderProduct->price * $orderProduct->quantity,
                ];
            }),
        ];
    }
}
