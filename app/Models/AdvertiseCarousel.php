<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertiseCarousel extends Model
{
    protected $fillable = [
        "imageLink",
        "link"
    ];

    use HasFactory;
}
