<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;

class CartService
{
    public function getCart($userId)
    {
        return Order::where('user_id', $userId)->where('status', 'cart')->with('orderItems.product')->first();
    }

    public function addToCart($userId, $productId, $quantity)
    {
        $cart = $this->getCart($userId);
        if (!$cart) {
            $cart = Order::create([
                'user_id' => $userId,
                'status' => 'cart'
            ]);
        }
        $product = Product::findOrFail($productId);
        $existingItem = $cart->orderItems()->where('product_id', $productId)->first();
        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $quantity,
                'price' => $product->price
            ]);
        } else {
            $cart->orderItems()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price
            ]);
        }
        return $cart->load('orderItems.product');
    }

    public function updateCartItem(Order $cart, $itemId, $quantity)
    {
        $item = $cart->orderItems()->findOrFail($itemId);
        return $item->update(['quantity' => $quantity]);
    }

    public function removeFromCart(Order $cart, $itemId)
    {
        $item = $cart->orderItems()->findOrFail($itemId);
        return $item->delete();
    }

    public function clearCart(Order $cart)
    {
        return $cart->orderItems()->delete();
    }
}
