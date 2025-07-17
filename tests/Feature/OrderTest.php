<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\OrderPlacedMail;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_place_order_and_stock_decreases_and_mail_is_queued()
    {
        Mail::fake();

        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 10]);

        // sepete ürün ekle
        $this->actingAs($user)->postJson('/api/cart/items', [
            'product_id' => $product->id,
            'qty' => 3,
        ]);

        // siparişi gönder
        $response = $this->actingAs($user)->postJson('/api/orders', [
            'shipping_address' => [
                'name' => 'Tarık',
                'phone' => '05555555555',
                'address' => 'Elazığ, Fırat Üniversitesi',
                'city' => 'Elazığ',
            ],
        ]);

        $response->assertCreated();

        // stok azalmış mı
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 7, // 10 - 3
        ]);

        // mail kuyruğa alındı mı
        Mail::assertQueued(OrderPlacedMail::class);
    }
}
