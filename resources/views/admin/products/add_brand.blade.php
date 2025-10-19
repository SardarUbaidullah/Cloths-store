@extends('admin.layout.app')
@section('content')
<div class="container my-5" style="max-width: 600px;">
  <form action="/brands/store" method="POST" class="bg-white p-4 rounded shadow-sm border">
    @csrf
    <h4 class="mb-4 text-center fw-semibold">Add New Brand</h4>

    <div class="mb-3">
      <label for="brand_name" class="form-label">Brand Name</label>
      <input type="text" id="brand_name" name="brand_name" class="form-control" placeholder="e.g. Outfitters" required>
    </div>

    <div class="text-end mt-4">
      <button type="submit" class="btn btn-success px-4">Save</button>
    </div>
  </form>
</div>

<script>
  function loadCategoryFields(categoryId) {
    if (!categoryId) {
        document.getElementById('dynamic-fields').innerHTML = '';
        return;
    }

    fetch(`/admin/category-fields/${categoryId}`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('dynamic-fields');
            container.innerHTML = '';

            // Size guide modal content
            document.getElementById('sizeGuideContent').innerHTML = data.size_guide || 'No size guide available.';

            if (data.fields && Object.keys(data.fields).length > 0) {
                // data.fields is expected to be an object like { size: [...], color: [...], fabric: [...] }

                for (const [fieldKey, options] of Object.entries(data.fields)) {
                    let label = fieldKey.charAt(0).toUpperCase() + fieldKey.slice(1);

                    let html = `<div class="mb-3 custom-option-group">`;
                    html += `<label class="form-label fw-bold">${label}`;
                    if (label.toLowerCase() === 'size') {
                        html += ` <a href="#" data-bs-toggle="modal" data-bs-target="#sizeGuideModal" class="ms-2 small text-decoration-underline">View Size Guide</a>`;
                    }
                    html += `</label>`;

                    html += `<div class="custom-size-options">`;

                    options.forEach(option => {
                        const inputId = `${fieldKey}-${option}`.replace(/\s+/g, '-').toLowerCase();
                        html += `
                            <input type="checkbox" class="btn-check" name="custom_fields[${fieldKey}][]" id="${inputId}" value="${option}" autocomplete="off">
                            <label class="btn btn-outline-dark custom-size-btn" for="${inputId}">${option}</label>
                        `;
                    });

                    html += `</div></div>`;

                    container.innerHTML += html;
                }
            } else {
                container.innerHTML = '<p>No extra fields for this category.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching category fields:', error);
        });
}

</script>
@endsection