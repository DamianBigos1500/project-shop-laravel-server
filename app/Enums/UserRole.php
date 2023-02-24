<?php


namespace App\Enums;

class UserRole
{
  const ADMIN = 'ADMIN';
  const USER = 'USER';

  const TYPES = [
    self::ADMIN,
    self::USER
  ];
}
