<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FavouritCollection extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user_id'];

    public function FavoutitCollection(): HasMany
    {
        return $this->hasMany(UserDetails::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
