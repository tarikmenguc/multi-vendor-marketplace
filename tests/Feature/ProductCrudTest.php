<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_vendor_can_create_product(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $this->seed(\Database\Seeders\RoleSeeder::class);
        $this->seed(\Database\Seeders\PermissionSeeder::class);
        $vendor = User::factory()->create();
        $vendor->assignRole('vendor');

        Sanctum::actingAs($vendor);

        $payload = [
            'name'  => 'MacBook Mini',
            'price' => 999.99,
            'stock' => 12,
        ];

        // Act
        $response = $this->postJson('/api/products', $payload);

        // Assert
        $response->assertCreated()
                 ->assertJsonPath('data.name', 'MacBook Mini');
    }
}
