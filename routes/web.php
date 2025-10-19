<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\MainController;
use App\Http\Controllers\Frontend\AdminController;
use App\Http\Controllers\Frontend\ProductDetailController;
use App\Http\Controllers\Frontend\ShopingCartController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\AdminAuth\RegisteredUserController;
use App\Http\Controllers\AdminAuth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\UserDashboardController;





/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('index');

Route::get('/about', [MainController::class, 'about']);
Route::get('/contact', [MainController::class, 'contact']);
Route::get('/product', [MainController::class, 'product'])->name('frontend.product');
Route::get('/product-detail', [MainController::class, 'productdetail']);

// Product detail + category products
Route::get('/category/{slug}', [FrontendProductController::class, 'categoryProducts'])->name('frontend.category.products');
Route::get('/product/{id}', [FrontendProductController::class, 'show'])->name('frontend.product-detail');
// Fetch filtered products
Route::get('/products/filter', [FrontendProductController::class, 'filter'])->name('products.filter');

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrdersController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}', [OrdersController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [OrdersController::class, 'updateStatus'])->name('orders.updateStatus');
});

/*
|--------------------------------------------------------------------------
| SHOPPING CART ROUTES
|--------------------------------------------------------------------------
*/

// Add to cart via product detail
Route::post('/add-to-cart-direct', [ShopingCartController::class, 'addToCartAndRedirect'])->name('frontend.add.to.cart.direct');

// Add to cart via AJAX/quick view
Route::post('/add-to-cart', [ShopingCartController::class, 'addToCart']);

// Cart sidebar load
Route::get('/cart-sidebar', [ShopingCartController::class, 'cartSidebar']);

// View cart page
Route::get('/shopping-cart', [ShopingCartController::class, 'viewCart'])->name('frontend.shopping.cart');

// Remove item from cart
Route::get('/cart/remove/{id}', [ShopingCartController::class, 'remove'])->name('frontend.cart.remove');


 Route::get('/wishlist', [WishlistController::class,'index'])->name('user.wishlist');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('frontend.wishlist.toggle');
    Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('frontend.wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('frontend.wishlist.remove');


/*
|--------------------------------------------------------------------------
| PRODUCT REVIEWS
|--------------------------------------------------------------------------
*/

Route::post('/review/store', [ProductDetailController::class, 'storeReview'])->name('frontend.review.store');

// Admin review management
Route::get('/admin/customers/reviews', [AdminProductController::class, 'reviews'])->name('admin.customers.reviews');

Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/checkout/verify-otp', [CheckoutController::class, 'verifyOtp'])->name('checkout.verifyOtp');



/*
|--------------------------------------------------------------------------
| USER AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
     Route::get('/my-orders', [OrdersController::class, 'userOrders'])->name('user.orders');
    Route::get('/my-orders/{order_number}', [OrdersController::class, 'userOrderShow'])->name('user.orders.show');
});

/*
|--------------------------------------------------------------------------
| ADMIN AUTH ROUTES (LOGIN, REGISTER)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/adminauth.php';

Route::get('/admin/register', [RegisteredUserController::class, 'create'])->name('admin.register');
Route::post('/admin/register', [RegisteredUserController::class, 'store']);

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Protected)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'verified'])->group(function () {


Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
Route::get('/customers', [CustomersController::class, 'index'])->name('admin.customers.index');

// Show orders of a single customer
Route::get('customers/{id}', [CustomersController::class, 'show'])->name('customers.show');


    /*
    |--------------------------------------------------------------------------
    | PRODUCTS
    |--------------------------------------------------------------------------
    */
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [AdminProductController::class, 'update'])->name('products.update');

    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [AdminProductController::class, 'store'])->name('products.store');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('/products/{product}/toggle', [AdminProductController::class, 'toggleStatus'])->name('products.toggle');

    Route::get('/stock-history', [AdminProductController::class, 'allStockHistory'])->name('stock.history');


    // Dynamic category fields for product form (AJAX)
    Route::get('/category-fields/{id}', [AdminProductController::class, 'getCategoryFields'])->name('category.fields');

    /*
    |--------------------------------------------------------------------------
    | CATEGORIES
    |--------------------------------------------------------------------------
    */
    Route::get('/products/category', [CategoryController::class, 'index'])->name('products.category');
    Route::get('/products/add-category', [CategoryController::class, 'create'])->name('products.add_category');
    Route::post('/products/add-category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/products/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::delete('/products/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::put('/admin/category/{id}', [CategoryController::class, 'update'])->name('category.update');

    /*
    |--------------------------------------------------------------------------
    | BRANDS
    |--------------------------------------------------------------------------
    */
    Route::get('/products/brands', [AdminController::class, 'brand'])->name('products.brands');
    Route::get('/products/add-brand', [AdminController::class, 'add_brand'])->name('products.add_brand');

    /*
    |--------------------------------------------------------------------------
    | ORDERS
    |--------------------------------------------------------------------------
    */
    Route::get('/orders/index', [AdminController::class, 'order'])->name('orders.index');
    Route::get('/orders/pending', [AdminController::class, 'pending'])->name('orders.pending');
    Route::get('/orders/completed', [AdminController::class, 'completed'])->name('orders.completed');

     Route::get('orders', [OrdersController::class, 'adminIndex'])->name('orders.index');
    Route::get('orders/{id}', [OrdersController::class, 'adminShow'])->name('orders.show');
    Route::post('orders/{id}/status', [OrdersController::class, 'adminUpdateStatus'])->name('orders.updateStatus');
    Route::delete('orders/{id}', [OrdersController::class, 'adminDestroy'])->name('orders.destroy');

    /*
    |--------------------------------------------------------------------------
    | CUSTOMERS
    |--------------------------------------------------------------------------
    */
    Route::get('/customers/reviews', [AdminProductController::class, 'customerReview'])->name('customers.reviews');
    Route::put('/reviews/{id}', [AdminProductController::class, 'updateReview'])->name('reviews.update');

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
