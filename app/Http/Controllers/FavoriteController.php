<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResponse;
use App\Http\Resources\FavoritesResource;
use App\Services\FavoriteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    //

    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }
    public function addFavorite(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);
        $favorite = $this->favoriteService->addFavorite(Auth::user()->id, $validated['product_id']);
        if ($favorite) {
            return ApiResponse::successWithData((new FavoritesResource($favorite))->toArray($request), 'Added to favorites', 201);
        } else {
            return ApiResponse::error('Already in favorites', 200);
        }
    }
    public function getFavorites()
    {
        $favorites = $this->favoriteService->getFavorites(Auth::user()->id);
        return ApiResponse::successWithData((FavoritesResource::collection($favorites))->toArray(request()) , 'Favorites retrieved successfully', 200);
    }

    public function removeFavorite(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);
        $result = $this->favoriteService->removeFavorite(Auth::id(), $validated['product_id']);
        if(!$result){
            return ApiResponse::error('Not in favorites', 400);
        }
        return ApiResponse::success('Removed from favorites', 200);
    }
}
