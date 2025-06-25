<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'order_id' => $this->id,
            'user_id' => $this->user_id,
            'order_date' => $this->order_date,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'shipping_address' => $this->shipping_address,
            'shipping_postal_code' => $this->shipping_postal_code,
            'recipient_name' => $this->recipient_name,
            'recipient_phone' => $this->recipient_phone,
            'payment_method' => $this->payment_method,
            'products' => $this->whenLoaded('orderProducts', function () {
                return $this->orderProducts->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name ?? '',
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->price * $item->quantity,
                    ];
                });
            }),
        ];

        // 完了画面用にメッセージを追加（リクエストに ?complete=1 がついてたら）
        if ($request->query('complete')) {
            $data['message'] = '支払いが完了しました。 ご注文ありがとうございました。';
        }

        return $data;
    }
}
