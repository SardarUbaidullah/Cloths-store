@extends('admin.layout.app')
@section('content')
<div class="row">    
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <p class="card-title mb-0">Pending Orders</p>
        <div class="table-responsive">
          <table class="table table-striped table-borderless">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Order Date</th>
                <th>Payment Method</th>
                <th>Total Amount (PKR)</th>
                <th>Status</th>
                <th>Action</th>
              </tr>  
            </thead>
            <tbody>
              <tr>
                <td>#ORD-00124</td>
                <td>Hina Shah</td>
                <td>21 May 2025</td>
                <td>Cash on Delivery</td>
                <td class="font-weight-bold">4,500</td>
                <td class="font-weight-medium"><div class="badge badge-warning">Pending</div></td>
                <td>
                  <button class="btn btn-sm btn-primary">View</button>
                  <button class="btn btn-sm btn-success">Complete</button>
                  <button class="btn btn-sm btn-danger">Cancel</button>
                </td>
              </tr>
              <tr>
                <td>#ORD-00125</td>
                <td>Ali Khan</td>
                <td>22 May 2025</td>
                <td>Credit Card</td>
                <td class="font-weight-bold">3,200</td>
                <td class="font-weight-medium"><div class="badge badge-warning">Pending</div></td>
                <td>
                  <button class="btn btn-sm btn-primary">View</button>
                  <button class="btn btn-sm btn-success">Complete</button>
                  <button class="btn btn-sm btn-danger">Cancel</button>
                </td>
              </tr>
              <!-- More rows as needed -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection