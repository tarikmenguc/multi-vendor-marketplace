<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;               // ① Str helper’ını *mutlaka* ekle

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        // Rastgele benzersiz kategori adı
        $name = ucfirst($this->faker->unique()->words(2, true));

        return [
            'name'      => $name,
            'slug'      => Str::slug($name),   // Str helper doğru import edildi
            'parent_id' => null,
        ];
    }

    /** Alt kategori (child) üretmek için state */
    public function childOf(?Category $parent = null): static   // ② Nullable type hint
    {
        // Parametre yoksa rastgele kök kategori seç
        $parent = $parent ?: Category::inRandomOrder()->first();

        return $this->state(fn () => [
            'parent_id' => $parent?->id,
        ]);
    }
}
