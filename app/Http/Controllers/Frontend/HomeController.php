<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Wishlist;

class HomeController extends Controller
{
    public function index()
    {
   $bestSellers   = Product::take(8)->get();
        $saleProducts  = Product::inRandomOrder()->take(8)->get();
        $newArrivals   = Product::latest()->take(8)->get();
        $categories    = Category::take(4)->get();
        $featured      = Product::where('is_active', 1)->take(8)->get();
       $userWishlist = auth()->check()
    ? auth()->user()->wishlist()->pluck('product_id')->toArray()
    : [];


        return view('frontend.index', compact(
            'bestSellers','saleProducts','newArrivals','categories','featured','userWishlist'
        ));
    }
}
