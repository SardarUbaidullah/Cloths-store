@extends('admin.layout.app')
@section('content')
<div class="container my-5" style="max-width: 800px;">
  <div class="card shadow-sm rounded">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0">Order Details - #ORD-00124</h4>
      <button class="btn btn-sm btn-outline-secondary" onclick="window.history.back()">Back to Orders</button>
    </div>
    <div class="card-body">
      
      <!-- Customer & Order Info -->
      <div class="mb-4">
        <h5>Customer Information</h5>
        <p><strong>Name:</strong> Hina Shah</p>
        <p><strong>Email:</strong> hina@example.com</p>
        <p><strong>Phone:</strong> +92 300 1234567</p>
        <p><strong>Shipping Address:</strong> 123 Street, Karachi, Pakistan</p>
      </div>
      
      <hr>
      
      <div class="mb-4">
        <h5>Order Summary</h5>
        <p><strong>Order Date:</strong> 22 May 2025</p>
        <p><strong>Payment Method:</strong> Cash on Delivery (COD)</p>
        <p><strong>Status:</strong> <span class="badge bg-info text-dark">Processing</span></p>
      </div>
      
      <hr>
      
      <!-- Products List -->
      <div class="mb-4">
        <h5>Products</h5>
        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>Product Name</th>
              <th>Category</th>
              <th>Size</th>
              <th>Quantity</th>
              <th>Unit Price (PKR)</th>
              <th>Subtotal (PKR)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Denim Jacket</td>
              <td>Stitched</td>
              <td>M</td>
              <td>1</td>
              <td>2500</td>
              <td>2500</td>
            </tr>
            <tr>
              <td>Printed Shirt</td>
              <td>Unstitched</td>
              <td>L</td>
              <td>1</td>
              <td>2000</td>
              <td>2000</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="5" class="text-end">Total:</th>
              <th>4500 PKR</th>
            </tr>
          </tfoot>
        </table>
      </div>
      
      <hr>
<div>
        <h5>Additional Notes</h5>
        <p>Customer requested gift wrapping.</p>
      </div>
      
    </div>
  </div>
</div>
@endsection