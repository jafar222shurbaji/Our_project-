<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getUserOrders(Auth::id());
        return OrderResource::collection($orders);
    }



    public function store(CreateOrderRequest $request)
    {
        $validated = $request->validated();

        $order = $this->orderService->createOrder(Auth::id(), $validated);
        return ApiResponse::successWithData((new OrderResource($order))->toArray(request()), "added successfully", 201);
    }



    public function cancel(Order $order)
    {
        try {
            $this->orderService->cancelOrder($order);
            return ApiResponse::success('Order cancelled successfully.', 200);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 403);
        }
    }
}
