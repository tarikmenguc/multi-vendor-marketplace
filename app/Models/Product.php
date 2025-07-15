<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
     protected $fillable = [
        'vendor_id', 'category_id',
        'name', 'slug', 'description',
        'price', 'stock', 'image_path',
    ];

    
    public function vendor()    { return $this->belongsTo(User::class, 'vendor_id'); }
    public function category()  { return $this->belongsTo(Category::class); }
    public function tags()      { return $this->belongsToMany(Tag::class); }
    public function cartItems() { return $this->hasMany(CartItem::class); }
    public function orderItems(){ return $this->hasMany(OrderItem::class); }
}
