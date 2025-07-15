<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Her vendor için 5 ürün
        User::whereHas('roles', fn($q) => $q->where('name','vendor'))
            ->each(function ($vendor) {
                Product::factory()->count(5)->create(['vendor_id' => $vendor->id]);
            });

        // Vendor yoksa demo amaçlı 1 vendor + ürün aç
        if (Product::count() === 0) {
            $vendor = User::factory()->create(['name'=>'Demo Vendor']);
            $vendor->assignRole('vendor');
            Product::factory()->count(10)->create(['vendor_id'=>$vendor->id]);
        }
    }
}