<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   
    use HasFactory;

    protected $fillable =["user_id","total","status","shipping_address",];

      protected $casts = [
        'shipping_address' => 'array',
    ];//otomatik veri dönüşümü 

    public function user() { return $this->belongsTo(User::class); }
    public function items()  { return $this->hasMany(OrderItem::class); }
    public function products(){ return $this->belongsToMany(Product::class,"order_items")->withPivot("qty","price_at_purchase");}
    
}
