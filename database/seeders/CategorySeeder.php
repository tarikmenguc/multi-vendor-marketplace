<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // üst kategori
    $electronics = Category::firstOrCreate(
    ['slug' => 'elektronik'],
    ['name' => 'Elektronik']
);

    // alt kategori
    Category::create([
        'name'      => 'Bilgisayar',
        'slug'      => 'bilgisayar',
        'parent_id' => $electronics->id,
    ]);
    }
}
