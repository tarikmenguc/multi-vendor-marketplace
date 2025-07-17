<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
     public function store(StoreOrderRequest $request, OrderService $orderService)
    {
        $order = $orderService->create($request->user(), $request->validated());

        return new OrderResource($order);
    }

    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with('items.product')->latest()->get();

        return OrderResource::collection($orders);
    }
}
