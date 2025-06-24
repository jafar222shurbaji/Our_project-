<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // Example: Add to cart
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);
        $cart = $this->cartService->addToCart(Auth::id(), $validated['product_id'], $validated['quantity']);
        return response()->json(['message' => 'Product added to cart', 'cart' => $cart]);
    }
}
