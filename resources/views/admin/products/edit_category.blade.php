@extends('admin.layout.app')

@section('content')
<div class="container my-5" style="max-width: 700px;">
    <h4 class="mb-4 fw-semibold text-dark">Edit Category</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Category Name --}}
        <div class="mb-3">
            <label class="form-label">Category Name:</label>
            <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
        </div>

        {{-- Show Old Image --}}
        <div class="mb-3">
            <label class="form-label">Current Image:</label><br>
            @if($category->image)
                <img src="{{ asset('uploads/categories/' . $category->image) }}" width="80" class="img-thumbnail mb-2">
            @else
                <p>No Image Available</p>
            @endif
            <input type="file" name="image" class="form-control mt-2">
        </div>

        {{-- Extra Fields (Optional Future) --}}
        {{-- You can add extra fields here like size/color if needed --}}

        <button type="submit" class="btn btn-dark mt-3">Update Category</button>
    </form>
</div>
@endsection
