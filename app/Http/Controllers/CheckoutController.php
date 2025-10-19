<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
   public function process(Request $request)
    {
        $cart = session('cart', []);
        if(empty($cart)){
            return back()->with('error','Your cart is empty!');
        }

        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|max:255',
            'phone'=>'required|string|max:20',
            'address'=>'required|string|max:500',
        ]);

        $subtotal = 0;
        foreach($cart as $item){
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Create Order
        $order = Orders::create([
            'user_id'       => Auth::id(),
            'order_number'  => 'OR-' . strtoupper(Str::random(8)),
            'subtotal'      => $subtotal,
            'discount'      => 0,
            'total'         => $subtotal,
            'payment_status'=> 'pending',
            'order_status'  => 'processing',
            'ordered_at'    => now(),
        ]);

        // Create Order Items
        foreach($cart as $item){
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'total'      => $item['price'] * $item['quantity'],
            ]);
        }

        $otp = rand(100000,999999);
        Session::put('checkout_otp', $otp);
        Session::put('checkout_order_id', $order->id);

        session()->flash('success', "Order placed successfully! OTP sent: $otp");
        Session::forget('cart');

        return redirect()->route('user.orders');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $sessionOtp = Session::get('checkout_otp');
        $checkoutData = Session::get('checkout_data');
        $cart = session('cart', []);

        if($request->otp != $sessionOtp){
            return back()->with('error','Invalid OTP');
        }

        $order = Orders::create([
            'name' => $checkoutData['name'],
            'email'=> $checkoutData['email'],
            'phone'=> $checkoutData['phone'],
            'address'=> $checkoutData['address'],
            'payment_method' => 'COD',
            'status' => 'Pending',
            'total_amount' => collect($cart)->sum(function($item){ return $item['price'] * $item['quantity']; }),
        ]);

        foreach($cart as $item){
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'size' => $item['size'] ?? null,
                'color' => $item['color'] ?? null,
            ]);
        }

        Session::forget(['cart','checkout_otp','checkout_data']);

        return redirect('/')->with('success','Order placed successfully!');
    }
}
