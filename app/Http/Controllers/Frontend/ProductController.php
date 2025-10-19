<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category; // ✅ Make sure this is added
use App\Models\Product;


class ProductController extends Controller
{
    public function categoryProducts($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Load products related to this category
        $products = $category->products()->latest()->get();

        return view('frontend.product', compact('products', 'category'));
    }

    public function show($id)
{
    $product = Product::findOrFail($id);
        $userWishlist = auth()->check()
    ? auth()->user()->wishlist()->pluck('product_id')->toArray()
    : [];

    return view('frontend.product-detail', compact('product','userWishlist'));
}







}

