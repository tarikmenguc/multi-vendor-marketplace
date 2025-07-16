<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_item_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 20]);

        $res = $this->actingAs($user)->postJson('/api/cart/items', [
            'product_id' => $product->id,
            'qty' => 2
        ]);

        $res->assertCreated()
            ->assertJsonPath('data.product.id', $product->id)
            ->assertJsonPath('data.qty', 2);
    }

    public function test_user_can_view_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)->postJson('/api/cart/items', [
            'product_id' => $product->id,
            'qty' => 1
        ]);

        $res = $this->actingAs($user)->getJson('/api/cart');

        $res->assertOk()
            ->assertJsonStructure(['data' => ['id', 'items' => [['id', 'qty', 'product']]]]);
    }

    public function test_user_can_update_cart_item_qty()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $item = $this->actingAs($user)->postJson('/api/cart/items', [
            'product_id' => $product->id,
            'qty' => 1
        ])->json('data');
        $this->assertNotNull($item);

        $res = $this->actingAs($user)->putJson('/api/cart/items/' . $item['id'], [
            'qty' => 5
        ]);

        $res->assertOk()
            ->assertJsonPath('data.qty', 5);
    }

    public function test_user_can_remove_cart_item()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $item = $this->actingAs($user)->postJson('/api/cart/items', [
            'product_id' => $product->id,
            'qty' => 3
        ])->json('data');
        $this->assertNotNull($item);

        $res = $this->actingAs($user)->deleteJson('/api/cart/items/' . $item['id']);

        $res->assertNoContent();
    }
}
