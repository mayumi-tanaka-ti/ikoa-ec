<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
     public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
        'id'    => $this->id,
        'name' => $this->name,
        'price' => $this->price,
        'image_path' => $this->image_path,
        'description' => $this->description,
        'stock' => $this->stock,
        'category_id' => $this->category_id,
        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
        // レビュー情報が読み込まれている場合のみ含める
        'reviews' => $this->when($this->relationLoaded('review_users'), function () {
            return $this->review_users->map(function ($user) {
                return [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'rating' => $user->pivot->rating,
                    'comment' => $user->pivot->comment,
                    'review_date' => $user->pivot->review_date,
                ];
            });
        }),
    ];
    }
    }

