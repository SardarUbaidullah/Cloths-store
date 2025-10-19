<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ShopingCartController extends Controller
{
 public function addToCartAndRedirect(Request $request)
{
    $product = Product::findOrFail($request->product_id);
    $cart = session()->get('cart', []);

    $itemKey = $product->id.'-'.($request->size ?? '').'-'.($request->color ?? '');

    if(isset($cart[$itemKey])) {
        $cart[$itemKey]['quantity'] += $request->quantity; // merge quantity if same variations
    } else {
        $cart[$itemKey] = [
            'cart_key' => $itemKey,
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'quantity' => $request->quantity,
            'size' => $request->size ?? null,
            'color' => $request->color ?? null,
        ];
    }

    session()->put('cart', $cart);
    return redirect()->route('frontend.shopping.cart')->with('success', 'Product added to cart!');
}

public function updateQuantity(Request $request, $key)
{
    $cart = session()->get('cart', []);
    if(isset($cart[$key])) {
        $cart[$key]['quantity'] = max(1, $request->quantity); // prevent zero
        session()->put('cart', $cart);
    }
    return back()->with('success', 'Quantity updated!');
}


public function remove(Request $request, $key)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$key])) {
        unset($cart[$key]);

        if (!empty($cart)) {
            session()->put('cart', $cart);
        } else {
            session()->forget('cart');
        }
    }

    return redirect()->back()->with('success', 'Item removed from cart.');
}



    public function cartSidebar()
    {
        $cart = session('cart', []);
        $items = view('frontend.partials.cart-sidebar-items', compact('cart'))->render();
        $total = view('frontend.partials.cart-sidebar-total', compact('cart'))->render();

        return response()->json([
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function viewCart()
    {
        $cart = session('cart', []);
        return view('frontend.shoping-cart', compact('cart'));
    }


}
