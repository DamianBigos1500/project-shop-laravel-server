<?php


namespace App\Enums;

class OrderStatus
{
  const ORDER_PLACED = 'ORDER_PLACED';
  const ORDER_CONFIRMED = 'ORDER_CONFIRMED';
  const NOT_PAID = 'NOT_PAID';
  const CASH_ON_DELIVERY = 'CASH_ON_DELIVERY';
  const PAYPAL = 'PAYPAL';

  const TYPES = [
    self::ORDER_PLACED,
    self::ORDER_CONFIRMED,
    self::NOT_PAID,
    self::CASH_ON_DELIVERY,
    self::PAYPAL
  ];
}
