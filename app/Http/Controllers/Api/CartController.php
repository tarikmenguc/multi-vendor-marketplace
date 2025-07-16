<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
     public function index(CartService $svc){
       $cart = $svc->getUserCart()->load("items.product");
       return new CartResource($cart);
     }

     public function store(AddToCartRequest $request,CartService $svc){
    $item = $svc->AddItem($request->validated());
     return (new CartItemResource($item->load('product')))->response()->setStatusCode(201);
     }
     public function update(Request $request,CartItem $item,CartService $svc){
  
        $update=$svc->updateItemQty($item,$request->input("qty"));
        return new CartItemResource($update);
    }
     public function destroy(CartItem $item, CartService $svc)
    {
        $svc->deleteItem($item);
        return response()->noContent();
    }
}
