<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
class MainController extends Controller
{


public function product(Request $request)
{
      $categories = Category::all();

    // Base query
    $query = Product::query();

    // Category: accept array or single value
    if ($request->filled('category')) {
        $cats = $request->category;
        if (!is_array($cats)) {
            $cats = [$cats];
        }
        $query->whereIn('category_id', $cats);
    }

    // Price
    if ($request->filled('min_price')) {
        $query->where('price', '>=', (float)$request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', (float)$request->max_price);
    }

    // Sorting
    if ($request->sort == 'price_asc') {
        $query->orderBy('price', 'asc');
    } elseif ($request->sort == 'price_desc') {
        $query->orderBy('price', 'desc');
    } else { // default or 'latest'
        $query->orderBy('created_at', 'desc');
    }

    // Pagination (12 per page) and keep query string
    $products = $query->paginate(12)->appends($request->query());
       $userWishlist = auth()->check()
    ? auth()->user()->wishlist()->pluck('product_id')->toArray()
    : [];
    // send current filters to view as well (optional)
    return view('frontend.product', compact('products', 'categories','userWishlist'));
}



    public function about()
    {
        return view('frontend.about');
    }
    public function contact()
    {
        return view('frontend.contact');
    }
    public function index()
    {
        return view('frontend.index');
    }

    public function productdetail()
    {
        return view('frontend.product-detail');
    }
    public function shopingcart()
    {
        return view('frontend.shoping-cart');
    }
}
