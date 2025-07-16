<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
        /**
     * @param  \App\Models\Cart  $this
     */

    public function toArray(Request $request): array
    {
         return [
            'id' => $this->id,
            'items' => CartItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
