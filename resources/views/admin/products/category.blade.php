@extends('admin.layout.app')

@section('content')
<div class="container my-5">
  <h4 class="mb-4 fw-semibold text-dark">All Categories</h4>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Slug</th>
        <th>Extra Fields</th>
        <th>Image</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($categories as $category)
        <tr>
          <td>{{ $category->name }}</td>
          <td>{{ $category->slug }}</td>
          <td>
            @php
              $extraFields = json_decode($category->extra_fields, true) ?: [];
            @endphp

            @if(count($extraFields) > 0)
              <ul class="ps-3 mb-0">
                @foreach($extraFields as $field)
                  @if(isset($field['label']) && isset($field['options']))
                    <li>
                      <strong>{{ $field['label'] }}:</strong> {{ implode(', ', $field['options']) }}
                    </li>
                  @endif
                @endforeach
              </ul>
            @else
              <em>No extra fields</em>
            @endif
          </td>
 <td>
        @if($category->image)
            <img src="{{ asset('uploads/categories/' . $category->image) }}" alt="Image" width="80">
        @else
            <span>No Image</span>
        @endif
    </td>
          <td>
            <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="d-inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
