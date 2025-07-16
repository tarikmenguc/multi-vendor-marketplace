<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $perms = [
            // ürün yönetimi
            'product.view', 'product.create', 'product.update', 'product.delete',
            // sipariş yönetimi
            'order.view', 'order.update',
        ];

        foreach ($perms as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Admin rolüne tüm izinleri verdin
        $admin = \Spatie\Permission\Models\Role::where('name', 'admin')->first();
        $admin?->givePermissionTo($perms);

        $vendor = \Spatie\Permission\Models\Role::where('name', 'vendor')->first();
        $vendor?->givePermissionTo(['product.create', 'product.update', 'product.delete', 'product.view']);
    }
}
