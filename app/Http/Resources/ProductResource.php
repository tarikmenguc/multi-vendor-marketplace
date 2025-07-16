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
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'price' => (float) $this->price,
            'stock' => $this->stock,

            // İlişkiler: only if eager-loaded
            'category' => new CategoryResource(
                $this->whenLoaded('category')
            ),

            'tags' => TagResource::collection(
                $this->whenLoaded('tags')
            ),

            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
