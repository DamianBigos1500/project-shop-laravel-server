<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        "imagable_id",
        "imagable_type",
        "filename",
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
