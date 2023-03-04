<?php

use App\Http\Controllers\AdvertiseCarouselController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\FavouritController;
use App\Http\Controllers\FavouritProductController;
use Illuminate\Support\Facades\Route;


Route::get("inde", [IndexController::class, "getStrage"]);

Route::get("products-paths", [ProductsController::class, "getProductPaths"]);
Route::resource('products', ProductsController::class)->only(['index', 'show']);
Route::resource('categories', CategoriesController::class)->only(['index']);
Route::get('category-slug/{slug}', [CategoriesController::class, 'getCategoryBySlug']);
Route::get('products-category/{slug}', [CategoriesController::class, 'getProductsByCategory']);

Route::get('/index', [IndexController::class, "index"]);


// Cart
Route::resource('cart', CartController::class)->only(['index', 'store', 'destroy']);
Route::delete('/cart', [CartController::class, "clearCart"]);
Route::get('/cart-count', [CartController::class, "productsCount"]);
Route::post('/move-cart', [CartController::class, "moveCart"]);


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get("user", [UsersController::class, 'getUser']);
    Route::resource("advertise-carousel", AdvertiseCarouselController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('users', UsersController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('categories', CategoriesController::class)->only(['store', 'show', 'update', 'destroy']);
    Route::resource('products', ProductsController::class)->only(['create', 'store', 'update', 'destroy']);
    Route::resource('favourit', FavouritController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('favourit-product', FavouritProductController::class)->only(['index', 'store', 'update']);
    Route::resource('/favourit-product/{favouritCollection}/{product}', FavouritProductController::class)->only(['destroy']);
    Route::resource('reviews', ProductReviewController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
});
