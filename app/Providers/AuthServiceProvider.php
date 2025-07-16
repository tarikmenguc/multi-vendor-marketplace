<?php

namespace App\Providers;

use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
     protected $policies = [
        Product::class =>  ProductPolicy::class,
    ];

    public function boot(): void
    {
        // Laravel policy binding burada yapılır
    }
}
