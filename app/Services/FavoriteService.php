<?php

namespace App\Services;

use App\Models\Favorite;

class FavoriteService
{
    public function addFavorite($userId, $productId)
    {
        // Prevent duplicate favorites
        $existing = Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
        if ($existing) {
            return null;
        }
        Favorite::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        return true;
    }

    public function getFavorites($userId)
    {
        return Favorite::where('user_id', $userId)->paginate(6);
    }

    public function removeFavorite($userId, $productId)
    {
        $existing = Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
        if (!$existing) {
            return null;
        }

        $result = Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
        return $result;
    }
}
