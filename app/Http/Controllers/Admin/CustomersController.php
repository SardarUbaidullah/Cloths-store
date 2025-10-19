<?php

namespace App\Http\Controllers\Admin;  // IMPORTANT

use App\Http\Controllers\Controller;  // ADD THIS ALSO
use App\Models\User;

class CustomersController extends Controller
{
    public function index()
    {
        $customers = User::whereHas('orders')
            ->withCount('orders')
            ->withSum('orders as total_spent', 'total')
            ->withMax('orders as last_order_date', 'created_at')
            ->get();

        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
{
    $customer = User::with('orders.items.product')->findOrFail($id);

    return view('admin.customers.show', compact('customer'));
}

}
