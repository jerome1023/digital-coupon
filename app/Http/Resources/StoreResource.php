<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        // dd($this->id,);
        return [
            'id' => $this->id,
            'owner' => new UserResource($this->user),
            'name' => $this->name,
            'address' => $this->address
        ];
    }
}
