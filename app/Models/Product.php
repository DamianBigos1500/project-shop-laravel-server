<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "slug",
        "category_id",
        "product_code",
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

    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function favouritCollections(): BelongsToMany
    {
        return $this->belongsToMany(FavouritCollection::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function ratingSum()
    {
        $ratingSum = $this->ratings->sum('rating') ?? 0;

        if ($ratingSum) {
            return $ratingSum / $this->ratings->count();
        }
        return 0;
    }
    public static function searchQuery()
    {
        return Product::query()
            ->when(request('search'), function ($query) {
                $query->where(function ($query) {
                    $query->where('name', "LIKE", '%' . request('search') . '%')
                        ->orWhere('slug', "LIKE", '%' . request('search') . '%')
                        ->orWhere('short_description', "LIKE", '%' . request('search') . '%')
                        ->orWhere('long_description', "LIKE", '%' . request('search') . '%')
                        ->orWhereHas('category', function ($query) {
                            $query->where('title', "LIKE", '%' . request('search') . '%')
                                ->orWhere('category_slug', "LIKE", '%' . request('search') . '%');
                        })->orWhereHas('category.parent', function ($query) {
                            $query->where('title', "LIKE", '%' . request('search') . '%')
                                ->orWhere('category_slug', "LIKE", '%' . request('search') . '%');
                        });
                });
            });
    }

    public function getName()
    {
        return $this->name;
    }
}
