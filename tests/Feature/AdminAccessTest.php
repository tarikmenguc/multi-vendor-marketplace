<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RoleSeeder;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;


    protected function setUp(): void
{
    parent::setUp();
    $this->seed([
    \Database\Seeders\RoleSeeder::class,
    \Database\Seeders\PermissionSeeder::class,
]);
}

    public function test_admin_can_access_admin_page(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $res = $this->actingAs($admin)->get('/admin/panel');

        $res->assertOk();
    }

    public function test_vendor_cannot_access_admin_page(): void
    {
        $vendor = User::factory()->create();
        $vendor->assignRole('vendor');

        $res = $this->actingAs($vendor)->get('/admin/panel');

        $res->assertForbidden();
    }

    public function test_guest_redirected_from_admin_page(): void
    {
        $res = $this->get('/admin/panel');

        $res->assertRedirect('/login'); // veya api için 401
    }
}
