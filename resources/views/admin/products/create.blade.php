@extends('admin.layout.app')

@section('content')

<style>
    .custom-size-options {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .custom-size-btn {
        min-width: 50px;
        text-align: center;
        border-radius: 0;
        font-weight: 500;
        padding: 6px 12px;
    }
</style>

<div class="container my-5" style="max-width: 800px;">
    <h4 class="mb-4 fw-semibold text-dark">Add New Product</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Static Fields --}}
        <div class="mb-3">
            <label class="form-label">Product Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description:</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Price:</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantity:</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Image:</label>
            <input type="file" name="image" class="form-control">
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label class="form-label">Category:</label>
            <select name="category_id" class="form-control" onchange="loadCategoryFields(this.value)" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" data-guide="{{ $category->size_guide }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Size Guide Field --}}
       <div class="mb-3">
    <label for="size_guide" class="form-label">Size Guide (Optional)</label>
    <textarea name="size_guide" class="form-control" rows="4" placeholder="Enter size guide text or HTML"></textarea>
</div>


        {{-- Dynamic Fields Area --}}
        <div id="dynamic-fields" class="mt-3"></div>

        <div class="mt-4">
            <button type="submit" class="btn btn-dark">Add Product</button>
        </div>
    </form>

    
    <!-- Modal -->
   <!-- Size Guide Modal -->
<div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Size Guide</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="sizeGuideContent">
                <!-- Will be populated dynamically -->
            </div>
        </div>
    </div>
</div>


</div>

<script>
function loadCategoryFields(categoryId) {
    if (!categoryId) return;

    fetch(`/admin/category-fields/${categoryId}`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('dynamic-fields');
            container.innerHTML = '';

            // Set the size guide modal content
            document.getElementById('sizeGuideContent').innerHTML = data.size_guide || 'No size guide available.';

            if (data.fields && data.fields.length > 0) {
                data.fields.forEach(field => {
                    let html = `<div class="mb-3 custom-option-group">`;

                    html += `<label class="form-label fw-bold">${field.label}`;
                    if (field.label.toLowerCase() === 'size') {
                        html += ` <a href="#" data-bs-toggle="modal" data-bs-target="#sizeGuideModal" class="ms-2 small text-decoration-underline">View Size Guide</a>`;
                    }
                    html += `</label>`;

                    html += `<div class="custom-size-options">`;
                    field.options.forEach((option, index) => {
                        const inputId = `${field.label}-${option}`.replace(/\s+/g, '-');
                       html += `
    <input type="checkbox" class="btn-check" name="custom_fields[${field.label}][]" id="${inputId}" value="${option}" autocomplete="off">
    <label class="btn btn-outline-dark custom-size-btn" for="${inputId}">${option}</label>
`;
                    });
                    html += `</div></div>`;

                    container.innerHTML += html;
                });
            }
        })
        .catch(error => {
            console.error('Error fetching category fields:', error);
        });
}
</script>
@endsection
