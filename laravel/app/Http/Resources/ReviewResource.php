<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
        'user_id' => $this->user_id,
        'product_id' => $this->product_id,
        'rating' => $this->rating,
        'comment' => $this->comment,
        'review_date' => $this->review_date,
    ];
    }
}
