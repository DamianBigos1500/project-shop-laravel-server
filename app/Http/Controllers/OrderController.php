<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\StoreOrderRequest;
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

        $orders = Order::where("email", Auth::user()->email)->with("orderItems.product")->get();

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
    public function store(StoreOrderRequest $request)
    {
        $cart = new CartService();
        $cartProducts = $cart->getCartProducts();

        if ($cart->getCartItemsCount() <= 0) {
            return response()->json([
                "message" => "You don't have items in cart",
            ], 404);
        }

        $validated = $request->validated();

        $newOrder = Order::create([
            "order_code" =>  Str::orderedUuid(),
            "name" =>  $validated["name"],
            "surname" =>  $validated["surname"],
            "email" =>  $validated["email"],
            'total_price' => $cart->getCartValue(),
            "address" =>  $validated["address"],
            "zip_code" =>  $validated["zip_code"],
        ]);

        foreach ($cartProducts as $cartProduct) {
            $product = Product::find($cartProduct["id"]);
            $quantity = $cartProduct["quantity"] < $product->quantity ? $cartProduct["quantity"] : $product->quantity;
            $price = $product->discount_price ? $product->discount_price : $product->regular_price;
            OrderItem::create([
                'order_id' => $newOrder->id,
                'product_id' =>  $product->id,
                'price' => $price,
                'quantity' => $quantity,
            ]);
        }



        return response()->json([
            "order" => $newOrder
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function setOrderCash(int  $id)
    {
        $order = $this->setOrderPaymentMethod($id, OrderStatus::CASH_ON_DELIVERY);

        return response()->json([
            "order" => $order
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function setOrderPaypal(int  $id)
    {
        $order = $this->setOrderPaymentMethod($id, OrderStatus::PAYPAL);

        return response()->json([
            "order" => $order
        ]);
    }

    protected function setOrderPaymentMethod($id, $method)
    {

        $cart = new CartService();

        $order = Order::where("id", $id)->first();
        $order->payment_method = $method;
        $order->save();

        $cart->clearCart();

        return $order;
    }
}
