<?php
namespace App\Services;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProductService
{
    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {
           // Giriş yapan kullanıcıyı vendor olarak ata
        $data['vendor_id'] = Auth::id();
            $product = Product::create($data);

            if (!empty($data['tag_ids'])) {
                $product->tags()->sync($data['tag_ids']);
            }

            return $product;
        });
    }

     public function update(Product $product, array $data): Product
    {
        DB::transaction(function () use ($product, $data) {
            $product->update($data);
            $product->tags()->sync($data['tag_ids'] ?? []);
        });

        return $product->refresh();
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }




} 