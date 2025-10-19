@extends('admin.layout.app')
@section('content')
<div class="container-fluid">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary mb-3">← Back to Orders</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Order #{{ $order->order_number }}</strong>
                    <span class="float-end">Status:
                        <span class="badge bg-{{ $order->order_status == 'delivered' ? 'success' : ($order->order_status == 'canceled' ? 'danger' : 'info') }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </span>
                </div>
                <div class="card-body">
                    <p><strong>Customer:</strong> {{ $order->user?->name ?? 'Guest' }} ({{ $order->user?->email ?? '-' }})</p>
                    <p><strong>Order Date:</strong> {{ $order->ordered_at ?? $order->created_at }}</p>
                    <p><strong>Payment Status:</strong> <span class="badge bg-{{ $order->payment_status=='paid' ? 'success' : 'secondary' }}">{{ ucfirst($order->payment_status) }}</span></p>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><strong>Items</strong></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $it)
                                <tr>
                                    <td>
                                        {{ $it->product?->name ?? 'Product #' . $it->product_id }}
                                        @if(isset($it->size)) <br><small>Size: {{ $it->size }}</small> @endif
                                    </td>
                                    <td>Rs. {{ number_format($it->price,2) }}</td>
                                    <td>{{ $it->quantity }}</td>
                                    <td>Rs. {{ number_format($it->total,2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <strong>Subtotal:</strong> Rs. {{ number_format($order->subtotal,2) }} <br>
                    <strong>Total:</strong> Rs. {{ number_format($order->total,2) }}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- Status & Payment Update --}}
            <div class="card mb-3">
                <div class="card-header"><strong>Update Order</strong></div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Order Status</label>
                            <select name="order_status" class="form-select">
                                @foreach($orderStatuses as $s)
                                    <option value="{{ $s }}" @selected($order->order_status == $s)>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" class="form-select">
                                @foreach($paymentStatuses as $p)
                                    <option value="{{ $p }}" @selected($order->payment_status == $p)>{{ ucfirst($p) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Delivered At (optional)</label>
                            <input type="datetime-local" name="delivered_at" value="{{ optional($order->delivered_at)->format('Y-m-d\TH:i') }}" class="form-control">
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Customer Info --}}
            <div class="card">
                <div class="card-header"><strong>Customer</strong></div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->user?->name ?? 'Guest' }}</p>
                    <p><strong>Email:</strong> {{ $order->user?->email ?? '-' }}</p>
                    {{-- Add address fields if you store them --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
