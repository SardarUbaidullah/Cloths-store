<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{

  // To
public function create()
{
    return view('admin.products.add_category');
}
  public function index()
    {
        // Fetch categories and return view, example:
        $categories = \App\Models\Category::all();
        return view('admin.products.category', compact('categories'));
    }

public function destroy($id)
{
    $category = Category::findOrFail($id);
    $category->delete();

    return redirect()->route('admin.products.category')->with('success', 'Category deleted successfully.');
}



    // Store a new category with optional dynamic fields and size guide.


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'extra_fields' => 'nullable|array',
        'extra_options' => 'nullable|array',
    ]);

    $category = new Category();
    $category->name = $request->name;
     if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/categories'), $imageName);
        $category->image = $imageName;
    }
    $category->slug = Str::slug($request->name);

    // Fix: Format extra fields as an array of objects
    $fields = [];

    if ($request->extra_fields && $request->extra_options) {
        foreach ($request->extra_fields as $index => $field) {
            $label = trim($field);
            $optionsRaw = $request->extra_options[$index] ?? '';
            $options = array_filter(array_map('trim', explode(',', $optionsRaw)));

            if ($label && count($options)) {
                $fields[] = [
                    'label' => ucfirst($label),
                    'options' => $options,
                ];
            }
        }
    }

    $category->extra_fields = json_encode($fields);
    $category->save();

    return redirect()->back()->with('success', 'Category added successfully.');
}
    /**
     * AJAX: Return extra fields and size guide for a category.
     */
    public function getFields($id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            'fields' => json_decode($category->extra_fields),
            'size_guide' => $category->size_guide,
        ]);
    }

    /**
     * Show all products for a category on the frontend.
     */
    public function categoryProducts($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('category_id', $category->id)
                           ->with('category')
                           ->orderBy('created_at', 'desc')
                           ->paginate(12);

        return view('frontend.product', compact('products', 'category'));
    }

public function edit($id)
{
    $category = Category::findOrFail($id);
    return view('admin.products.edit_category', compact('category'));
}

    public function update(Request $request, $id)
{
    $category = Category::findOrFail($id);
    $category->name = $request->name;

    // Image update logic
    if ($request->hasFile('image')) {

        // Delete old image if exists
        if ($category->image && file_exists(public_path('uploads/categories/' . $category->image))) {
            unlink(public_path('uploads/categories/' . $category->image));
        }

        // Upload new image
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/categories'), $imageName);
        $category->image = $imageName;
    }

    $category->save();

    return redirect()->route('admin.products.category')->with('success', 'Category Updated Successfully');
}

}



