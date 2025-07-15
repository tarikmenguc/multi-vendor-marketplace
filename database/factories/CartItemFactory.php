<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
     protected $model = CartItem::class;

    public function definition(): array
    {
        return [
            'cart_id'    => Cart::inRandomOrder()->value('id')
                           ?? Cart::factory()->create()->id,
            'product_id' => Product::inRandomOrder()->value('id'),
            'qty'        => $this->faker->numberBetween(1, 3),
        ];
    }
}
