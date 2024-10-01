<?php

namespace App\Http\Resources;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCouponStampResource extends JsonResource
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
            // 'coupon' => new CouponResource($this->coupon),
            'reward' => $this->reward,
            'details' => $this->details,
            'sort' => $this->sort,
            'scan' => $this->scan
        ];
    }
}
