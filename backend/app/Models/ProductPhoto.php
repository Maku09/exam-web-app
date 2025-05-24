<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductPhoto extends Model
{
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getProductPhotoUrlAttribute(): string
    {
        return Storage::temporaryUrl("{$this->image_path}/{$this->image_name}", now()->addMinutes(5));
    }
}
