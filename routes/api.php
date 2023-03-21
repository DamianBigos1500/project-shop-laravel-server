<?php

use App\Http\Controllers\admin\CategoriesAdminController;
use App\Http\Controllers\admin\ProductImagesAdminController;
use App\Http\Controllers\admin\ProductsAdminController;
use App\Http\Controllers\admin\UsersAdminController;
use App\Http\Controllers\AdvertiseCarouselController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\FavouritController;
use App\Http\Controllers\FavouritProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get("inde", [IndexController::class, "getStrage"]);

Route::get("products-paths", [ProductsController::class, "getProductPaths"]);
Route::resource('products', ProductsController::class)->only(['index', 'show']);
Route::resource('categories', CategoriesController::class)->only(['index']);
Route::get('category-slug/{slug}', [CategoriesController::class, 'getCategoryBySlug']);
Route::get('products-category/{slug}', [ProductsController::class, 'getProductsByCategory']);
Route::get('products-search', [ProductsController::class, 'getSearchedProducts']);

Route::get('/index', [IndexController::class, "index"]);


// Cart
Route::resource('cart', CartController::class)->only(['index', 'store', 'destroy']);
Route::delete('/cart', [CartController::class, "clearCart"]);
Route::get('/cart-count', [CartController::class, "productsCount"]);
Route::post('/move-cart', [CartController::class, "moveCart"]);

Route::resource('orders', OrderController::class)->only(['index', 'store', 'show']);
Route::resource('ratings', RatingsController::class)->only(["show", "store", "update", "destroy"]);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get("user", [UsersController::class, 'getUser']);
    Route::resource("advertise-carousel", AdvertiseCarouselController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('users', UsersController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('categories', CategoriesController::class)->only(['store', 'show', 'update', 'destroy']);
    Route::resource('favourit', FavouritController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('favourit-product', FavouritProductController::class)->only(['index', 'store', 'update']);
    Route::delete('/favourit-product/{favouritCollection}/{product}', [FavouritProductController::class, 'destroy']);
});

Route::middleware(["auth:sanctum"])->prefix("admin")->group(function () {
    Route::resource('/users', UsersAdminController::class)->only(["index", 'store', 'show', 'destroy']);

    Route::resource('/products', ProductsAdminController::class)->only(["index", 'store', 'show', 'update', 'destroy']);
    Route::resource('/product-images', ProductImagesAdminController::class)->only(["index", 'store', 'destroy']);

    Route::resource('/categories', CategoriesAdminController::class)->only(["index", 'store', 'show', 'destroy']);
    Route::get('/categories-children', [CategoriesAdminController::class, "getCategoriesChildren"]);
});
