@extends('admin.layout.app')

@section('content')
<div class="container my-5" style="max-width: 700px;">
    <h4 class="mb-4 fw-semibold text-dark">Add New Category</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.category.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm border " enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Category Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Category Image:</label>
            <input type="file" name="image" class="form-control">
        </div>


        <div id="extra-fields">
            <div class="row g-2 mb-2 field-group">
                <div class="col">
                    <input type="text" name="extra_fields[]" class="form-control" placeholder="Field Name (e.g., Size)">
                </div>
                <div class="col">
                    <input type="text" name="extra_options[]" class="form-control" placeholder="Options (comma separated)">
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addExtraField()">+ Add More Fields</button>

        <div class="mt-4">
            <button type="submit" class="btn btn-dark">Create Category</button>
        </div>
    </form>
</div>

<script>
function addExtraField() {
    const container = document.getElementById('extra-fields');
    const div = document.createElement('div');
    div.classList.add('row', 'g-2', 'mb-2', 'field-group');
    div.innerHTML = `
        <div class="col">
            <input type="text" name="extra_fields[]" class="form-control" placeholder="Field Name (e.g., Size)">
        </div>
        <div class="col">
            <input type="text" name="extra_options[]" class="form-control" placeholder="Options (comma separated)">
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.parentElement.remove()">Remove</button>
        </div>
    `;
    container.appendChild(div);
}
</script>
@endsection
