<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /* 1) ADMIN  */
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        /* 2) VENDOR  */
        $vendor = User::firstOrCreate(
            ['email' => 'vendor@example.com'],
            [
                'name'     => 'Demo Vendor',
                'password' => Hash::make('password'),
            ]
        );
        $vendor->assignRole('vendor');

        /* 3) CUSTOMER  */
        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name'     => 'John Doe',
                'password' => Hash::make('password'),
            ]
        );
        $customer->assignRole('customer');

        /* 4) İsteğe bağlı rastgele müşteriler  */
        User::factory()
            ->count(5)
            ->create()
            ->each(fn ($u) => $u->assignRole('customer'));
    }
}