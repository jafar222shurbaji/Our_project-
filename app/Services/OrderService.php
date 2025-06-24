<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public function getUserOrders($userId)
    {
        return Order::with('orderItems')->where('user_id', $userId)->get();
    }

    public function getOrder($id, $userId)
    {
        return Order::with('orderItems')->where('user_id', $userId)->findOrFail($id);
    }

    public function createOrder($userId, array $orderItems)
    {
        $order = Order::create([
            'user_id' => $userId,
            'status' => 'cart',
        ]);
        foreach ($orderItems as $item) {
            $order->orderItems()->create($item);
        }
        return $order->load('orderItems');
    }

    public function updateOrder(Order $order, array $data)
    {
        if (isset($data['status'])) {
            $order->status = $data['status'];
            $order->save();
        }
        if (isset($data['order_items'])) {
            foreach ($data['order_items'] as $item) {
                if (isset($item['id'])) {
                    $orderItem = $order->orderItems()->find($item['id']);
                    if ($orderItem) {
                        $orderItem->update($item);
                    }
                } else {
                    $order->orderItems()->create($item);
                }
            }
        }
        return $order->load('orderItems');
    }

    public function deleteOrder(Order $order)
    {
        return $order->delete();
    }
}
