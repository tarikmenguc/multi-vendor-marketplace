<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
     protected $fillable = ['name', 'slug', 'parent_id'];

      public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

     // Üst kategori → alt kategoriler
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Kategori → ürünler
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
