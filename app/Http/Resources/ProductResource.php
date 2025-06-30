<?php

namespace App\Http\Resources;

use App\Models\Photo;
use App\Services\FavoriteService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;


class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $isFavorited = false;

        if (auth()->guard('sanctum')->check()) {
            $service = app(FavoriteService::class);
            $isFavorited = $service->isFavorited($this->resource);
        }

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
            'is_favorited' => $isFavorited,
            'images' => $this->photos->map(function ($image) {
                return asset('storage/' . $image->photo);
            }),
        ];
    }
}
