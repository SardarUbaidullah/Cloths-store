@extends('admin.layout.app')
@section('content')

<div class="container mt-4">
    <h3 class="mb-4">Customers & Buyers</h3>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Total Orders</th>
                <th>Total Spend (Rs)</th>
                <th>Last Order</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->orders_count }}</td>
                <td>{{ number_format($customer->total_spent, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($customer->last_order_date)->format('d M Y') }}</td>
                <td>
<a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-sm btn-dark">
    View Orders
</a>


                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No Customers Found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
