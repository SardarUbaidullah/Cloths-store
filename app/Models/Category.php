<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

    class Category extends Model
{
   protected $fillable = ['name', 'slug', 'extra_fields', 'size_guide', 'image'];


protected $casts = [
    'extra_fields' => 'array',
];

// public function products()
// {
//     return $this->hasMany(Product::class);
// }

public function products()
{
    return $this->hasMany(\App\Models\Product::class);
}



}


