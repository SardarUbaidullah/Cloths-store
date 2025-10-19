@extends('admin.layout.app')

@section('content')
<div class="container my-4">
    <h4 class="mb-4"> Stock Movement History</h4>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Change</th>
                <th>Type</th>
                <th>Reference</th>
                <th>User</th>
                <th>Date & Time</th>
            </tr>
        </thead>
        <tbody>
            @forelse($histories as $history)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $history->product->name ?? 'Deleted Product' }}</td>
                    <td>
                        @if($history->change > 0)
                            <span class="text-success">+{{ $history->change }}</span>
                        @else
                            <span class="text-danger">{{ $history->change }}</span>
                        @endif
                    </td>
                    <td>{{ ucfirst($history->type) }}</td>
                    <td>{{ $history->reference }}</td>
                    <td>{{ $history->user->name ?? 'System' }}</td>
                    <td>{{ $history->created_at->format('d M Y h:i A') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No stock movement yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
