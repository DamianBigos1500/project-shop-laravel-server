<?php

use App\Http\Controllers\AdvertiseCarouselController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get("products-paths", [ProductsController::class, "getProductPaths"]);
Route::resource('products', ProductsController::class)->only(['index', 'show']);
Route::resource('categories', CategoriesController::class)->only(['index']);
Route::get('category-slug/{slug}', [CategoriesController::class, 'getCategoryBySlug']);
Route::get('products-category/{slug}', [CategoriesController::class, 'getProductsByCategory']);

Route::resource('cart', CartController::class)->only(['index', 'store', 'destroy']);
Route::post('/move-cart', [CartController::class, "moveCart"]);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get("user", function (Request $request) {
        return $request->user();
    });
    Route::resource("advertise-carousel", AdvertiseCarouselController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('users', UsersController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('categories', CategoriesController::class)->only(['store', 'show', 'update', 'destroy']);
    Route::resource('products', ProductsController::class)->only(['create', 'store', 'update', 'destroy']);
    Route::resource('reviews', ProductReviewController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
});
