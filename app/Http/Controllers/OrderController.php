<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {

        $orders = Order::where("email", Auth::user()->email)->with("orderItems")->get();

        return response()->json([
            "order" => $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $cart = new CartService();
        $cartProducts = $cart->getCartProducts();

        if ($cart->getCartItemsCount() <= 0) {
            return response()->json([
                "message" => "You don't have items in cart",
            ], 404);
        }

        $newOrder = Order::create([
            "order_code" =>  Str::orderedUuid(),
            "name" =>  $request->name,
            "surname" =>  $request->surname,
            "email" =>  $request->email,
            "address" =>  $request->address,
            "zip_code" =>  $request->zip_code,
        ]);

        foreach ($cartProducts as $cartProduct) {
            $product = Product::find($cartProduct["id"]);
            $quantity = $cartProduct["quantity"] < $product->quantity ? $cartProduct["quantity"] : $product->quantity;

            OrderItem::create([
                'order_id' => $newOrder->id,
                'product_id' =>  $product->id,
                'price' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        $cart->clearCart();


        return response()->json([
            "newOrder" => $newOrder,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $order_code
     * @return JsonResponse
     */
    public function show(string  $order_code)
    {
        $order = Order::where("order_code", $order_code)->with("orderItems")->first();

        return response()->json([
            "order" => $order
        ]);
    }
}
