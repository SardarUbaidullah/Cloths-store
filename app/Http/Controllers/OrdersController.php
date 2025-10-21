<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\orders;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StockHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrdersController extends Controller
{
    /**
     * Display all orders (admin or user based view).
     */
    public function index()
    {
        $orders = orders::with('items.product')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Store new order - mainly from checkout page.
     */
   public function store(Request $request)
{
    $cart = session('cart', []);
    if (empty($cart)) {
        return back()->with('error', 'Your cart is empty!');
    }

    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    // Create Order
    $order = orders::create([
        'user_id'      => Auth::id(),
        'order_number' => 'OR-' . strtoupper(Str::random(8)),
        'subtotal'     => $subtotal,
        'discount'     => 0,
        'total'        => $subtotal,
        'payment_status' => 'pending',
        'order_status'   => 'processing',
        'ordered_at'   => now(),
    ]);

    // Create Order Items
    foreach ($cart as $item) {
        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $item['id'],
            'quantity'   => $item['quantity'],
            'price'      => $item['price'],
            'total'      => $item['price'] * $item['quantity'],
        ]);
    }

    // Empty Cart
    session()->forget('cart');

    return redirect()->route('user.orders')->with('success', 'Order Placed Successfully!');
}


    /**
     * Show single order details
     */
    public function show($id)
    {
        $order = order::with('items.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Update order status (Admin panel use)
     */
    public function updateStatus(Request $request, $id)
    {
        $order = order::findOrFail($id);
        $order->order_status = $request->order_status;
        $order->payment_status = $request->payment_status;
        $order->save();

        return redirect()->back()->with('success', 'Order Status Updated!');
    }



      public function adminIndex(Request $request)
    {
        $query = Orders::query()->with('user');

        // Optional filters
        if ($request->filled('order_status')) {
            $query->where('order_status', $request->order_status);
        }
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($qbt) use ($q) {
                $qbt->where('order_number', 'like', "%{$q}%")
                    ->orWhereHas('user', function($u) use ($q) {
                        $u->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
                    });
            });
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        // statuses for dropdown (you can change or move to config)
        $orderStatuses = ['pending','processing','shipped','delivered','canceled'];
        $paymentStatuses = ['pending','paid','refunded'];

        return view('admin.orders.index', compact('orders','orderStatuses','paymentStatuses'));
    }

    // Admin: show single order
    public function adminShow($id)
    {
        $order = Orders::with(['items.product','user'])->findOrFail($id);

        $orderStatuses = ['pending','processing','shipped','delivered','canceled'];
        $paymentStatuses = ['pending','paid','refunded'];

        return view('admin.orders.show', compact('order','orderStatuses','paymentStatuses'));
    }

    // Admin: Update status / payment / delivered_at
   public function adminUpdateStatus(Request $request, $id)
{
    $request->validate([
        'order_status'   => 'nullable|string',
        'payment_status' => 'nullable|string',
        'delivered_at'   => 'nullable|date',
    ]);

    $order = Orders::with('items.product')->findOrFail($id);

    $oldStatus = $order->order_status;
    $newStatus = $request->order_status ?? $oldStatus;

    DB::beginTransaction();
    try {
        // Update order_status and payment_status
        if ($request->filled('order_status')) {
            $order->order_status = $request->order_status;

            // If status becomes delivered (or completed), set delivered_at if not set
            if (in_array($request->order_status, ['delivered', 'completed']) && !$order->delivered_at) {
                $order->delivered_at = $request->delivered_at ? \Carbon\Carbon::parse($request->delivered_at) : now();
            }
        }

        if ($request->filled('payment_status')) {
            $order->payment_status = $request->payment_status;
        }

        // Save changes first (so order id exists etc.)
        $order->save();

        // STOCK LOGIC: Decrement stock only when transitioning into delivered/completed
        $shouldDecrement = !in_array($oldStatus, ['delivered', 'completed']) &&
                            in_array($newStatus, ['delivered', 'completed']);

        if ($shouldDecrement) {
            foreach ($order->items as $item) {
                $product = $item->product;
                if (!$product) continue;

                // Decrement safely (ensure integer)
                $decrement = intval($item->quantity);

                // Prevent negative stock
                $newQty = max(0, intval($product->quantity) - $decrement);
                $product->quantity = $newQty;

                // Save product
                $product->save();

    \App\Models\StockHistory::create([
    'product_id' => $product->id,
    'change'     => -$decrement,
    'type'       => 'order',
    'reference'  => $order->order_number,
    'user_id'    => auth()->id(),
]);
            }
        }

        DB::commit();

        return redirect()->back()->with('success', 'Order updated successfully.');
    } catch (\Throwable $e) {
        DB::rollBack();
        \Log::error('Order status update failed: '.$e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong.');
    }
}


    // Admin: delete/cancel order
    public function adminDestroy($id)
    {
        $order = Orders::findOrFail($id);
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted.');
    }

public function userDestroy($id)
{
    $order = Orders::findOrFail($id);
    if ($order->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $order->delete();

    return redirect()->back();
}

    public function userOrders()
{
    $orders = Orders::where('user_id', Auth::id())->latest()->get();
    return view('frontend.orders.index', compact('orders'));
}

public function userOrderShow($order_number)
{
    $order = Orders::with('items.product')
        ->where('user_id', Auth::id())
        ->where('order_number', $order_number)
        ->firstOrFail();

    return view('frontend.orders.show', compact('order'));
}


}
