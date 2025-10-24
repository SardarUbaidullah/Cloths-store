@extends('frontend.layouts.main')

@section('title', 'Search results for: ' . ($q ?: 'All products'))

@section('main-container')
<link rel="stylesheet" href="{{ asset('frontend/css/search-page.css') }}">
<style>
    /* --- Suggestion Cards Premium with Floating Eye --- */
.suggestion-card {
  border-radius: 12px;
  overflow: hidden;
  position: relative;
  transition: transform .18s ease, box-shadow .18s ease;
  background: #fff;
  box-shadow: 0 6px 18px rgba(18,24,38,0.04);
  display: flex;
  flex-direction: column;
  height: 100%;
}

.suggestion-card .suggest-thumb {
  height: 180px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fafafa;
  position: relative;
  overflow: hidden;
}

.suggestion-card .suggest-thumb img {
  max-height: 100%;
  width: auto;
  object-fit: contain;
  transition: transform .25s ease;
}

.suggestion-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 18px 60px rgba(2,6,23,0.06);
}

.suggestion-card:hover .suggest-thumb img {
  transform: scale(1.05);
}

/* Floating Eye Overlay */
.suggestion-card .overlay-eye {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.35);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: all 0.3s ease;
  border-radius: 12px;
}

.suggestion-card:hover .overlay-eye {
  opacity: 1;
  transform: translateY(-5px);
}

.overlay-eye i {
  color: #fff;
  font-size: 26px;
  transition: all 0.3s ease;
  transform: scale(0.8);
}

.suggestion-card:hover .overlay-eye i {
  transform: scale(1.1) translateY(-3px);
}
/* Modern Premium Product Card */
.product-card-modern {
  border-radius: 14px;
  overflow: hidden;
  background: #fff;
  border: 1px solid #efefef;
  transition: .25s ease;
}

.product-card-modern:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

/* Image: fixed height & perfect center crop */
.product-card-modern .pcm-img {
  height: 250px;
  background: #f7f7f7;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 8px;
}

.product-card-modern .pcm-img img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

/* Text Style */
.pcm-body {
  padding: 10px 12px 14px;
}

.pcm-title {
  font-size: 14px;
  font-weight: 600;
  color: #111;
  min-height: 38px;
  line-height: 1.25;
}

.pcm-price {
  color: #0e0e0e;
  font-weight: 700;
  font-size: 15px;
}

.pcm-cat {
  font-size: 12px;
  color: #666;
}

</style>
<div class="search-page container py-5">
  <div class="row g-4">

    <!-- FILTERS (LEFT) -->
    <aside class="col-lg-3">
      <div class="card filter-card mb-4">
        <div class="card-body">
          <h5 class="mb-3" style="color:#222;">Filters</h5>

          <form id="searchFilters" action="{{ route('product.search') }}" method="GET" class="d-grid gap-2">
            <input type="hidden" name="query" value="{{ $q }}">
            <input type="hidden" name="category_id" id="filter_category_id" value="{{ $categoryId }}">
            <input type="hidden" name="price_min" id="filter_price_min" value="{{ $priceMin }}">
            <input type="hidden" name="price_max" id="filter_price_max" value="{{ $priceMax }}">
            <input type="hidden" name="sort" id="filter_sort" value="{{ $sort }}">

            <div class="mb-3">
              <label class="form-label small fw-bold" style="color:#222;">Category</label>
              <select id="filterCategory" class="form-select" name="category_id">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" {{ (string)$cat->id === (string)$categoryId ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-bold" style="color:#222;">Price Range (PKR)</label>
              <div class="d-flex gap-2">
                <input type="number" name="price_min_input" id="priceMinInput" class="form-control" placeholder="Min" value="{{ $priceMin }}">
                <input type="number" name="price_max_input" id="priceMaxInput" class="form-control" placeholder="Max" value="{{ $priceMax }}">
              </div>
              <div class="mt-2">
                <button type="button" id="applyPriceBtn" class="btn btn-outline-dark w-100">Apply</button>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-bold" style="color:#222;">Sort by</label>
              <select id="filterSort" class="form-select" name="sort">
                <option value="relevance" {{ $sort === 'relevance' ? 'selected' : '' }}>Relevance</option>
                <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
              </select>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-dark w-100">Apply Filters</button>
              <a href="{{ route('product.search') }}?query={{ urlencode($q) }}" class="btn btn-outline-dark w-100">Reset</a>
            </div>
          </form>
        </div>
      </div>

      <!-- Trending / Popular small widget -->
      <div class="card small-card mb-4">
        <div class="card-body">
          <h6 class="mb-2" style="color:#222;">Trending</h6>
          <ul class="list-unstyled small mb-0">
            @foreach(\App\Models\Product::where('is_active',1)->inRandomOrder()->take(5)->get() as $t)
              <li class="mb-2"><a href="{{ url('/product/'.$t->id) }}" class="text-decoration-none" style="color:#222;">{{ Str::limit($t->name, 45) }}</a></li>
            @endforeach
          </ul>
        </div>
      </div>

    </aside>

    <!-- PRODUCTS GRID (RIGHT) -->
    <section class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h5 class="mb-0" style="color:#222;">Search results for: <strong>{{ $q ?: 'All Products' }}</strong></h5>
          <small class="text-muted">{{ $products->total() }} results</small>
        </div>
        <div>
          <form id="searchTopForm" action="{{ route('product.search') }}" method="GET" class="d-flex gap-2">
            <input type="hidden" name="category_id" value="{{ $categoryId }}">
            <input type="text" name="query" value="{{ $q }}" class="form-control form-control-sm" placeholder="Refine search..." style="color:#222;">
            <button class="btn btn-dark btn-sm">Search</button>
          </form>
        </div>
      </div>

    @if($products->count() > 0)
