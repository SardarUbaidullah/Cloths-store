<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ProductDetailController extends Controller
{
 public function storeReview(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'title' => 'nullable|string|max:255',
        'review' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    Review::create([
        'product_id' => $request->product_id,
        'name' => $request->name,
        'email' => $request->email,
        'title' => $request->title,
        'review' => $request->review,
        'rating' => $request->rating,
        'status' => 'pending', // ⭐ important: hide until admin approves
    ]);

    return back()->with('success', 'Thank you! Your review will be published as soon as it is approved by the shop admin.');
}
}
