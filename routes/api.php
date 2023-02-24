<?php

use App\Http\Controllers\AdvertiseCarouselController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get("products-paths", [ProductsController::class, "getProductPaths"]);
Route::resource('products', ProductsController::class)->only(['index', 'show']);
Route::resource('categories', CategoriesController::class)->only(['index']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get("user", function (Request $request) {
        return $request->user();
    });
    Route::resource("advertise-carousel", AdvertiseCarouselController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('users', UsersController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('products', ProductsController::class)->only(['create', 'store', 'update', 'destroy']);
    Route::resource('categories', CategoriesController::class)->only(['store', 'show', 'update', 'destroy']);
    Route::resource('reviews', ProductReviewController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
});
