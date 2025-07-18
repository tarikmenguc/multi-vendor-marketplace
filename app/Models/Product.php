<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, InteractsWithMedia;
     protected $fillable = [
        'vendor_id', 'category_id',
        'name', 'slug', 'description',
        'price', 'stock', 'image_path',
    ];

     protected static function booted()
    {
        static::creating(function ($product) {
            // Eğer slug zaten varsa, dokunma
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name . '-' . Str::random(6));
            }
        });
    }
          public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->width(300)
             ->height(300)
             ->sharpen(10)
             ->nonQueued(); // thumbnail hemen oluşturulsun
    }
    public function vendor()    { return $this->belongsTo(User::class, 'vendor_id'); }
    public function category()  { return $this->belongsTo(Category::class); }
    public function tags()      { return $this->belongsToMany(Tag::class); }
    public function cartItems() { return $this->hasMany(CartItem::class); }
    public function orderItems(){ return $this->hasMany(OrderItem::class); }
}
