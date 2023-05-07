<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class AdvertiseCarousel extends Model
{
    protected $fillable = [
        "imageLink",
        "productId"
    ];

    use HasFactory;


    public function images(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
