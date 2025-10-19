<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Orders;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Dashboard
    public function index()
    {
      $months = collect();
        $sales = collect();

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('M Y');
            $months->push($month);

            $total = OrderItem::whereMonth('created_at', Carbon::now()->subMonths($i)->month)
                              ->whereYear('created_at', Carbon::now()->subMonths($i)->year)
                              ->sum('quantity'); // ya price * quantity
            $sales->push($total);
        }

        // ----- Low Stock Products -----
        $lowStockProducts = Product::where('quantity', '<=', 5)->get();
        $lowStockNames = $lowStockProducts->pluck('name');
        $lowStockQty = $lowStockProducts->pluck('quantity');

        // ----- Category-wise Product Count -----
        $categories = Category::withCount('products')->get();
        $categoryNames = $categories->pluck('name');
        $categoryCounts = $categories->pluck('products_count');

        return view('admin.dashboard', compact(
            'months','sales',
            'lowStockNames','lowStockQty',
            'categoryNames','categoryCounts'
        ));

    }

    // Product Views


    // Category Views
    public function category()
    {
        return view('admin.products.category');
    }

    public function add_category()
    {
        return view('admin.products.add_category');
    }

    // Brand Views
    public function brand()
    {
        return view('admin.products.brands');
    }

    public function add_brand()
    {
        return view('admin.products.add_brand');
    }

    // Orders
    public function order()
    {
        return view('admin.orders.index');
    }

    public function order_detail()
    {
        return view('admin.orders.details');
    }

    public function pending()
    {
        return view('admin.orders.pending');
    }

    public function completed()
    {
        return view('admin.orders.completed');
    }

    // Customers
    public function customer()
    {
        return view('admin.customers.index');
    }

    public function customer_review()
    {
        return view('admin.customers.reviews');
    }
}
