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
    public function index(): JsonResponse
    {
        $cart = new CartService();

        return response()->json([
            "cartItems" => $cart->getCartProducts(),
            "cartCount" => $cart->getCartItemsCount()
        ]);
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
            $cart->addCartItem($product->id, $request->quantity);

            return response()->json([
                "cartItems" => $cart->getCartProducts(),
                "cartCount" => $cart->getCartItemsCount()
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
            "cartItems" => $cart->getCartProducts(),
            "cartCount" => $cart->getCartItemsCount()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function clearCart()
    {
        $cart = new CartService();
        $cart->clearCart();

        return response()->json([
            "cart" => $cart->getCartProducts()
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $cart = new CartService();
        $cart->removeCartItem($id);

        return response()->json([
            "cartItems" => $cart->getCartProducts(),
            "cartCount" => $cart->getCartItemsCount()
        ]);
    }
}
