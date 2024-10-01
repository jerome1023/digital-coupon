<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            // 'user_id' => new UserResource($this->user),
            'coupon' => new CouponResource($this->coupon),
            // 'rewards' => CouponRewardResource::collection($this->rewards)
            'status' => $this->status
        ];
    }
}
