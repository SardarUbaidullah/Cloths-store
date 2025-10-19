@extends('frontend.layouts.main')
@section('main-container')
<!-- breadcrumb -->
<div class="container" style="margin-top: 150px;">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-20 p-lr-0-lg">
        <a href="{{ url('/') }}" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>
        <span class="stext-109 cl4">Shopping Cart</span>
    </div>
</div>

<!-- Shopping Cart -->
<div class="container">
    <div class="row">
        <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
            <div class="m-l-25 m-r--38 m-lr-0-xl">
                <div class="wrap-table-shopping-cart">
                    @php
                        $cart = session('cart', []);
                        $total = 0;
                    @endphp

                    @if(count($cart) > 0)
                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th class="column-1">Product</th>
                                <th class="column-2">Details</th>
                                <th class="column-3">Price</th>
                                <th class="column-4">Quantity</th>
                                <th class="column-5">Total</th>
                                <th class="column-6">Action</th>
                            </tr>

                            @foreach($cart as $item)
                                @php
                                    $itemTotal = $item['price'] * $item['quantity'];
                                    $total += $itemTotal;
                                @endphp
                                <tr class="table_row" data-id="{{ $item['cart_key'] ?? $item['id'] }}">
                                    <td class="column-1">
                                        <div class="how-itemcart1">
                                            <img src="{{ asset('storage/products/' . basename($item['image'])) }}"
                                                 onerror="this.onerror=null;this.src='{{ asset('frontend/images/no-image.png') }}';"
                                                 alt="IMG">
                                        </div>
                                    </td>
                                    <td class="column-2">
                                        <strong>{{ $item['name'] }}</strong><br>
                                        @if(isset($item['size']) && $item['size'])
                                            <small>Size: {{ $item['size'] }}</small><br>
                                        @endif
                                        @if(isset($item['color']) && $item['color'])
                                            <small>Color: {{ $item['color'] }}</small><br>
                                        @endif
                                    </td>
                                    <td class="column-3">Rs. {{ $item['price'] }}</td>
                                    <td class="column-4">
                                        <div class="quantity-box">
                                            <button class="qty-btn minus" data-id="{{ $item['cart_key'] ?? $item['id'] }}">−</button>
                                            <span class="qty-number">{{ $item['quantity'] }}</span>
                                            <button class="qty-btn plus" data-id="{{ $item['cart_key'] ?? $item['id'] }}">+</button>
                                        </div>
                                    </td>
                                    <td class="column-5">Rs. <span class="item-total">{{ $itemTotal }}</span></td>
                                    <td class="column-6">


                                            <a href="{{ route('frontend.cart.remove', $item['cart_key'] ?? $item['id']) }}" type="submit" class="btn btn-sm btn-danger">Remove</a>

                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <div class="empty-cart text-center" style="padding:60px 20px;">
                            <img src="{{ asset('frontend/images/empty.png') }}" alt="Empty Cart" style="max-width:220px; display:block; margin:auto; filter:drop-shadow(0 5px 15px rgba(0,0,0,0.2));">
                            <h3 style="margin-top:20px; font-weight:600;">Your Cart is Empty</h3>
                            <p style="color:#555;">Looks like you haven’t added anything yet.</p>
                            <a href="{{ url('/') }}" class="btn btn-dark mt-2">Continue Shopping</a>
                        </div>
                    @endif
                </div>

                <!-- Coupon & Update -->
                @if(count($cart) > 0)
                    <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm mt-3">
                        <div class="flex-w flex-m m-r-20 m-tb-5">
                            <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text" name="coupon" placeholder="Coupon Code">
                            <button class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">Apply Coupon</button>
                        </div>
                        <button class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10" id="updateCartBtn">Update Cart</button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Cart Totals -->
        <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
            <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                <h4 class="mtext-109 cl2 p-b-30">Cart Totals</h4>
                <div class="flex-w flex-t bor12 p-b-13">
                    <div class="size-208"><span class="stext-110 cl2">Subtotal:</span></div>
                    <div class="size-209"><span id="cartSubtotal" class="mtext-110 cl2">Rs. {{ $total }}</span></div>
                </div>
                <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                    <div class="size-208 w-full-ssm"><span class="stext-110 cl2">Shipping:</span></div>
                    <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                        <p class="stext-111 cl6 p-t-2">There are no shipping methods available. Please check your address.</p>
                    </div>
                </div>
                <div class="flex-w flex-t p-t-27 p-b-33">
                    <div class="size-208"><span class="mtext-101 cl2">Total:</span></div>
                    <div class="size-209 p-t-1"><span id="cartTotal" class="mtext-110 cl2">Rs. {{ $total }}</span></div>
                </div>
              @if(count($cart) > 0)
<form action="{{ route('checkout.process') }}" method="POST">
    @csrf
    <div class="mb-2"><input type="text" name="name" placeholder="Full Name" class="form-control" required></div>
    <div class="mb-2"><input type="email" name="email" placeholder="Email" class="form-control" required></div>
    <div class="mb-2"><input type="text" name="phone" placeholder="Phone (USA)" class="form-control" required></div>
    <div class="mb-2"><textarea name="address" placeholder="Shipping Address" class="form-control" required></textarea></div>
    <button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
        Place Order & Send OTP
    </button>
</form>
@endif

            </div>
        </div>
    </div>
</div>

<!-- Quantity & Auto Calculation Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartRows = document.querySelectorAll('.table_row');

    cartRows.forEach(row => {
        const minusBtn = row.querySelector('.qty-btn.minus');
        const plusBtn = row.querySelector('.qty-btn.plus');
        const qtyNumber = row.querySelector('.qty-number');
        const itemTotalEl = row.querySelector('.item-total');
        const price = parseFloat(row.querySelector('.column-3').innerText.replace('Rs. ',''));

        minusBtn && minusBtn.addEventListener('click', function() {
            let qty = parseInt(qtyNumber.innerText);
            if(qty > 1) qty--;
            qtyNumber.innerText = qty;
            itemTotalEl.innerText = (qty * price).toFixed(2);
            updateCartSubtotal();
        });

        plusBtn && plusBtn.addEventListener('click', function() {
            let qty = parseInt(qtyNumber.innerText);
            qty++;
            qtyNumber.innerText = qty;
            itemTotalEl.innerText = (qty * price).toFixed(2);
            updateCartSubtotal();
        });
    });

    function updateCartSubtotal() {
        let subtotal = 0;
        document.querySelectorAll('.item-total').forEach(it => {
            subtotal += parseFloat(it.innerText);
        });
        document.getElementById('cartSubtotal').innerText = 'Rs. ' + subtotal.toFixed(2);
        document.getElementById('cartTotal').innerText = 'Rs. ' + subtotal.toFixed(2);
    }
});
</script>

<!-- Styling for Quantity Buttons -->
<style>
.quantity-box {
    display:flex;
    align-items:center;
    border:1px solid #ddd;
    border-radius:6px;
    overflow:hidden;
    width:110px;
}
.qty-btn {
    background:#f1f1f1;
    border:none;
    padding:6px 12px;
    cursor:pointer;
    font-size:18px;
}
.qty-number {
    flex:1;
    text-align:center;
    font-weight:600;
    font-size:16px;
}
.qty-btn:hover { background:#e0e0e0; }
</style>
@endsection
