<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class TagFactory extends Factory
{
  protected $model= Tag::class;
    public function definition(): array
    {
        $name=ucfirst($this->faker->unique()->word());
        return [
            "name" => $name,
            "slug"=>Str::slug($name),
        ];
    }
}
