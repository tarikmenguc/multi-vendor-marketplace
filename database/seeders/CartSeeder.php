<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        // Her müşteri için 1 sepet
        User::role('customer')->each(function ($u) {
            $u->cart()->firstOrCreate();   // relation yoksa oluştur
        });
    }
}