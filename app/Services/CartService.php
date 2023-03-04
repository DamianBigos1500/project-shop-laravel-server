<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Arr;
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

  public function getCartProducts()
  {
    $ids = Arr::pluck($this->cartItems, 'product_id');
    return Product::whereIn('id', $ids)->get()->map(function ($product) {
      return [
        'id' => $product->id,
        'name' => $product->name,
        'regular_price' => $product->regular_price,
        'discount_price' => $product->discount_price,
        'picture' => $product->images[0]->filename,
        'quantity' => $this->cartItems->where("product_id", $product->id)->first()["quantity"]
      ];
    });
  }

  public function getCartItems()
  {
    if ($this->user) {
      return $this->getDatabaseCartItems();
    } else {
      return $this->getCookieCartItems();
    }
  }

  public function getDatabaseCartItems(): Collection
  {
    return CartItem::where(
      "user_id",
      $this->user->id
    )->get()->map(fn ($item) => [
      "product_id" => $item->product_id,
      "quantity" => $item->quantity
    ]);
  }

  public function getCookieCartItems()
  {
    return collect(json_decode(Cookie::get("cart_items", "[]"), true));
  }

  public function addCartItem(int $productId, int $quantity = 1)
  {
    if ($this->user) {
      $item = CartItem::where(['user_id' => $this->user->id, "product_id" => $productId])->first();
      $item ? $item->delete() : null;
      $newItem = new CartItem([
        'user_id' => $this->user->id,
        "product_id" => $productId,
        "quantity" => $quantity + $item?->quantity ?? 0
      ]);
      if ($newItem->quantity > 0) $this->saveCartItemInDatabase($newItem);
      $this->cartItems = $this->getDatabaseCartItems();
    } else {
      $items = $this->cartItems;
      $item = $items->firstWhere("product_id", $productId);
      $items = $items->reject(fn ($item) => $productId == $item["product_id"]);
      $newItem = [
        "product_id" => $productId,
        "quantity" => $quantity + (isset($item["quantity"]) ? $item["quantity"] : 0)
      ];
      if ($newItem["quantity"] > 0) $items->add($newItem);
      $this->saveCartItemInCookie($items);
      $this->cartItems = $items;
    }
    return new CartService();
  }

  public function moveCartIntoDatabase()
  {
    if ($this->user) {
      $this->resetCartDatabase();
      $items = $this->getCookieCartItems();

      foreach ($items as $item) {
        $this->saveCartItemInDatabase($item["product_id"], $item["quantity"]);
      }

      $this->resetCartCookie();
    }
  }

  public function clearCart()
  {
    if ($this->user) {
      $this->resetCartDatabase();
    } else {
      $this->resetCartCookie();
    }
    return new CartService();
  }

  private function resetCartDatabase()
  {
    $items = CartItem::where('user_id', "=", $this->user->id);
    if ($items) {
      $items->delete();
    }
  }

  private function resetCartCookie()
  {
    Cookie::queue('cart_items', "[]", 0);
  }

  private function saveCartItemInDatabase(CartItem $cartItem)
  {
    $cartItem->save();
    return $cartItem;
  }
  private function saveCartItemInCookie($items)
  {
    Cookie::queue('cart_items', $items, 60 * 24 * 30);
  }
}
