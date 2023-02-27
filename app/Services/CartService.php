<?php

namespace App\Services;

use App\Models\CartItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartService
{
  private $user = null;
  private Collection $cartItems;

  public function __construct()
  {
    $this->user = Auth::user();
    $this->cartItems = $this->getCartItems();
  }

  public function getCartItemsCount()
  {
    return array_reduce(
      $this->cartItems->toArray(),
      fn ($carry, $item) => $carry + $item["quantity"],
      0
    );
  }

  public function getCartItems()
  {
    if ($this->user) {
      return $this->getDatabaseCartItems()->map(fn ($item) => [
        "product_id" => $item->product_id,
        "quantity" => $item->quantity
      ]);
    } else {
      return $this->getCookieCartItems();
    }
  }

  public function getDatabaseCartItems(): Collection
  {
    return CartItem::where(
      "user_id",
      $this->user->id
    )->get();
  }

  public function getCookieCartItems()
  {
    return collect(json_decode(Cookie::get("cart_items", "[]"), true));
  }

  public function addCartItem(int $productId, int $quantity = 1)
  {
    if ($this->user) {
      $cartItem = CartItem::where(['user_id' => $this->user->id, "product_id" => $productId])->first();
      if ($cartItem) {
        $cartItem->quantity = $quantity;
        $cartItem->save();
      } else {
        CartItem::create(['user_id' => $this->user->id, "product_id" => $productId, "quantity" => $quantity]);
      }
    } else {
      $items = $this->cartItems;
      $cartItem = $items->where("product_id", $productId)->first();

      if ($cartItem) {
        $items =  $items->reject(fn ($item) => $productId == $item["product_id"]);
      }

      $items->add(["product_id" => $productId, "quantity" => $quantity]);

      Cookie::queue('cart_items', $items, 60 * 24 * 30);
    }
  }



  public function moveCartIntoDatabase()
  {
    $request = \request();
    $cartItems = $this->getCookieCartItems();
    $dbCartItems = CartItem::whereIn(['user_id', "=", $this->user->id])->delete();

    $newCartItems = [];

    foreach ($cartItems as $cartItem) {
      $newCartItems[] = [
        "user_id" => $request->user()->id,
        "product_id" => $cartItem["product_id"],
        "quantity" => $cartItem['quantity'],
      ];
    }

    if (!empty($newCartItems)) {
      CartItem::insert($newCartItems);
    }
  }
}
