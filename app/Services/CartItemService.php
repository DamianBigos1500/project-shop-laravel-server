<?php

namespace App\Helpers;

use App\Models\Product;

class CartItemService
{
  private int $product_id;
  private int $user_id;
  private int $quantity = 0;


  public function __construct(int $product_id, int $user_id = null, int $quantity = 1)
  {
    $this->product_id = $product_id;
    $this->user_id = $user_id;
    $this->quantity += $quantity;
  }

  public function getProductId(): int
  {
    return $this->product_id;
  }
  public function getProductRegularPrice(): float
  {
    $product = Product::find($this->product_id);
    if (!$product) return 0;
    return $product->regular_price;
  }

  public function getProductDiscountPrice(): float
  {
    $product = Product::find($this->product_id);
    if (!$product) return 0;
    return  $product->discount_price;
  }

  public function addQuantity($product_id, $quantity): CartItemService
  {
    return new CartItemService($product_id, $this->user_id, $quantity);
  }
}
