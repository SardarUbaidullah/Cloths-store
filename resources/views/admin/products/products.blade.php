@extends('admin.layout.app')

@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <p class="card-title mb-0">All Products</p>
        <div class="table-responsive">
          <table class="table table-striped table-borderless align-middle">
            <thead class="table-light">
              <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Size</th>
                <th>Color</th>
                <th>Price</th>
                <th>InStock</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Added</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
@foreach($products as $product)
<tr>
    <td>
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" class="img-thumbnail" width="60" />
        @else
            <img src="https://via.placeholder.com/60" class="img-thumbnail" width="60" />
        @endif
    </td>
    <td>{{ $product->name }}</td>
    <td>{{ $product->description }}</td>
    <td>{{ $product->category->name ?? 'N/A' }}</td>
    @php
        $fields = json_decode($product->custom_fields, true);
        $size = $fields['Size'][0] ?? '-';
        $color = $fields['Color'][0] ?? '-';
    @endphp
    <td>{{ $size }}</td>
    <td>{{ $color }}</td>
    <td class="fw-bold">Rs. {{ $product->price }}</td>

    <!-- Stock Status -->
    <td>
        @if($product->quantity < 5 && $product->quantity > 0)
            <span class="badge bg-warning text-dark">Low Stock ({{ $product->quantity }})</span>
        @elseif($product->quantity == 0)
            <span class="badge bg-danger">Out of Stock</span>
        @else
            <span class="badge bg-success">In Stock ({{ $product->quantity }})</span>
        @endif
    </td>

    <td>{{ $product->quantity }}</td>

    <td>
        <span class="badge bg-success">Active</span>
    </td>
    <td>{{ $product->created_at->format('d M Y') }}</td>
    <td>
        <a href="{{route("admin.products.edit", $product->id)}}" class="btn btn-sm btn-primary">Edit</a>
       <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
        Delete
    </button>
</form>

    </td>
</tr>
@endforeach

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
