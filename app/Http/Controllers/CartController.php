<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

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


        // $cartItems = Arr::keyBy($cartItems, 'product_id');

        // $total = 0;
        // foreach ($products as $product) {
        //     $total += $product->price * $cartItems[$product->id]['quantity'];
        // }

        return response()->json(compact("cartItems"));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $cart = new CartService();
        $product = Product::find($request->product_id);

        if ($product && $product->quantity > $request->quantity) {
            return response()->json([
                "message" => $cart->addCartItem($product->id, $request->quantity)->getCartItems()
            ]);
        }

        return response()->json([
            "message" => 'cannot find product'
        ], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function moveCart(Request $request): JsonResponse
    {
        $cart = new CartService();
        $cart->moveCartIntoDatabase();

        return response()->json([
            "message" => 'cart has been moved'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy()
    {
        $cart = new CartService();
        $cart->clearCart();

        return response()->json([
            "message" => "Cart has been cleared"
        ]);
    }
}
