@extends('frontend.layouts.main')

@section('main-container')
<style>
/* ---------- Page / Layout ---------- */
body { overflow-x: hidden !important; }


/* Category bar */
.category-bar {
    display:flex; overflow-x:auto; white-space:nowrap; border-bottom:1px solid #ddd;
    align-items: center; justify-content: center;
     padding:10px 0; gap:10px; scrollbar-width:none; max-width:100%;
}
.category-bar::-webkit-scrollbar { display:none; }
.category-link { flex:0 0 auto; padding:10px 15px; font-size:13px; text-transform:uppercase; color:#000; text-decoration:none; }
.category-link:hover { border-bottom:2px solid #000; }
.active-category { color:#e60023; border-bottom:2px solid #e60023; }

/* ---------- Product Card (matches index style) ---------- */
.products-grid {
    display:grid;
    grid-template-columns: repeat(4, 1fr);
    gap:18px;
    margin: 24px 0;
}
@media (max-width: 991px){ .products-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 576px){ .products-grid { grid-template-columns: 1fr; } }

.product-card {
    background:#fff;
    border-radius:10px;
    padding:12px;
    box-shadow:0 8px 30px rgba(15,15,15,.04);
    position:relative;
    overflow:hidden;
    transition:transform .25s ease, box-shadow .25s ease;
    display:flex;
    flex-direction:column;
}
.product-card:hover { transform:translateY(-6px); box-shadow:0 18px 45px rgba(15,15,15,.08); }

.product-thumb {
    width:100%;
    height:320px;
    object-fit:cover;
    border-radius:8px;
    display:block;
    transition:transform .35s ease;
}
.product-card:hover .product-thumb { transform:scale(1.03); }

.badge-pos { position:absolute; top:14px; left:14px; z-index:5; padding:6px 8px; border-radius:6px; font-weight:600; font-size:12px; color:#fff; }
.badge-success{ background:#28a745; }
.badge-warning{ background:#ffc107; color:#222; }
.badge-danger{ background:#dc3545; }

.card-body { padding:10px 6px; display:flex; justify-content:space-between; align-items:flex-start; gap:8px; }
.card-body .left { flex:1; }
.card-body .name { font-weight:700; color:#222; font-size:15px; margin-bottom:6px; }
.card-body .meta { color:#6b6b6b; font-size:13px; }
.card-body .price { font-weight:800; color:#111; margin-top:6px; }

/* Hover overlay (View Details) */
.card-overlay {
    position:absolute;
    inset:0;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(180deg, rgba(0,0,0,0.0), rgba(0,0,0,0.45));
    opacity:0;
    transition:opacity .25s ease;
    pointer-events:none;
}
.product-card:hover .card-overlay { opacity:1; pointer-events:auto; }
.view-details {
    background: rgba(255,255,255,0.95);
    color:#111;
    padding:10px 18px;
    border-radius:30px;
    font-weight:700;
    text-decoration:none;
    letter-spacing: .6px;
    box-shadow:0 6px 18px rgba(0,0,0,.12);
    transition: transform .12s ease;
}
.view-details:hover { transform:translateY(-4px); }

/* Utility */
.text-muted { color:#6b6b6b; font-size:13px; }
.empty-msg { font-size:1.15rem; color:#6b6b6b; padding:80px 0; text-align:center; }


.filter-wrapper {
    margin-top: 20px;
}

.filter-box {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
}

.filter-box .form-label {
    font-size: 14px;
}

.filter-box .form-select,
.filter-box .form-control {
    border-radius: 8px;
}

.filter-box .btn {
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 14px;
}

@media(max-width: 768px) {
    .filter-box {
        padding: 15px;
    }
}
.empty-state {
    background: #fff;
    border-radius: 12px;
    padding: 40px;
    border: 1px solid #eee;
}

.empty-state h4 {
    font-weight: 600;
    color: #333;
}

.empty-state p {
    color: #777;
    font-size: 14px;
}
.no-products-section {
    min-height: 60vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 40px 20px;
}

.no-products-image {
    max-width: 350px;
    width: 100%;
    height: auto;
    margin-bottom: 20px;
    object-fit: contain;
}

.empty-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #333;
}

.empty-subtitle {
    font-size: 16px;
    color: #777;
}

</style>

{{-- CATEGORY BAR --}}
{{-- <div class="category-bar">
    @foreach (\App\Models\Category::all() as $category)
        @if($category->slug)
            <a href="{{ route('frontend.category.products', ['slug' => $category->slug]) }}"
               class="category-link {{ request()->route('slug') == $category->slug ? 'active-category' : '' }}">
                {{ $category->name }}
            </a>
        @endif
    @endforeach
</div> --}}

{{-- PRODUCTS GRID --}}
@if(!empty($products) && $products->count() > 0)
<div class="container">
    <d<div class="filter-wrapper container mb-4">
    <form id="filterForm" method="GET" action="" class="filter-box shadow-sm">

        <div class="row align-items-end gy-3">

            <!-- Category -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Category</label>
                <select name="category" class="form-select">
                    <option value="">All</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Price -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Price Range</label>
                <div class="d-flex gap-2">
                    <input type="number" name="min_price" class="form-control" placeholder="Min"
                        value="{{ request('min_price') }}">
                    <input type="number" name="max_price" class="form-control" placeholder="Max"
                        value="{{ request('max_price') }}">
                </div>
            </div>

            <!-- Sort -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Sort By</label>
                <select name="sort" class="form-select">
                    <option value="">Default</option>
                    <option value="latest" {{ request('sort')=='latest' ? 'selected' : '' }}>Latest</option>
                    <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-dark flex-fill">
                    <i class="fa fa-filter"></i> Apply
                </button>

                @if(request()->hasAny(['category','min_price','max_price','sort']))
                <a href="{{ url()->current() }}" class="btn btn-outline-secondary flex-fill">
                    <i class="fa fa-times"></i> Clear
                </a>
                @endif
            </div>

        </div>
    </form>
</div>


    <div class="products-grid">
        @foreach($products as $product)
            @php $fields = is_string($product->custom_fields) ? json_decode($product->custom_fields, true) : (array)$product->custom_fields; @endphp

            <div>
                <div class="product-card">
                    {{-- Badges --}}
                    @php $qty = $product->quantity ?? 0; @endphp
                    @if($qty <= 0)
                        <div class="badge-pos badge-danger">Out of Stock</div>
                    @elseif($qty <= 5)
                        <div class="badge-pos badge-warning">Low Stock</div>
                    @endif

                    {{-- Image (click -> detail) --}}
                    <a href="{{ route('frontend.product-detail', ['id' => $product->id]) }}" class="d-block" style="text-decoration:none;">
                        <img class="product-thumb" src="{{ $product->image ? asset('storage/'.$product->image) : asset('frontend/images/product-placeholder.jpg') }}" alt="{{ $product->name }}">
                    </a>

                    {{-- Hover overlay shows View Details --}}
                    <div class="card-overlay">
                        <a href="{{ route('frontend.product-detail', ['id' => $product->id]) }}" class="view-details">View Details</a>
                    </div>

                    {{-- Card body --}}
                    <div class="card-body">
                        <div class="left">
                            <div class="name">{{ \Illuminate\Support\Str::limit($product->name, 60) }}</div>
                            <div class="meta">{{ \Illuminate\Support\Str::limit($product->title ?? '', 60) }}</div>
                            <div class="price">Rs. {{ number_format($product->price, 2) }}</div>
                        </div>

                        {{-- small action icons: wishlist icon (optional) --}}
                        <div style="display:flex; flex-direction:column; gap:8px; align-items:flex-end;">
                            <button class="wish-btn" title="Wishlist" style="background:transparent; border:0; cursor:pointer;">
                                <i class="fa fa-heart" style="color:#6b6b6b;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    </div>

    {{-- pagination if using --}}
    <div class="mt-4 d-flex justify-content-center">
        @if(method_exists($products, 'links')) {{ $products->links() }} @endif
    </div>
</div>
@else

    <div class="no-products-section">
        <img src="{{ asset('frontend/images/404.png') }}" alt="Not Found" class="no-products-image">
        <h2 class="empty-title">Oops! Nothing matches your search</h2>
        <p class="empty-subtitle">We couldn’t find what you’re looking for. Try exploring other categories!</p>
         <a href="{{ url()->current() }}" class="btn btn-outline-dark mt-3">Clear Filters</a>
    </div>

@endif


{{-- QUICK VIEW MODAL (unchanged, still used by quick-view buttons if present) --}}
<div class="wrap-modal1 js-modal1 p-t-60 p-b-20" style="display:none;">
    <div class="overlay-modal1 js-hide-modal1"></div>
    <div class="container">
        <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
            <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                <img src="{{ asset('frontend/images/icons/icon-close.png') }}" alt="CLOSE">
            </button>
            <div class="row">
                <!-- LEFT: Image -->
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-pic-w pos-relative">
                            <img src="" alt="Product Image" class="js-modal-image" style="width:100%; border-radius:6px;">
                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="" target="_blank" id="modalImageLink">
                                <i class="fa fa-expand"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Details + Add to Cart -->
                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">Product Name</h4>
                        <span class="mtext-106 cl2 js-modal-price">Rs. 0.00</span>
                        <p class="stext-102 cl3 p-t-23 js-description">Product description goes here.</p>

                        <!-- Sizes -->
                        <div class="p-t-33">
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">Size</div>
                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select class="js-size-select js-select2" name="size"></select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Colors -->
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">Color</div>
                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select class="js-color-select js-select2" name="color"></select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quantity + Add Button -->
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">
                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>
                                        <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1">
                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>

                                    <button class="js-addcart-detail btn btn-dark"
                                        id="quick-view-add-to-cart"
                                        data-id=""
                                        data-name=""
                                        data-price=""
                                        data-image=""
                                        data-fields="{}">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Social Icons -->
                        <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                            <div class="flex-m bor9 p-r-10 m-r-11">
                                <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 tooltip100" data-tooltip="Wishlist">
                                    <i class="zmdi zmdi-favorite"></i>
                                </a>
                            </div>
                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CSRF Token --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- JS: modal + quick add to cart + optional wishlist toggle --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // If quick-view triggers exist elsewhere, keep previous logic.
    const modalWrapper = document.querySelector('.wrap-modal1');
    const overlayClose = document.querySelectorAll('.js-hide-modal1');

    function openModal(data) {
        if(!modalWrapper) return;
        modalWrapper.style.display = 'block';
        modalWrapper.classList.add('active');

        // fill
        modalWrapper.querySelector('.js-modal-image').src = data.image || '';
        modalWrapper.querySelector('#modalImageLink').href = data.image || '';
        modalWrapper.querySelector('.js-name-detail').textContent = data.name || '';
        modalWrapper.querySelector('.js-modal-price').textContent = data.price ? `Rs. ${data.price}` : '';
        modalWrapper.querySelector('.js-description').textContent = data.description || '';

        // sizes/colors
        const sizes = data.size ? data.size.split(',') : [];
        const colors = data.color ? data.color.split(',') : [];

        const sizeSelect = modalWrapper.querySelector('.js-size-select');
        const colorSelect = modalWrapper.querySelector('.js-color-select');
        if(sizeSelect){ sizeSelect.innerHTML = ''; sizes.forEach(s => { let o = document.createElement('option'); o.value=s; o.textContent=s; sizeSelect.appendChild(o); }); }
        if(colorSelect){ colorSelect.innerHTML = ''; colors.forEach(c => { let o = document.createElement('option'); o.value=c; o.textContent=c; colorSelect.appendChild(o); }); }

        // set add-to-cart dataset
        const addBtn = modalWrapper.querySelector('#quick-view-add-to-cart');
        if(addBtn){
            addBtn.dataset.id = data.id || '';
            addBtn.dataset.name = data.name || '';
            addBtn.dataset.price = data.price || '';
            addBtn.dataset.image = data.image || '';
        }
    }

    // bind quick-view trigger (if you still use buttons with class js-show-modal1)
    document.querySelectorAll('.js-show-modal1').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            openModal({
                id: this.dataset.id,
                name: this.dataset.name,
                price: this.dataset.price,
                image: this.dataset.image,
                description: this.dataset.description,
                size: this.dataset.size,
                color: this.dataset.color
            });
        });
    });

    // hide modal
    overlayClose.forEach(btn => btn.addEventListener('click', function () {
        if(modalWrapper){ modalWrapper.style.display = 'none'; modalWrapper.classList.remove('active'); }
    }));
    if(modalWrapper){
        modalWrapper.addEventListener('click', function (e) {
            if(e.target.classList.contains('wrap-modal1') || e.target.classList.contains('overlay-modal1')){
                modalWrapper.style.display = 'none';
                modalWrapper.classList.remove('active');
            }
        });
    }

    // Add to cart from modal (keeps your existing ajax behavior)
    const addToCart = document.getElementById('quick-view-add-to-cart');
    if(addToCart){
        addToCart.addEventListener('click', function () {
            const qty = modalWrapper.querySelector('.num-product') ? modalWrapper.querySelector('.num-product').value : 1;
            const product = {
                id: this.dataset.id,
                name: this.dataset.name,
                price: this.dataset.price,
                image: this.dataset.image,
                quantity: qty,
                custom_fields: {
                    Size: modalWrapper.querySelector('.js-size-select') ? modalWrapper.querySelector('.js-size-select').value : '',
                    Color: modalWrapper.querySelector('.js-color-select') ? modalWrapper.querySelector('.js-color-select').value : ''
                },
                _token: document.querySelector('meta[name="csrf-token"]').content
            };

            fetch('/add-to-cart', {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN': product._token},
                body: JSON.stringify(product)
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    // you can replace with a nice toast instead of alert
                    alert('Item added to cart!');
                    // update sidebar/cart count via your endpoint if you have one
                }
            });
        });
    }

    // wishlist toggle (simple UI only)
    document.querySelectorAll('.wish-btn').forEach(b => {
        b.addEventListener('click', function (e) {
            e.preventDefault();
            this.classList.toggle('active');
            this.querySelector('i').style.color = this.classList.contains('active') ? '#e60023' : '#6b6b6b';
        });
    });
});


</script>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const category = document.getElementById('categoryFilter');
    const minPrice = document.getElementById('minPrice');
    const maxPrice = document.getElementById('maxPrice');
    const sortBy = document.getElementById('sortBy');
    const container = document.getElementById('productsContainer');

    function fetchProducts(){
        const params = {
            category: category.value,
            min_price: minPrice.value,
            max_price: maxPrice.value,
            sort_by: sortBy.value,
        };
        const queryString = new URLSearchParams(params).toString();

        fetch(`/products/filter?${queryString}`, {headers:{'X-Requested-With':'XMLHttpRequest'}})
            .then(res => res.text())
            .then(html => container.innerHTML = html);
    }

    [category, minPrice, maxPrice, sortBy].forEach(el => {
        el.addEventListener('change', fetchProducts);
    });
});
</script>

@endsection
