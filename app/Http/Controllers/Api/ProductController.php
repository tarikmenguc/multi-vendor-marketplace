<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{

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
