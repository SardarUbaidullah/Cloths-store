<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\StockHistory;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        return view('admin.products.products', compact('products'));
    }

    public function add_products()
    {
        return view('admin.products.create');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'size_guide' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'custom_fields' => 'nullable|array',
        ]);


        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['custom_fields'] = $request->custom_fields ? json_encode($request->custom_fields) : null;

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function destroy(Product $product)
    {
       if ($product->image && Storage::disk('public')->exists($product->image)) {
    Storage::disk('public')->delete($product->image);
}


        $product->delete();

        return back()->with('success', 'Product deleted.');
    }

    // Fetch dynamic fields for category (AJAX)
    public function getCategoryFields($id)
    {
        $category = Category::findOrFail($id);
        return response()->json([
            'fields' => json_decode($category->extra_fields, true),
            'size_guide' => $category->size_guide,
        ]);
    }

    // Optional: Toggle status
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('success', 'Product status updated.');
    }



    // control review actions in backend
public function customerReview()
{
    $reviews = Review::with('product')->latest()->get();

    return view('admin.customers.reviews', compact('reviews'));
}

public function updateReview(Request $request, $id)
{
    $review = Review::findOrFail($id);

    $request->validate([
        'status' => 'required|in:approved,rejected',
    ]);

    $review->status = $request->status;
    $review->save();

    return back()->with('success', 'Review status updated.');
}

public function edit($id)
{
    $product    = Product::findOrFail($id);
    $categories = Category::all();
    $product->custom_fields = json_decode($product->custom_fields, true);
    return view('admin.products.edit', compact('product', 'categories'));
}

public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'title' => 'nullable|string',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'size_guide' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'custom_fields' => 'nullable|array',
    ]);

    // ✅ Handle Image
    if ($request->hasFile('image')) {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    // ✅ Handle Custom Fields (Same as STORE)
    $validated['custom_fields'] = $request->custom_fields ? json_encode($request->custom_fields) : $product->custom_fields;

    // ✅ Stock History if Quantity Changed
    $oldQty = $product->quantity;
    $newQty = $request->quantity;

    if ($oldQty != $newQty) {
        StockHistory::create([
            'product_id' => $product->id,
            'change'     => $newQty - $oldQty,
            'type'       => 'manual_update',
            'reference'  => 'Admin Product Update',
            'user_id'    => auth()->id(),
        ]);
    }

    $product->update($validated);

    return redirect()->route('admin.products.index')->with('success', 'Product Updated Successfully');
}


public function allStockHistory()
{
    $histories = StockHistory::with(['product', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();

    return view('admin.products.all_history', compact('histories'));
}


public function filter(Request $request)
{
    $query = \App\Models\Product::query();

    // Category filter
    if($request->category){
        $query->whereHas('category', function($q) use ($request){
            $q->where('slug', $request->category);
        });
    }

    // Price filter
    if($request->min_price && $request->max_price){
        $query->whereBetween('price', [(float)$request->min_price, (float)$request->max_price]);
    }

    // Sorting
    if($request->sort_by){
        switch($request->sort_by){
            case 'price_asc': $query->orderBy('price','asc'); break;
            case 'price_desc': $query->orderBy('price','desc'); break;
            case 'latest': $query->orderBy('created_at','desc'); break;
            case 'popular': $query->orderBy('views','desc'); break;
        }
    }

    $products = $query->paginate(12);

    if($request->ajax()){
        return view('frontend.partials.products_grid', compact('products'))->render();
    }

    return view('frontend.products', compact('products'));
}

}
