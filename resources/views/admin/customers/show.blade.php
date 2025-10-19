@extends('admin.layout.app')

@section('content')

<div class="container py-4">

    {{-- Back Button --}}
    <a href="{{ route('admin.admin.customers.index') }}" class="btn btn-secondary mb-3">
        ← Back to Customers List
    </a>

    {{-- Customer Info --}}
    <div class="card mb-4">
        <div class="card-header">
            <h4>Customer Details</h4>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $customer->name }}</p>
            <p><strong>Email:</strong> {{ $customer->email }}</p>
            <p><strong>Total Orders:</strong> {{ $customer->orders->count() }}</p>
        </div>
    </div>

    {{-- Customer Orders --}}
    <div class="card">
        <div class="card-header">
            <h4>Customer Orders</h4>
        </div>
        <div class="card-body">
            @forelse($customer->orders as $order)
                <div class="border rounded p-3 mb-4">
                    <h5>Order #{{ $order->order_number }}</h5>
                    <p><strong>Date:</strong> {{ $order->created_at->format('d M Y h:i A') }}</p>
                    <p><strong>Total:</strong> Rs {{ number_format($order->total, 2) }}</p>
                    <p><strong>Payment Status:</strong>
                        <span class="badge bg-warning">{{ ucfirst($order->payment_status) }}</span>
                    </p>
                    <p><strong>Order Status:</strong>
                        <span class="badge bg-info">{{ ucfirst($order->order_status) }}</span>
                    </p>

                    {{-- Order Items Table --}}
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rs {{ number_format($item->price, 2) }}</td>
                                    <td>Rs {{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @empty
                <p class="text-center">No orders found for this customer.</p>
            @endforelse
        </div>
    </div>

</div>

@endsection
