<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Add / Remove Product
  public function toggle(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->product_id;

        $existing = Wishlist::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if($existing) {
            // Remove from wishlist
            $existing->delete();
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
        }

        return back(); // page reload
    }

    // Show User Wishlist
    public function index()
    {
        $wishlistItems = Wishlist::with('product')->where('user_id', Auth::id())->get();
        return view('frontend.wishlist.index', compact('wishlistItems'));
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ]);

        return back()->with('success','Added to wishlist!');
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->delete();

        return back()->with('success','Removed From wishlist!');
    }
}
