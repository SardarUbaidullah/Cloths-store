@extends('admin.layout.app')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Orders</h4>
        <form class="d-flex" method="GET" action="{{ route('admin.orders.index') }}">
            <input name="q" value="{{ request('q') }}" class="form-control form-control-sm me-2" placeholder="Search order/user">
            <select name="order_status" class="form-select form-select-sm me-2">
                <option value="">All Status</option>
                @foreach($orderStatuses as $s)
                    <option value="{{ $s }}" @selected(request('order_status') == $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <select name="payment_status" class="form-select form-select-sm me-2">
                <option value="">Payment</option>
                @foreach($paymentStatuses as $p)
                    <option value="{{ $p }}" @selected(request('payment_status') == $p)>{{ ucfirst($p) }}</option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-primary">Filter</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Order Status</th>
                        <th>Ordered At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->order_number }}</td>
                        <td>
                            @if($order->user)
                                {{ $order->user->name }}<br><small>{{ $order->user->email }}</small>
                            @else
                                Guest
                            @endif
                        </td>
                        <td>Rs. {{ number_format($order->total,2) }}</td>
                        <td>
                            <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status=='refunded' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->order_status == 'delivered' ? 'success' : ($order->order_status == 'canceled' ? 'danger' : 'info') }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </td>
                        <td>{{ $order->ordered_at ? $order->ordered_at : $order->created_at }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">View</a>

                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this order?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">No orders found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
