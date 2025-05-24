<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $with = ['product_photos', 'category'];

    protected $fillable = [
        'title',
        'price',
        'category_id',
        'description',
        'created_by'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function product_photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }
}
