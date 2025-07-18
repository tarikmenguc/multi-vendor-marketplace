<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImageRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{


    public function uploadImage(ProductImageRequest $request, Product $product)
{
    Gate::authorize('update', $product); // sadece ürün sahibinin yüklemesine izin ver

    // Önceki resmi sil
    $product->clearMediaCollection();

    // Yeni resmi yükle ve "thumb" oluştur
    $product->addMediaFromRequest('image')
            ->toMediaCollection('images');

    return response()->json([
        'message' => 'Görsel başarıyla yüklendi.',
    ]);
}

public function index()
{
    $products = Product::with(['category','tags'])
               ->latest()->paginate(15);

    return ProductResource::collection($products);
}

public function store(StoreProductRequest $req, ProductService $svc)
{
    $product = $svc->create($req->validated())
                   ->load(['category','tags']);

    return (new ProductResource($product))
           ->response()->setStatusCode(201);
}


}
