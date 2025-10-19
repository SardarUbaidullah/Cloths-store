@extends('admin.layout.app')
@section('content')
<div class="row">    
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <p class="card-title mb-0">All Brands</p>
          <a href="{{route("admin.brand.create")}}" class="btn btn-sm btn-success">+ Add Brand</a>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-borderless">
            <thead>
              <tr>
                <th>#</th>
                <th>Brand Name</th>
                <th>Action</th>
              </tr>  
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Nike</td>
                <td>
                  <a href="#" class="btn btn-sm btn-primary">Edit</a>
                  <a href="#" class="btn btn-sm btn-danger">Delete</a>
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td>Adidas</td>
                <td>
                  <a href="#" class="btn btn-sm btn-primary">Edit</a>
                  <a href="#" class="btn btn-sm btn-danger">Delete</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
