<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'title',
        'description',
        'price',
        'quantity',
        'image',
        'category_id',
        'custom_fields',
        'size_guide',
        'is_active',
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

     // Scopes
    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeLowStock($query, $threshold = 5)
    {
        return $query->where('quantity', '<', $threshold)->where('quantity', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', '<=', 0);
    }

    // Helpers
    public function isLowStock($threshold = 5): bool
    {
        return $this->quantity > 0 && $this->quantity < $threshold;
    }

    public function isOutOfStock(): bool
    {
        return $this->quantity <= 0;
    }

public function orderItems()
{
    return $this->hasMany(OrderItem::class, 'product_id', 'id');
}

}

