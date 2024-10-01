<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponRewardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($request);
        return [
            'id' => $this->id,
            'reward' => $this->reward,
            'details' => $this->details,
            'sort' => $this->sort,
            'scan' => $this->scan
        ];
    }
}
