<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ["id", "order_code", 'status', "name", "payment_method", "surname", "email", "address", "zip_code"];


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
