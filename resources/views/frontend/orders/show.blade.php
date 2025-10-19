@extends('frontend.layouts.main')
@section('main-container')

<style>
/* Container */
.order-details-section {
    max-width: 950px;
    margin: 120px auto;
    background: #fff;
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    font-family: 'Poppins', sans-serif;
}

/* Back Button */
.back-btn {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 8px;
    border: 1px solid #ddd;
    color: #444;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
}
.back-btn:hover {
    background: #f0f0f0;
}

/* Heading */
.order-details-section h3 {
    text-align: center;
    font-size: 28px;
    font-weight: 700;
    color: #222;
    margin-bottom: 25px;
}

/* Labels */
.detail-label {
    font-weight: 600;
    color: #555;
    margin-right: 6px;
}

/* Badges */
.badge-status {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    color: #fff;
    display: inline-block;
    text-transform: capitalize;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    min-width: 100px;
    text-align: center;
}

/* Order Status Colors */
.badge-pending    { background: #ff9800; }
.badge-processing { background: #03a9f4; }
.badge-shipped    { background: #4caf50; }
.badge-delivered  { background: #009688; }
.badge-canceled   { background: #f44336; }

/* Payment Status Colors */
.badge-paid                 { background: #4caf50; }
.badge-refunded             { background: #ff5722; }
.badge-pending-payment      { background: #ff9800; }

/* Summary Box */
.summary-box {
    background: #f7f7f7;
    padding: 20px;
    border-radius: 12px;
    margin-top: 25px;
    font-weight: 600;
    font-size: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Items List */
.item-row {
    border-bottom: 1px solid #eee;
    padding: 15px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.item-row:last-child {
    border-bottom: none;
}
.item-title {
    font-weight: 600;
    font-size: 16px;
    color: #333;
}
.item-qty {
    font-size: 14px;
    color: #777;
    margin-top: 3px;
}

/* Responsive */
@media(max-width:768px){
    .item-row {
        flex-direction: column;
        align-items: flex-start;
    }
    .summary-box {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}

/* Empty Message */
.empty-orders {
    text-align: center;
    padding: 60px 20px;
}
.empty-orders h3 {
    font-weight: 600;
    color: #555;
    margin-top: 20px;
}
.empty-orders p {
    color: #888;
    margin-top: 8px;
}
.empty-orders img {
    max-width: 180px;
    filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));
}
.empty-orders a {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 25px;
    background: #1e88e5;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
}
.empty-orders a:hover {
    background: #1565c0;
}
</style>

<div class="order-details-section">

    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('user.orders') }}" class="back-btn">
            ← Back to My Orders
        </a>
    </div>

    <h3>Order Details</h3>
    <hr>

    @if($order)
    <!-- Order Info -->
    <div class="mb-2"><span class="detail-label">Order Number:</span> {{ $order->order_number }}</div>
    <div class="mb-2">
        <span class="detail-label">Order Status:</span>
        <span class="badge-status badge-{{ strtolower($order->order_status) }}">
            {{ ucfirst($order->order_status) }}
        </span>
    </div>
    <div class="mb-2">
        <span class="detail-label">Payment Status:</span>
        <span class="badge-status badge-{{ strtolower(str_replace(' ','-',$order->payment_status)) }}">
            {{ ucfirst($order->payment_status) }}
        </span>
    </div>
    <div class="mb-3">
        <span class="detail-label">Ordered At:</span> {{ $order->created_at->format('d M Y h:i A') }}
    </div>

    <!-- Summary -->
    <div class="summary-box">
        <div>Total Paid:</div>
        <div>Rs {{ number_format($order->total, 2) }}</div>
    </div>

    <!-- Items -->
    <h5 class="mt-4 mb-3">Items in this Order</h5>
    @foreach($order->items as $item)
    <div class="item-row">
        <div>
            <div class="item-title">{{ $item->product->name ?? 'N/A' }}</div>
            <div class="item-qty">Qty: {{ $item->quantity }}</div>
        </div>
        <div>Rs {{ number_format($item->price * $item->quantity, 2) }}</div>
    </div>
    @endforeach
    @else
    <!-- Empty Orders -->
    <div class="empty-orders">
        <img src="{{ asset('frontend/images/empty-cart.svg') }}" alt="No Orders">
        <h3>No Orders Found</h3>
        <p>Looks like you haven’t placed any orders yet.</p>
        <a href="{{ url('/') }}">Continue Shopping</a>
    </div>
    @endif

</div>

@endsection
