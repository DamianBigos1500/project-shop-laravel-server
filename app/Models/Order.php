<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "id", "order_code", 'name', "surname", "email",
        "telephone", "street", "address", "city", "total_price",
        "zip_code", "payment_method", "status"
    ];


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
