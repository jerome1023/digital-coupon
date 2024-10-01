<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'store' => new StoreResource($this->store),
            'name' => $this->name,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'coupon_rewards' => CouponRewardResource::collection($this->coupon_rewards)
        ];
    }
}
