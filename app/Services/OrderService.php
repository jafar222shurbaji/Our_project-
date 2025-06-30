<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function getUserOrders($userId)
    {
        return Order::with('orderItems')->where('user_id', $userId)->get();
    }


    public function createOrder($userId, array $orderItems)
    {
        $order = Order::create([
            'user_id' => $userId,
            'status' => 'submitted',
            'location' => $orderItems['location'] ?? null,
            'phone_number' => $orderItems['phone_number'],
            'shipping_required' => $orderItems['shipping_required'],
            'payment_method' => $orderItems['payment_method'],
        ]);
        $invoice = Invoice::create([
            'order_id' => $order->id,
            'user_id' => $userId,
            'status' => 'pending',
            'card_number' => $orderItems['card_number'] ?? null,
            'card_code' => $orderItems['card_code'] ?? null,

        ]);
        foreach ($orderItems['order_items'] as $item) {
            $order->orderItems()->create($item);
        }
        return $order->load('orderItems');
    }


    /**
     * Cancel an existing order.
     *
     * @param Order $order
     * @return void
     * @throws \Exception
     */
    public function cancelOrder(Order $order): void
    {
        $user = Auth::user();

        // Ensure the user owns the order
        if ($order->user_id !== $user->id) {
            throw new \Exception('You do not have permission to cancel this order.');
        }

        // Check if the order is already in a state that cannot be cancelled
        if (in_array($order->status, ['shipped', 'delivered', 'cancelled'])) {
            throw new \Exception('Order can no longer be cancelled.');
        }

        $canCancel = false;

        // Rule 1: Shipping required
        if ($order->shipping_required) {
            if ($order->status === 'submitted') {
                $canCancel = true;
            }
        }
        // Rule 2: Shipping not required
        else {
            if ($order->payment_method === 'Online_prepayment' && $order->status === 'submitted') {
                $canCancel = true;
            } elseif ($order->payment_method === 'pay_on_pickup') {
                // User can cancel within 48 hours
                if ($order->created_at->gt(now()->subHours(48))) {
                    $canCancel = true;
                }
            }
        }

        if (!$canCancel) {
            throw new \Exception('The conditions for cancelling this order have not been met.');
        }

        $order->cancel();
    }
