<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ["id", "order_id", "product_id", "price", "quantity"];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
