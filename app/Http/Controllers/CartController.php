<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $cart = new CartService();
        $cartItems = $cart->getCartItems();


        $ids = Arr::pluck($cartItems, 'product_id');
        $products = Product::query()->whereIn('id', $ids)->get();
        // $cartItems = Arr::keyBy($cartItems, 'product_id');

        // $total = 0;
        // foreach ($products as $product) {
        //     $total += $product->price * $cartItems[$product->id]['quantity'];
        // }

        return response()->json(compact("cartItems"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Product $product
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $cart = new CartService();
        $product = Product::find($request->product_id);

        if ($product) {
            $cart->addCartItem($product->id, $request->quantity);
        }


        return response()->json([
            "cartItems" => $cart->getCartItems(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        //
    }
}
