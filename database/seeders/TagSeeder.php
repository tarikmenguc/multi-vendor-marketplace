<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $preset=["yeni","indirim","popüler","Stokta","özel"];
       foreach($preset as $tag){
      Tag::firstOrCreate(
        ["slug"=>Str::slug($tag)],
        ["name" => $tag]
      );
       }
       Tag::factory()->count(15)->create();
    }
}
