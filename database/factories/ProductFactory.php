<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true); // “Ultra Gaming Mouse”

        return [
            'vendor_id'   => User::whereHas('roles', fn($q) => $q->where('name','vendor'))
                                 ->inRandomOrder()->value('id')
                             ?? User::factory()->create()->id, // fallback
            'category_id' => Category::inRandomOrder()->value('id'),
            'name'        => ucfirst($name),
            'slug'        => Str::slug($name),
            'description' => $this->faker->sentence(15),
            'price'       => $this->faker->randomFloat(2, 10, 500),
            'stock'       => $this->faker->numberBetween(1, 150),
            'image_path'  => null, // Medialibrary ile sonradan dolacak
        ];
    }

    /** After-create: rastgele etiket iliştir */
    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            $tagIds = \App\Models\Tag::inRandomOrder()->take(random_int(1,3))->pluck('id');
            $product->tags()->attach($tagIds);
        });
    }
}

