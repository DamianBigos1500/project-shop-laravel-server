<?php

use App\Http\Controllers\AdvertiseCarouselController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProductsController;
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

Route::middleware(['auth:sanctum, "verified'])->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware(['auth', 'verified'])->group(function () {
});

Route::resource("advertiseCarousel", AdvertiseCarouselController::class)->only(['index', 'store', 'update', 'destroy',]);
Route::resource('users', UsersController::class)->only(['index', 'store', 'update', 'destroy',]);
Route::resource('products', ProductsController::class)->only(['index', 'store', 'show', 'update', 'destroy',]);
