@extends('admin.layout.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Customer Reviews</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Customer Name</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $review->product->id }}</td>
                            <td>{{ $review->product->name }}</td>
                            <td>{{ $review->name }}</td>
                            <td>{{ $review->rating }} ⭐</td>
                            <td>{{ $review->review }}</td>
                            <td>{{ $review->created_at->format('d M Y') }}</td>
                            <td>
                                @if($review->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($review->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>
                                @if($review->status == 'pending')
                                    <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button class="btn btn-sm btn-success me-1">Approve</button>
                                    </form>

                                    <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="btn btn-sm btn-danger">Reject</button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>{{ ucfirst($review->status) }}</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection

