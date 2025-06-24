<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'available_quantity' => $this->available_quantity,
            'category' => $this->category->name,
            'color' => $this->color->name,
            'fabric' => $this->fabric->fabric_type,
            'wood' => $this->wood->wood_type,
            // 'images' => $this->images->map(function ($image) {
            //     return asset('storage/' . $image->path);
            // }),
        ];
    }
}
