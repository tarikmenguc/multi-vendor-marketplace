<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class CartService {

public function getUserCart(): Cart
{
    return Cart::firstOrCreate(
        ['user_id' => Auth::id()]
    );
}

public function AddItem(array $data){

     $cart = $this->getUserCart();
     return DB::transaction(function () use ($cart,$data){
        $item = $cart ->items()->where("product_id",$data["product_id"])->first();

        if($item){
         $item->increment("qty",$data["qty"]);
         return $item->refresh();
        }
        return $cart->items()->create([ 'product_id' => $data['product_id'],
                'qty'        => $data['qty'],]);
     });
    }
    public function updateItemQty(CartItem $item,int $qty){
     $item->update(["qty"=>$qty]);
     return $item->refresh();
    }
   public function deleteItem(CartItem $item) :void{
    $item->delete();
   }
}