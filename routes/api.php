<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Ürün CRUD işlemleri (S-2)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductController::class)->except('show');
});