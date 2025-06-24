<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function show($id)
    {
        $order = $this->orderService->getOrder($id, Auth::id());
        return new OrderResource($order);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|integer|exists:products,id',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.price' => 'required|numeric|min:0',
        ]);
        $order = $this->orderService->createOrder(Auth::id(), $validated['order_items']);
        return (new OrderResource($order))->response()->setStatusCode(201);
    }

    public function update(Request $request, $id)
    {
        $order = $this->orderService->getOrder($id, Auth::id());
        $validated = $request->validate([
            'status' => 'sometimes|string',
            'order_items' => 'sometimes|array',
            'order_items.*.id' => 'sometimes|integer|exists:order_items,id',
            'order_items.*.product_id' => 'required_with:order_items|integer|exists:products,id',
            'order_items.*.quantity' => 'required_with:order_items|integer|min:1',
            'order_items.*.price' => 'required_with:order_items|numeric|min:0',
        ]);
        $order = $this->orderService->updateOrder($order, $validated);
        return new OrderResource($order);
    }

    public function destroy($id)
    {
        $order = $this->orderService->getOrder($id, Auth::id());
        $this->orderService->deleteOrder($order);
        return response()->json(['message' => 'Order deleted'], 200);
    }
}
