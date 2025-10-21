@extends('frontend.layouts.main')

@section('main-container')
<!--
  Premium Homepage (Home - Sexy)
  - Hero banner
  - Category highlights
  - Featured products grid
  - Best Seller & Sale sliders
  - New Arrivals grid
  - Newsletter
-->

<style>
/* --- Premium theme basics --- */
:root{
  --accent: #D4A373; /* warm gold */
  --muted: #6b6b6b;
  --dark: #222;
}

.home-hero {
  position: relative;
  border-radius: 6px;
  overflow: hidden;
  margin-bottom: 40px;
}
.home-hero .overlay {
  position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,.18), rgba(0,0,0,.35));
  z-index: 1;
}
.home-hero .hero-inner {
  position: relative; z-index: 2; padding: 80px 30px;
  color: #fff;
}
.hero-title { font-size: 44px; font-weight:700; letter-spacing:0.4px; margin-bottom: 12px; }
.hero-sub { font-size: 16px; color: rgba(255,255,255,.9); margin-bottom: 22px; max-width:650px; }

.cat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 40px; }
.cat-card { display:flex; gap:12px; align-items:center; padding:18px; border-radius:8px; background:#fff; box-shadow:0 4px 18px rgba(25,25,25,.06); cursor:pointer; transition:transform .18s ease; text-decoration:none; color:inherit; }
.cat-card:hover { transform: translateY(-6px); }
.cat-thumb { width:82px; height:82px; border-radius:6px; object-fit:cover; flex-shrink:0; }

.section-title { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; }
.section-title h3 { margin:0; font-size:22px; color:var(--dark); }
.section-title a { color:var(--muted); font-size:14px; text-decoration:none; }

.products-grid { display:grid; grid-template-columns: repeat(4, 1fr); gap:18px; }
@media (max-width: 991px){ .cat-grid { grid-template-columns: repeat(2,1fr); } .products-grid { grid-template-columns: repeat(2,1fr);} .hero-title{font-size:32px} .home-hero .hero-inner{padding:50px 20px} }
@media (max-width: 575px){ .cat-grid, .products-grid { grid-template-columns: 1fr; } .hero-title{font-size:26px} }

/* Product card */
.product-card { background:#fff; border-radius:8px; padding:12px; box-shadow:0 8px 30px rgba(15,15,15,.04); position:relative; overflow:hidden; }
.product-thumb { width:100%; height:260px; object-fit:cover; border-radius:6px; transition: transform .25s ease; }
.product-card:hover .product-thumb { transform: scale(1.03); }
.badge-pos { position:absolute; top:12px; left:12px; z-index:5; padding:6px 8px; border-radius:4px; font-weight:600; font-size:12px; color:#fff; }
.badge-success{ background: #28a745; }
.badge-warning{ background: #ffc107; color:#222; }
.badge-danger{ background: #dc3545; }

/* card body */
.card-body { padding:10px 4px; display:flex; justify-content:space-between; align-items:flex-start; gap:8px; }
.card-body .left { flex:1; }
.card-body .price { font-weight:700; color:var(--dark); }
.card-actions { display:flex; gap:8px; align-items:center; }

/* wishlist icon */
.wish-btn { width:38px; height:38px; border-radius:6px; display:inline-flex; justify-content:center; align-items:center; background:rgba(0,0,0,.04); cursor:pointer; border:0; }
.text-red {
    color: red !important;
}

/* Slick arrows small */
.slick-prev:before, .slick-next:before { color: var(--dark); font-size:20px; }

/* Newsletter */
.newsletter { background:#f7f7f7; padding:36px; border-radius:8px; margin-top:36px; display:flex; gap:18px; align-items:center; justify-content:space-between; }
.newsletter .left h4{ margin:0 0 6px 0; }
.newsletter input.form-control { max-width:420px; }

/* tiny utilities */
.text-muted { color:var(--muted); font-size:13px; }

  .lux-title {
        font-family: 'Playfair Display', serif;
        font-weight: 600;
        font-size: 32px;
        letter-spacing: 1px;
        color: #333;
        text-align: center;
        margin-bottom: 5px;
        animation: fadeInDown 1s ease;
    }

    .lux-subtitle {
        text-align: center;
        color: #6b6b6b;
        font-size: 14px;
        margin-bottom: 30px;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 400;
        animation: fadeInUp 1s ease;
    }

    .lux-link {
        display: block;
        text-align: center;
        margin-top: 10px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #333;
        text-decoration: none;
        position: relative;
        font-weight: 500;
    }

    .lux-link:after {
        content: "";
        width: 0;
        height: 1px;
        background: #333;
        position: absolute;
        left: 50%;
        bottom: -3px;
        transition: 0.4s;
    }

    .lux-link:hover:after {
        width: 100%;
        left: 0;
    }

    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container ">

  <!-- HERO -->
  <div class="home-hero" style="background-image:url('{{ asset('frontend/images/bnr.jpg') }}'); background-size:cover; background-position:center; margin-top:50px;">
    <div class="overlay"></div>
    <div class="hero-inner">
      <div class="row align-items-center">
        <div class="col-lg-7">
          <div class="hero-copy">
            <div class="badge bg-transparent" style="background:rgba(255,255,255,.08); color:#fff; display:inline-block; padding:6px 10px; border-radius:6px; font-weight:600;">NEW SEASON</div>
            <h1 class="hero-title">Effortless Elegance — New Arrivals</h1>
            <p class="hero-sub">Explore our curated collection of summer-ready fabrics & ready-to-wear pieces. Premium fabrics, timeless silhouettes — now available.</p>

            <div style="display:flex; gap:12px; margin-top:16px;">
              <a href="{{ route('frontend.product') }}" class="btn" style="background:var(--dark); color:#fff; padding:12px 20px; border-radius:6px; font-weight:600;">Shop Collections</a>
              <a href="{{ route('frontend.product') }}?filter=sale" class="btn" style="background:transparent; color:#fff; border:2px solid rgba(255,255,255,.18); padding:10px 18px; border-radius:6px;">Shop Sale</a>
            </div>
          </div>
        </div>

        <div class="col-lg-5 text-end d-none d-lg-block">
          <!-- small promo cards -->
          <div style="display:flex; gap:12px; justify-content:flex-end;">
            <div style="width:160px; background:rgba(255,255,255,.06); padding:16px; border-radius:8px;">
              <div style="font-weight:700; font-size:20px;">Free Shipping</div>
              <div class="text-muted">On orders over Rs. 5,000</div>
            </div>
            <div style="width:160px; background:rgba(255,255,255,.06); padding:16px; border-radius:8px;">
              <div style="font-weight:700; font-size:20px;">Easy Returns</div>
              <div class="text-muted">14 day returns</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CATEGORIES -->
  <div class="section-title" style="margin-bottom:14px;">
      <h3>Shop by Category</h3>
      <a href="{{ route('frontend.product') }}">View all categories</a>
  </div>

  <div class="cat-grid">
    @forelse($categories as $cat)
      <a class="cat-card" href="{{ route('frontend.product', ['category' => $cat->id]) }}">
<img class="cat-thumb" src="{{ asset('uploads/categories/' . $cat->image) }}" alt="{{ $cat->name }}">
        <div>
          <div style="font-weight:700;">{{ $cat->name }}</div>
          <div class="text-muted" style="font-size:13px;">{{ Str::limit($cat->size_guide ?? 'Top picks', 70) }}</div>
        </div>
      </a>
    @empty
      <!-- fallback -->
      <div class="cat-card">
        <img class="cat-thumb" src="{{ asset('frontend/images/cat-placeholder.jpg') }}" alt="category">
        <div>
          <div style="font-weight:700;">Stitched</div>
          <div class="text-muted">Our best stitched collection</div>
        </div>
      </div>
      <div class="cat-card">
        <img class="cat-thumb" src="{{ asset('frontend/images/cat-placeholder.jpg') }}" alt="category">
        <div>
          <div style="font-weight:700;">Unstitched</div>
          <div class="text-muted">Premium fabrics</div>
        </div>
      </div>
      <div class="cat-card">
        <img class="cat-thumb" src="{{ asset('frontend/images/cat-placeholder.jpg') }}" alt="category">
        <div>
          <div style="font-weight:700;">Sale</div>
          <div class="text-muted">Grab the deals</div>
        </div>
      </div>
      <div class="cat-card">
        <img class="cat-thumb" src="{{ asset('frontend/images/cat-placeholder.jpg') }}" alt="category">
        <div>
          <div style="font-weight:700;">New Arrivals</div>
          <div class="text-muted">Fresh in store</div>
        </div>
      </div>
    @endforelse
  </div>

  <!-- FEATURED PRODUCTS -->
  <div class="section-title" style="margin-top:40px;">
    <h3>Featured for you</h3>
    <a href="{{ route('frontend.product') }}">See more</a>
  </div>

  <div class="products-grid">
    @foreach($featured as $product)
      <div class="product-card">
        @php
          $qty = $product->quantity ?? 0;
        @endphp

        @if($qty <= 0)
          <div class="badge-pos badge-danger">Out of Stock</div>
        @elseif($qty <= 5)
          <div class="badge-pos badge-warning">Low Stock</div>
        @endif

        <img class="product-thumb" src="{{ $product->image ? asset('storage/'.$product->image) : asset('frontend/images/product-placeholder.jpg') }}" alt="{{ $product->name }}">

        <div class="card-body">
          <div class="left">
            <div style="font-weight:700">{{ Str::limit($product->name, 40) }}</div>
            <div class="text-muted" style="font-size:13px;">{{ Str::limit($product->title ?? '', 50) }}</div>
            <div class="price" style="margin-top:6px;">Rs. {{ number_format($product->price, 2) }}</div>
          </div>

          <div class="card-actions">
           <form action="{{ route('frontend.add.to.cart.direct') }}" method="POST" id="addToCartForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1" id="formQuantity">
                <input type="hidden" name="size" value="" id="formSize">
                <input type="hidden" name="color" value="" id="formColor">

                @if(method_exists($product, 'isOutOfStock') && $product->isOutOfStock())
                    <button class="btn-cta" disabled>Out of Stock</button>
                @else
                    <button type="submit" class="btn btn-sm" style="background:var(--accent); color:#fff; border-radius:6px; font-weight:600;">Add to Cart</button>
                @endif
            </form>

   @php
$inWishlist = in_array($product->id, $userWishlist ?? []);
@endphp

<form action="{{ route('frontend.wishlist.toggle') }}" method="POST" style="display:inline;">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">

 <button type="submit" class="wish-btn" style="border:none; background:none;">
        <i class="fa fa-heart {{ $inWishlist ? 'text-red' : '' }}"></i>
    </button>

</form>








          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- SLIDERS: Best Sellers + Sale -->
  <div class="container" style="margin-top:70px;">

    <!-- BEST SELLERS -->
    <h2 class="lux-title">Best Sellers</h2>
    <p class="lux-subtitle">Most Loved by Our Customers</p>

    <div class="wrap-slick2">
        <div class="slick2">
            @foreach($bestSellers as $p)
                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ $p->image ? asset('storage/'.$p->image) : asset('frontend/images/product-placeholder.jpg') }}" alt="{{ $p->name }}">
                            <a href="{{ route('frontend.product-detail', $p->id) }}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">Quick View</a>
                        </div>
                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1">
                                <a href="{{ route('frontend.product-detail', $p->id) }}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $p->name }}
                                </a>
                                <span class="stext-105 cl3">Rs. {{ number_format($p->price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <a href="{{ route('frontend.product') }}" class="lux-link">View All Best Sellers</a>

    <hr style="margin: 60px auto; width: 60%;opacity:0.2;">

    <!-- SALE PICKS -->
    <h2 class="lux-title">Sale Highlights</h2>
    <p class="lux-subtitle">Limited Time Offers</p>

    <div class="wrap-slick2">
        <div class="slick2">
            @foreach($saleProducts as $p)
                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ $p->image ? asset('storage/'.$p->image) : asset('frontend/images/product-placeholder.jpg') }}" alt="{{ $p->name }}">
                            <a href="{{ route('frontend.product-detail', $p->id) }}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 ">Quick View</a>
                        </div>
                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1">
                                <a href="{{ route('frontend.product-detail', $p->id) }}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $p->name }}
                                </a>
                                <span class="stext-105 cl3">Rs. {{ number_format($p->price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <a href="{{ route('frontend.product') }}?filter=sale" class="lux-link">Shop Sale Collection</a>

</div>

  <!-- NEW ARRIVALS -->
  <section id="new-arr"></section>
  <div class="section-title" style="margin-top:40px;">
    <h3>New Arrivals</h3>
    <a href="{{ route('frontend.product') }}">Explore new</a>
  </div>

  <div class="products-grid" style="margin-bottom:20px;">
    @foreach($newArrivals as $n)
      <div class="product-card">
        @php $qty = $n->quantity ?? 0; @endphp
        @if($qty <= 0)
          <div class="badge-pos badge-danger">Out of Stock</div>
        @elseif($qty <= 5)
          <div class="badge-pos badge-warning">Low Stock</div>
        @endif
        <img class="product-thumb" src="{{ $n->image ? asset('storage/'.$n->image) : asset('frontend/images/product-placeholder.jpg') }}" alt="{{ $n->name }}">
        <div class="card-body">
          <div class="left">
            <div style="font-weight:700">{{ Str::limit($n->name, 40) }}</div>
            <div class="text-muted" style="font-size:13px;">{{ Str::limit($n->title ?? '', 50) }}</div>
            <div class="price" style="margin-top:6px;">Rs. {{ number_format($n->price, 2) }}</div>
          </div>
          <div class="card-actions">
            <form action="{{ route('frontend.add.to.cart.direct') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $n->id }}">
    <input type="hidden" name="quantity" value="1">
    <input type="hidden" name="size" value="">
    <input type="hidden" name="color" value="">

    @if($n->quantity <= 0)
        <button class="btn-cta" disabled>Out of Stock</button>
    @else
        <button type="submit" class="btn btn-sm" style="background:var(--accent); color:#fff; border-radius:6px; font-weight:600;">Add to Cart</button>
    @endif
</form>

@php
$inWishlist = in_array($n->id, $userWishlist ?? []);
@endphp

<form action="{{ route('frontend.wishlist.toggle') }}" method="POST" style="display:inline;">
    @csrf
    <input type="hidden" name="product_id" value="{{ $n->id }}">
 <button type="submit" class="wish-btn" style="border:none; background:none;">
        <i class="fa fa-heart {{ $inWishlist ? 'text-red' : '' }}"></i>
    </button>
</form>






          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- NEWSLETTER -->
  <div class="newsletter">
    <div class="left">
      <h4>Join our Newsletter</h4>
      <p class="text-muted">Be the first to know about new arrivals and exclusive offers.</p>
    </div>
    <form action="" method="POST" class="d-flex">
      @csrf
      <input type="email" name="email" class="form-control" placeholder="Your email address" required>
      <button class="btn" style="background:var(--dark); color:#fff; margin-left:10px;">Subscribe</button>
    </form>
  </div>

</div> <!-- container -->

<!-- SCRIPTS: ensure slick/js and dependencies are included in your layout -->
<link rel="stylesheet" href="{{ asset('frontend/vendor/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/vendor/slick/slick-theme.css') }}">
<script src="{{ asset('frontend/vendor/slick/slick.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // init slick sliders
  document.querySelectorAll('.slick2').forEach(function(el){
    $(el).not('.slick-initialized').slick({
      slidesToShow: 2,
      slidesToScroll: 1,
      infinite: true,
      arrows: true,
      dots: false,
      responsive: [
        { breakpoint: 992, settings: { slidesToShow: 2 } },
        { breakpoint: 576, settings: { slidesToShow: 1 } }
      ]
    });
  });

  // Tiny wishlist UI

});

</script>


@endsection
