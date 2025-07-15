<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $address = [
            'name'   => $this->faker->name,
            'phone'  => $this->faker->phoneNumber,
            'city'   => $this->faker->city,
            'street' => $this->faker->streetAddress,
        ];

        return [
            'user_id'          => User::role('customer')->inRandomOrder()->value('id')
                                 ?? User::factory()->create()->id,
            'total'            => 0,            // afterCreating’de güncellenecek
            'status'           => 'pending',
            'shipping_address' => $address,
        ];
    }

    // ürünleri ve satır kalemlerini iliştir 
    public function configure(): static
    {
        return $this->afterCreating(function (Order $order) {
            $products = Product::inRandomOrder()->take(random_int(1, 4))->get();

            $total = 0;
            foreach ($products as $p) {
                $qty   = random_int(1, 3);
                $total += $p->price * $qty;

                $order->items()->create([
                    'product_id'        => $p->id,
                    'qty'               => $qty,
                    'price_at_purchase' => $p->price,
                ]);
            }
            $order->update(['total' => $total]);
        });
    }
}
