<?php


namespace App\Enums;

class OrderStatus
{
  const ORDER_PLACED = 'ORDER_PLACED';
  const ORDER_CONFIRMED = 'ORDER_CONFIRMED';

  const TYPES = [
    self::ORDER_PLACED,
    self::ORDER_CONFIRMED
  ];
}
