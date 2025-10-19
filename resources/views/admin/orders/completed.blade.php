@extends('admin.orders.details')
@section('content')
<div class="row">    
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <p class="card-title mb-0">Completed Orders</p>
        <div class="table-responsive">
          <table class="table table-striped table-borderless">
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Order Date</th>
                <th>Delivery Date</th>
                <th>Payment Method</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Action</th>
              </tr>  
            </thead>
            <tbody>
              <tr>
                <td>#ORD-00101</td>
                <td>Sara Qureshi</td>
                <td>12 May 2025</td>
                <td>15 May 2025</td>
                <td>JazzCash</td>
                <td class="font-weight-bold">7,800</td>
                <td class="font-weight-medium"><div class="badge badge-success">Completed</div></td>
                <td>
                  <button class="btn btn-sm btn-primary">View</button>
                </td>
              </tr>
              <tr>
                <td>#ORD-00102</td>
                <td>Usman Riaz</td>
                <td>10 May 2025</td>
                <td>14 May 2025</td>
                <td>Bank Transfer</td>
                <td class="font-weight-bold">5,400</td>
                <td class="font-weight-medium"><div class="badge badge-success">Completed</div></td>
                <td>
                  <button class="btn btn-sm btn-primary">View</button>
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