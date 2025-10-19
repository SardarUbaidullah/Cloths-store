@extends('frontend.layouts.main')
@section('main-container')

@php
    // Support both JSON string or array/object from model
    $fields = [];
    if (isset($product->custom_fields)) {
        if (is_string($product->custom_fields)) {
            $fields = json_decode($product->custom_fields, true) ?: [];
        } elseif (is_array($product->custom_fields) || is_object($product->custom_fields)) {
            $fields = (array) $product->custom_fields;
        }
    }
@endphp

<style>
/* ---------- Page baseline ---------- */
:root{
    --muted:#6b6b6b;
    --accent:#111;
    --soft:#f6f6f6;
    --cta:#111; /* dark elegant CTA, will glow on hover */
    --glass: rgba(255,255,255,0.85);
}
body{overflow-x:hidden;}
.container { max-width:1180px; margin:0 auto; }

/* Breadcrumb */
.breadcrumb-wrap { margin-top:120px; padding:0 12px; }
.bread-crumb a { color:var(--muted); text-decoration:none; margin-right:8px; }
.bread-crumb span { color:#333; font-weight:600; }

/* Layout */
.product-hero { display:grid; grid-template-columns: 1fr 420px; gap:30px; align-items:start; margin:28px 12px; }
@media (max-width: 991px){ .product-hero { grid-template-columns: 1fr; } }

/* Image Gallery */
.gallery {
    background:var(--glass);
    border-radius:12px;
    padding:18px;
    box-shadow:0 10px 30px rgba(10,10,10,0.06);
    position:relative;
}
.main-image {
    width:100%;
    height:560px;
    border-radius:10px;
    overflow:hidden;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#fff;
}
.main-image img { width:100%; height:100%; object-fit:cover; transition: transform .45s ease; }
.main-image:hover img { transform:scale(1.06); }

.thumbs { display:flex; gap:10px; margin-top:12px; overflow-x:auto; padding-bottom:6px; }
.thumb {
    width:86px; height:86px; border-radius:8px; overflow:hidden; flex:0 0 auto;
    border:2px solid transparent; cursor:pointer; transition:border-color .18s ease, transform .12s;
}
.thumb img { width:100%; height:100%; object-fit:cover; display:block; }
.thumb.active { border-color:#111; transform:translateY(-4px); }

/* Info panel */
.info {
    background:#fff;
    border-radius:12px;
    padding:20px;
    box-shadow:0 10px 30px rgba(10,10,10,0.06);
    position:sticky;
    top:120px;
    height:fit-content;
}
.title { font-size:22px; font-weight:700; color:var(--accent); margin-bottom:6px; }
.subtitle { color:var(--muted); margin-bottom:14px; font-size:14px; }

/* Badges */
.badges { display:flex; gap:8px; margin-bottom:12px; }
.badge { padding:6px 8px; border-radius:6px; font-weight:700; font-size:12px; color:#fff; }
.badge.out { background:#dc3545; }
.badge.low { background:#ffc107; color:#222; }

/* Price & meta */
.price { font-size:20px; font-weight:900; margin-top:6px; color:#111; }
.meta { color:var(--muted); font-size:14px; margin-top:6px; }

/* Selectors & quantity */
.select-row { display:flex; gap:12px; margin-top:18px; align-items:center; flex-wrap:wrap; }
.select-group { min-width:140px; }
.select-group label { display:block; font-size:13px; color:var(--muted); margin-bottom:6px; font-weight:600; }
select.form-select, .form-input { width:100%; padding:10px 12px; border-radius:8px; border:1px solid #e7e7e7; font-size:14px; }

/* quantity */
.qty-wrap { display:flex; align-items:center; gap:8px; }
.qty-btn { background:#fff; border:1px solid #ddd; padding:8px 10px; border-radius:8px; cursor:pointer; }
.num-product { width:72px; text-align:center; padding:8px 10px; border-radius:8px; border:1px solid #e7e7e7; }

/* CTA */
.cta-row { margin-top:18px; display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
.btn-cta {
    background:var(--cta); color:#fff; padding:12px 18px; border-radius:999px; font-weight:800; letter-spacing:.4px;
    border:none; cursor:pointer; box-shadow:0 10px 30px rgba(17,17,17,0.12);
    transition: transform .12s ease, box-shadow .12s ease;
}
.btn-cta:hover { transform:translateY(-4px); box-shadow:0 18px 45px rgba(17,17,17,0.16); }

/* wishlist / share icons */
.icon-row { display:flex; gap:8px; align-items:center; margin-left:6px; }
.icon-btn { width:46px; height:46px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; border:1px solid #eee; cursor:pointer; background:#fff; }

/* Tabs (description/reviews) */
.tabs { margin:34px 12px; }
.tab-head { display:flex; gap:20px; border-bottom:1px solid #eee; }
.tab-head button { background:transparent; border:none; padding:12px 0; font-weight:700; color:var(--muted); cursor:pointer; }
.tab-head button.active { color:var(--accent); border-bottom:3px solid #111; padding-bottom:9px; }
.tab-body { padding:18px 0; }

/* Reviews list */
.review-card { background:#fff; padding:14px; border-radius:10px; margin-bottom:10px; box-shadow:0 6px 18px rgba(10,10,10,0.04); }

/* Related products strip (reuse product-card look) */
.related { margin:18px 12px 80px; }
.related-grid { display:flex; gap:12px; overflow-x:auto; padding:8px 4px; }
.related-item { min-width:210px; background:#fff; padding:10px; border-radius:10px; box-shadow:0 8px 30px rgba(10,10,10,0.04); }

/* small helpers */
.txt-muted { color:var(--muted); font-size:13px; }
.center { text-align:center; }

/* responsive tweaks */
@media (max-width: 768px){
    .main-image { height:420px; }
    .product-hero { gap:18px; }
    .info { position:relative; top:auto; }
}
.lux-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
.text-red {
    color: red !important;
}
</style>

<!-- Breadcrumb -->
<div class="container breadcrumb-wrap ">
    <div class="bread-crumb flex-w p-l-25 p-r-15">
        <a href="{{ url('/') }}" class="stext-109 cl8 hov-cl1 trans-04">Home</a>
        <span> / </span>
        <a href="{{ route('frontend.product') }}" class="stext-109 cl8 hov-cl1 trans-04" style="margin-left:8px;">Products</a>
        <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        <span class="stext-109 cl4">{{ $product->name }}</span>
    </div>
</div>

<!-- Product Hero -->
<div class="lux-container">

<section class="product-hero container ">
    <!-- Gallery -->
    <div class="gallery">
        <div class="main-image" id="mainImageWrap">
            @php
                $imgUrl = $product->image ? asset('storage/'.$product->image) : asset('frontend/images/product-placeholder.jpg');
                // If you have gallery images column (not present in base), you can adapt.
                $gallery = [$imgUrl];
                // If product has additional images (example: custom_fields gallery), append them
                if(!empty($product->gallery) && is_array($product->gallery)) {
                    foreach($product->gallery as $g) { $gallery[] = asset('storage/'.$g); }
                }
            @endphp
            <img id="mainImage" src="{{ $gallery[0] }}" alt="{{ $product->name }}">
        </div>

        <div class="thumbs" id="thumbs">
            @foreach($gallery as $g)
                <div class="thumb {{ $loop->first ? 'active' : '' }}" data-src="{{ $g }}">
                    <img src="{{ $g }}" alt="thumb-{{ $loop->index }}">
                </div>
            @endforeach
        </div>

        <!-- Expand / zoom link -->
        <div style="margin-top:12px;" class="txt-muted">Click main image to open in new tab (zoom)</div>
    </div>

    <!-- Info panel -->
    <div class="info">
        <div class="badges">
            @if(method_exists($product, 'isOutOfStock') && $product->isOutOfStock())
                <div class="badge out">Out of Stock</div>
            @elseif(method_exists($product, 'isLowStock') && $product->isLowStock())
                <div class="badge low">Low Stock</div>
            @endif
            <div class="txt-muted" style="align-self:center;">SKU: {{ $product->id }}</div>
        </div>

        <div class="title">{{ $product->name }}</div>
        <div class="subtitle">{{ $product->title ?? '' }}</div>

        <div class="price">Rs. {{ number_format($product->price, 2) }}</div>
        <div class="meta">Available: <strong>{{ $product->quantity ?? 0 }}</strong> • Category: {{ $product->category->name ?? 'N/A' }}</div>

        {{-- Short description --}}
        <p class="txt-muted" style="margin-top:12px;">{{ \Illuminate\Support\Str::limit($product->description ?? '', 240) }}</p>

        {{-- Selectors --}}
        <div class="select-row">
            @if(!empty($fields['Size']) && is_array($fields['Size']))
                <div class="select-group">
                    <label>Size</label>
                    <select class="form-select js-size" name="size">
                        <option value="">Choose size</option>
                        @foreach($fields['Size'] as $s)<option value="{{ $s }}">{{ $s }}</option>@endforeach
                    </select>
                </div>
            @endif

            @if(!empty($fields['Color']) && is_array($fields['Color']))
                <div class="select-group">
                    <label>Color</label>
                    <select class="form-select js-color" name="color">
                        <option value="">Choose color</option>
                        @foreach($fields['Color'] as $c)<option value="{{ $c }}">{{ $c }}</option>@endforeach
                    </select>
                </div>
            @endif

            <div class="select-group qty-wrap">
                <label class="d-block txt-muted">Quantity</label>
                <div style="display:flex; align-items:center; gap:8px;">
                    <button class="qty-btn" id="qtyDown" type="button">-</button>
                    <input type="number" class="num-product" id="quantityInput" value="1" min="1" />
                    <button class="qty-btn" id="qtyUp" type="button">+</button>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="cta-row">
            <form action="{{ route('frontend.add.to.cart.direct') }}" method="POST" id="addToCartForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1" id="formQuantity">
                <input type="hidden" name="size" value="" id="formSize">
                <input type="hidden" name="color" value="" id="formColor">

                @if(method_exists($product, 'isOutOfStock') && $product->isOutOfStock())
                    <button class="btn-cta" disabled>Out of Stock</button>
                @else
                    <button type="submit" class="btn-cta">Add to Cart</button>
                @endif
            </form>

            <div class="icon-row" style="margin-left:auto;">
                @php
$inWishlist = in_array($product->id, $userWishlist ?? []);
@endphp

<form action="{{ route('frontend.wishlist.toggle') }}" method="POST" style="display:inline;">
    @csrf

    <input type="hidden" name="product_id" value="{{ $product->id }}">

@if (Auth::user())
<button type="submit" class="wish-btn" style="border:none; background:none;">
        <i class="fa fa-heart {{ $inWishlist ? 'text-red' : '' }}"></i>
</button>
@else
<button type="submit" class="wish-btn" style="border:none; background:none;">
        <i class="fa fa-heart {{ $inWishlist ? 'text-red' : '' }}"></i>
</button>
@endif



</form>
                <div style="width:10px;"></div>
<div class="txt-muted" style="align-self:center; font-size:13px; cursor:pointer;" onclick="shareProduct()">
    Share
</div>
            </div>
        </div>

        {{-- small features --}}
        <div style="margin-top:14px;" class="txt-muted">Free shipping over Rs. 10,000 • Easy returns • Secure payments</div>
    </div>
</section>
</div>


<!-- Tabs: Description / Reviews -->
<section class="tabs container lux-container">
    <div class="tab-head" role="tablist">
        <button class="active" data-tab="descBtn">Description</button>
        <button data-tab="reviewsBtn">Reviews ({{ $product->reviews()->where('status','approved')->count() }})</button>
        <button data-tab="infoBtn">Additional Info</button>
    </div>

    <div class="tab-body" id="descBtn">
        <div class="tab-panel">
            {!! $product->description ?? '<p class="txt-muted">No description provided.</p>' !!}
        </div>
    </div>

    <div class="tab-body" id="reviewsBtn" style="display:none;">
        <div>
            <div style="margin-top:8px;">
                @foreach($product->reviews->where('status','approved') as $review)
                    <div class="review-card">
                        <div style="display:flex; gap:12px; align-items:flex-start;">
                            <div style="width:48px;"><div style="width:48px;height:48px;border-radius:50%;background:#f1f1f1;display:flex;align-items:center;justify-content:center;"><i class="zmdi zmdi-account"></i></div></div>
                            <div style="flex:1;">
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <div style="font-weight:700;">{{ $review->name }}</div>
                                    <div class="txt-muted">{{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}</div>
                                </div>
                                <div style="margin:6px 0;">
                                    @for($i=1;$i<=5;$i++)
                                        <i class="zmdi zmdi-star{{ $i <= $review->rating ? '' : '-outline' }}"></i>
                                    @endfor
                                </div>
                                <div class="txt-muted">{{ $review->title ? $review->title : '' }}</div>
                                <div style="margin-top:8px;">{{ $review->review }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- If none --}}
                @if($product->reviews->where('status','approved')->count()==0)
                    <div class="txt-muted">No reviews yet. Be the first to review this product.</div>
                @endif
                <div class="tab-content p-t-43">
			<div class="tab-pane  show active" id="reviews" role="tabpanel">
				<div class="row">
					<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
						<form action="{{ route('frontend.review.store') }}" method="POST" class="w-full">
							@csrf
							<input type="hidden" name="product_id" value="{{ $product->id }}">

							<h5 class="mtext-108 cl2 p-b-7">Add a Review</h5>
							<p class="stext-102 cl6">Your email address will not be published. Required fields are marked *</p>

							<div class="flex-w flex-m p-t-50 p-b-23">
								<span class="stext-102 cl3 m-r-16">Your Rating</span>
								<span class="wrap-rating fs-18 cl11 pointer">
									@for ($i = 1; $i <= 5; $i++)
										<i class="item-rating pointer zmdi zmdi-star-outline" data-value="{{ $i }}"></i>
										@endfor
										<input type="hidden" name="rating" class="rating-value" value="0">
								</span>

							</div>

							<div class="row p-b-25">
								<div class="col-12 p-b-5">
									<label for="title" class="stext-102 cl3">Review Title</label>
									<input class="size-111 bor8 stext-102 cl2 p-lr-20" name="title" type="text" placeholder="Give your review a title">
								</div>

								<div class="col-12 p-b-5">
									<label for="review" class="stext-102 cl3">Review</label>
									<textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" name="review" rows="4" placeholder="Write your comments here"></textarea>
								</div>

								<div class="col-sm-6 p-b-5">
									<label for="name" class="stext-102 cl3">Name</label>
									<input class="size-111 bor8 stext-102 cl2 p-lr-20" name="name" type="text" required>
								</div>

								<div class="col-sm-6 p-b-5">
									<label for="email" class="stext-102 cl3">Email</label>
									<input class="size-111 bor8 stext-102 cl2 p-lr-20" name="email" type="email" required>
								</div>
							</div>

							<button class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10" type="submit">
								Submit Review
							</button>
						</form>

						@if(session('success'))
						<div class="alert alert-success mt-2">
							{{ session('success') }}
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
            </div>
        </div>
    </div>

    <div class="tab-body" id="infoBtn" style="display:none;">
        <div class="tab-panel">
            <div class="txt-muted">SKU: {{ $product->id }}</div>
            <div class="txt-muted">Category: {{ $product->category->name ?? 'N/A' }}</div>
            <div style="margin-top:8px;">{!! $product->size_guide ?? '<span class="txt-muted">No additional info.</span>' !!}</div>
        </div>
    </div>
</section>

<!-- Related products -->
<section class="related container lux-container">
    <h4 style="margin-bottom:10px;">You may also like</h4>
    <div class="related-grid">
        @php
            $related = \App\Models\Product::where('category_id', $product->category_id)
                        ->where('id', '!=', $product->id)
                        ->take(8)->get();
        @endphp

        @forelse($related as $p)
            <div class="related-item center">
                <a href="{{ route('frontend.product-detail', ['id' => $p->id]) }}" style="text-decoration:none;">
                    <img src="{{ $p->image ? asset('storage/'.$p->image) : asset('frontend/images/product-placeholder.jpg') }}" style="width:100%; height:140px; object-fit:cover; border-radius:8px;">
                    <div style="margin-top:10px; font-weight:700; color:#111;">{{ \Illuminate\Support\Str::limit($p->name, 36) }}</div>
                    <div class="txt-muted">Rs. {{ number_format($p->price,2) }}</div>
                </a>
            </div>
        @empty
            <div class="txt-muted">No related products found.</div>
        @endforelse
    </div>
</section>

<!-- JS: gallery, tabs, qty, form sync -->
<script>
document.addEventListener('DOMContentLoaded', function(){
    // Gallery thumbnails
    document.querySelectorAll('.thumb').forEach(function(t){
        t.addEventListener('click', function(){
            document.querySelectorAll('.thumb').forEach(x=>x.classList.remove('active'));
            this.classList.add('active');
            const src = this.dataset.src;
            document.getElementById('mainImage').src = src;
        });
    });

    // Open main image in new tab on click
    document.getElementById('mainImageWrap').addEventListener('click', function(){
        const src = document.getElementById('mainImage').src;
        window.open(src, '_blank');
    });

    // Qty buttons
    const qtyDown = document.getElementById('qtyDown');
    const qtyUp = document.getElementById('qtyUp');
    const qtyInput = document.getElementById('quantityInput');
    const formQty = document.getElementById('formQuantity');

    qtyDown && qtyDown.addEventListener('click', function(){ let v = parseInt(qtyInput.value)||1; if(v>1) v--; qtyInput.value=v; formQty.value=v; });
    qtyUp && qtyUp.addEventListener('click', function(){ let v = parseInt(qtyInput.value)||1; v++; qtyInput.value=v; formQty.value=v; });
    qtyInput && qtyInput.addEventListener('change', function(){ let v = parseInt(qtyInput.value)||1; if(v<1) v=1; qtyInput.value=v; formQty.value=v; });

    // Select sync (size/color)
    const sizeSelect = document.querySelector('.js-size');
    const colorSelect = document.querySelector('.js-color');
    const formSize = document.getElementById('formSize');
    const formColor = document.getElementById('formColor');

    if(sizeSelect) sizeSelect.addEventListener('change', e=>formSize.value = e.target.value);
    if(colorSelect) colorSelect.addEventListener('change', e=>formColor.value = e.target.value);

    // Tabs
    document.querySelectorAll('.tab-head button').forEach(btn=>{
        btn.addEventListener('click', function(){
            document.querySelectorAll('.tab-head button').forEach(b=>b.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.tab-body').forEach(tb=>tb.style.display='none');
            const id = this.dataset.tab;
            document.getElementById(id).style.display = 'block';
            window.scrollTo({top: document.querySelector('.tabs').offsetTop - 100, behavior:'smooth'});
        });
    });

    // Wishlist simple toggle
    document.querySelectorAll('.js-wish').forEach(w=>{
        w.addEventListener('click', function(e){
            e.preventDefault();
            this.classList.toggle('active');
            this.querySelector('i').style.color = this.classList.contains('active') ? '#e60023' : '#6b6b6b';
        });
    });

    // Ensure form quantity initial value set
    formQty.value = qtyInput.value;
});
</script>
<script>
function shareProduct() {
    const url = window.location.href; // current page URL
    if (navigator.share) {
        navigator.share({
            title: document.title,
            url: url
        }).catch((err) => {
            alert('Sharing failed: ' + err);
        });
    } else {
        // fallback: copy URL to clipboard
        navigator.clipboard.writeText(url).then(() => {
            alert('Link copied to clipboard!');
        });
    }
}
</script>
@endsection
