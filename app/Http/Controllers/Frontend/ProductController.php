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


   public function search(Request $request)
    {
        $q = (string) $request->query('query', '');
        $categoryId = $request->query('category_id', null);
        try {
            if (strlen(trim($q)) < 2) {
                return response()->json([], 200);
            }

            // base query (only active products)
            $base = Product::query()
                ->where('is_active', 1)
                ->where(function($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });

            // If category selected -> prefer those first (C3)
            if ($categoryId) {
                // Use raw ordering so category matches come first
                $products = (clone $base)
                    ->select('id','name','slug','price','image','category_id')
                    ->orderByRaw("CASE WHEN category_id = ? THEN 0 ELSE 1 END", [$categoryId])
                    ->orderBy('name')
                    ->with('category')
                    ->limit(12)
                    ->get();
            } else {
                $products = $base
                    ->select('id','name','slug','price','image','category_id')
                    ->orderBy('name')
                    ->with('category')
                    ->limit(12)
                    ->get();
            }

            return response()->json($products, 200);
        } catch (Exception $e) {
            Log::error('Search error: '.$e->getMessage().' on '.$e->getFile().' line '.$e->getLine());
            return response()->json(['message' => 'Internal Server Error (see logs)'], 500);
        }
    }

    // optional: search page (full results)
    public function searchPage(Request $request)
{
    $q = (string) $request->query('query', '');
    $categoryId = $request->query('category_id', null);
    $priceMin = $request->query('price_min', null);
    $priceMax = $request->query('price_max', null);
    $sort = $request->query('sort', 'relevance'); // relevance / price_asc / price_desc / newest

    // Base query: active products
    $query = \App\Models\Product::with('category')
        ->where('is_active', 1);

    if (strlen(trim($q)) >= 2) {
        $query->where(function($sub) use ($q) {
            $sub->where('name', 'like', "%{$q}%")
                ->orWhere('title', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%");
        });
    }

    if ($categoryId) {
        $query->where('category_id', $categoryId);
    }

    if ($priceMin !== null && is_numeric($priceMin)) {
        $query->where('price', '>=', floatval($priceMin));
    }

    if ($priceMax !== null && is_numeric($priceMax)) {
        $query->where('price', '<=', floatval($priceMax));
    }

    // Sorting
    switch ($sort) {
        case 'price_asc':
            $query->orderBy('price', 'asc');
            break;
        case 'price_desc':
            $query->orderBy('price', 'desc');
            break;
        case 'newest':
            $query->orderBy('created_at', 'desc');
            break;
        default:
            // relevance: if query exists, try to order by name match first
            if (strlen(trim($q)) >= 2) {
                $query->orderByRaw("CASE WHEN name LIKE ? THEN 0 ELSE 1 END", ["%{$q}%"]);
            }
            $query->orderBy('name', 'asc');
            break;
    }

    $perPage = 24;
    $products = $query->paginate($perPage)->appends(request()->query());

    // Suggestions if none found
    $suggestions = collect();
    if ($products->count() === 0) {
        if ($categoryId) {
            $suggestions = \App\Models\Product::where('is_active',1)
                ->where('category_id', $categoryId)
                ->inRandomOrder()->take(8)->get();
        }
        if ($suggestions->isEmpty()) {
            $suggestions = \App\Models\Product::where('is_active',1)
                ->inRandomOrder()->take(8)->get();
        }
    }

    // categories for left filter
    $categories = \App\Models\Category::orderBy('name')->get();

    return view('frontend.search', compact('products','q','categories','categoryId','priceMin','priceMax','sort','suggestions'));
}



}

