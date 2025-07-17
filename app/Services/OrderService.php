<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;

class OrderService
{
    public function create($user, $address): Order
    {
        return DB::transaction(function () use ($user, $address) {
            $cart = $user->cart()->with('items.product')->first();

            if (!$cart || $cart->items->isEmpty()) {
                abort(400, 'Sepet boş.');
            }

            $total = 0;
            $items = [];

            foreach ($cart->items as $item) {
                $product = $item->product;

                if ($item->qty > $product->stock) {
                    abort(400, "Yetersiz stok: $product->name");
                }

                $product->decrement('stock', $item->qty);

                $total += $product->price * $item->qty;

                $items[] = [
                    'product_id' => $product->id,
                    'qty' => $item->qty,
                    'price_at_purchase' => $product->price,
                ];
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'shipping_address' => $address,
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            // Mail job dispatch (kuyağa atılacak)
            Mail::to($user->email)->queue(new OrderPlacedMail($order));

            // Sepeti temizle
            $cart->items()->delete();

            return $order->load('items.product');
        });
    }
}
