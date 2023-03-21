<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
            "cartCount" => $cart->getCartItemsCount(),
            "cartTotalSum" => $cart->getCartValue()
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

        if (!$product) {
            return response()->json([
                "message" => 'cannot find product'
            ], 404);
        }



        $itemQty = $cart->addCartItem($product->id, $request->quantity, $product->quantity);
        return response()->json([
            "cartItems" => $cart->getCartProducts(),
            "cartCount" => $cart->getCartItemsCount(),
            "cartTotalSum" => $cart->getCartValue(),
            "itemQty" => $itemQty
        ]);
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
            "cartCount" => $cart->getCartItemsCount(),
            "cartTotalSum" => $cart->getCartValue()
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
            "message" => "Cart items removed succesfuly"
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $cart = new CartService();
        $cart->removeCartItem($id);

        return response()->json([
            "cartItems" => $cart->getCartProducts(),
            "cartCount" => $cart->getCartItemsCount(),
            "cartTotalSum" => $cart->getCartValue()
        ]);
    }
}
