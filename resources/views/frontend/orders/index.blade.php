@extends('frontend.layouts.main')
@section('main-container')

<style>
    .user-orders-section {
        max-width: 1000px;
        margin: 150px auto;
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0px 10px 30px rgba(0,0,0,0.08);
    }

    .order-heading {
        font-weight: 700;
        font-size: 26px;
        margin-bottom: 30px;
        text-align: center;
        color: #333;
    }

    .table-modern {
        border: none;
        width: 100%;
    }

    .table-modern thead tr {
        background: #f1f1f1;
    }

    .table-modern th, .table-modern td {
        vertical-align: middle;
        text-align: center;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-warning { background:#FFF3CD; color:#856404; }
    .badge-info { background:#D1ECF1; color:#0C5460; }
    .btn-details {
        font-size: 13px;
        padding: 6px 12px;
        border-radius: 8px;
    }

    /* Empty state */
    .empty-orders {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-orders img {
        max-width: 180px;
        margin-bottom: 20px;
        filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));
    }

    .empty-orders h3 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .empty-orders p {
        color: #666;
        margin-bottom: 20px;
    }

    .empty-orders .btn {
        background: #333;
        color: #fff;
        padding: 10px 25px;
        border-radius: 10px;
        transition: 0.3s;
    }

    .empty-orders .btn:hover {
        background: #555;
    }
</style>

<div class="user-orders-section">
    <h3 class="order-heading">My Orders</h3>

    @if($orders->count() > 0)
    <table class="table table-modern">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>Rs {{ number_format($order->total, 2) }}</td>
                <td><span class="badge badge-status badge-warning">{{ ucfirst($order->payment_status) }}</span></td>
                <td><span class="badge badge-status badge-info">{{ ucfirst($order->order_status) }}</span></td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('user.orders.show', $order->order_number) }}" class="btn btn-dark btn-details">
                        View
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-orders">
        <img src="{{ asset('frontend/images/empty-cart.svg') }}" alt="No Orders">
        <h3>No Orders Yet!</h3>
        <p>You haven’t made any purchases yet. Start shopping to see your orders here.</p>
        <a href="{{ url('/') }}" class="btn">Continue Shopping</a>
    </div>
    @endif
</div>

@endsection
