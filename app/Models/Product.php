<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "slug",
        "code",
        "short_description",
        "long_description",
        "regular_price",
        "discount_price",
        "is_available",
        "quantity",
        "deleted_by",
    ];

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}