<div class="row g-4">
    @foreach($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ url('/product/'.$product->id) }}" class="product-card-modern d-block text-decoration-none">

                <div class="pcm-img">
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                </div>

                <div class="pcm-body">
                    <h6 class="pcm-title">{{ Str::limit($product->name, 50) }}</h6>

                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="pcm-price">PKR {{ number_format($product->price) }}</span>
                        <span class="pcm-cat">{{ $product->category->name ?? '' }}</span>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

        <div class="mt-4">
          {{ $products->links('vendor.pagination.bootstrap-5') }}
        </div>

      @else
        <!-- NO RESULTS - Premium UI -->
            <div class="empty-cart text-center" style="padding:60px 20px;">
                            <img src="{{ asset('frontend/images/no-product-2.png') }}" alt="Empty Cart" style="max-width:220px; display:block; margin:auto; filter:drop-shadow(0 5px 15px rgba(0,0,0,0.2));">
                          <h3 style="margin-top:20px; font-weight:600;">No Results Found</h3>
<p style="color:#555;">Can’t find what you're looking for? Don’t worry — we’ve handpicked some items you might love below</p>
<a href="{{url('/shop')}}" class="btn btn-dark mt-2">Go To Shop</a>

                        </div>
         @if($suggestions->count())
  <div class="row justify-content-center">
    @foreach($suggestions as $item)
      <div class="col-6 col-md-3 mb-3">
        <div class="card suggestion-card text-center h-100">
          <a href="{{ url('/product/'.$item->id) }}" class="text-decoration-none">
            <div class="suggest-thumb p-3">
              <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" class="img-fluid">
  <div class="overlay-eye"><i class="fa fa-eye"></i></div>
            </div>
            <div class="card-body">
              <h6 class="mb-1" style="color:#222;">{{ Str::limit($item->name, 40) }}</h6>
              <div class="price fw-bold" style="color:#222;">PKR {{ number_format($item->price) }}</div>
            </div>
          </a>
        </div>
      </div>
    @endforeach
  </div>
@endif

        </div>
      @endif

    </section>
  </div>
</div>

<script>
(function(){
  document.getElementById('applyPriceBtn').addEventListener('click', function(e){
    const min = document.getElementById('priceMinInput').value;
    const max = document.getElementById('priceMaxInput').value;
    const form = document.getElementById('searchFilters');
    document.getElementById('filter_price_min').value = min;
    document.getElementById('filter_price_max').value = max;
    form.submit();
  });

  document.getElementById('filterCategory').addEventListener('change', function(){
    document.getElementById('searchFilters').submit();
  });

  document.querySelectorAll('#searchTopForm input[type=text]').forEach(function(inp){
    inp.addEventListener('keypress', function(e){
      if (e.key === 'Enter') e.target.form.submit();
    });
  });
})();
</script>
@endsection
