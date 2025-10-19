<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>BZC</title>
 <link rel="stylesheet" href="{{ asset('/admin/vendors/feather/feather.css') }}">
<link rel="stylesheet" href="{{ asset('/admin/vendors/ti-icons/css/themify-icons.css') }}">
<link rel="stylesheet" href="{{ asset('/admin/vendors/css/vendor.bundle.base.css') }}">
<link rel="stylesheet" href="{{ asset('/admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admin/js/select.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admin/css/vertical-layout-light/style.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="shortcut icon" href="{{ asset('/admin/images/favicon.png') }}" />
</head>
<body>
  <div class="container-scroller">
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class=" brand-logo mr-5" href="index.html"><img src="{{ asset('/admin/images/LOGO (1).png') }}" class="mr-2 " style="width: 100px;" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{ asset('/admin/images/LOGO (1).png') }}" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">

        </ul>
        <ul class="navbar-nav navbar-nav-right">

          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="{{ asset('/admin/images/faces/face28.jpg') }}" alt="profile"/>
            </a>
           <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
    <a class="dropdown-item" href="{{ route('admin.logout') }}"
       onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
        <i class="ti-power-off text-primary"></i>
        Logout
    </a>

    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

          </li>

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->


      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{route("admin.dashboard")}}">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#products" aria-expanded="false" aria-controls="products">
        <i class="icon-layout menu-icon"></i>
        <span class="menu-title">Products</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="products">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="{{ route("admin.products.index") }}">All Products</a></li>
         <li  class="nav-item"><a href="{{ route('admin.stock.history') }}"class="nav-link">View Stock History</a></li>

          <li class="nav-item"><a class="nav-link" href="{{route("admin.products.create")}}">Add New Product</a></li>
          <li class="nav-item"><a class="nav-link" href="{{route("admin.products.category")}}">Categories</a></li>
          <li class="nav-item"><a class="nav-link" href="{{route("admin.products.add_category")}}">Add new Categories</a></li>
 <li class="nav-item"><a class="nav-link" href="{{route("admin.products.brands")}}">Brands</a></li>
          <li class="nav-item"><a class="nav-link" href="{{route("admin.products.add_brand")}}">Add new Brands</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#orders" aria-expanded="false" aria-controls="orders">
        <i class="icon-columns menu-icon"></i>
        <span class="menu-title">Orders</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="orders">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="{{route("admin.orders.index")}}">All Orders</a></li>
          <li class="nav-item"><a class="nav-link" href="{{route("admin.orders.pending")}}">Detail Orders</a></li>
          <li class="nav-item"><a class="nav-link" href="{{route("admin.orders.completed")}}">Completed Orders</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#customers" aria-expanded="false" aria-controls="customers">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Customers</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="customers">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="{{route('admin.admin.customers.index')}}">Customer List</a></li>
          <li class="nav-item"><a class="nav-link" href="{{route("admin.customers.reviews")}}">Customer Reviews</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#reports" aria-expanded="false" aria-controls="reports">
        <i class="icon-bar-graph menu-icon"></i>
        <span class="menu-title">Reports</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="reports">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="#">Sales Report</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Customer Report</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Inventory Report</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings">
        <i class="icon-contract menu-icon"></i>
        <span class="menu-title">Settings</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="settings">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"><a class="nav-link" href="#">Store Settings</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Payment Methods</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Shipping Methods</a></li>
        </ul>
      </div>
    </li>


  </ul>
</nav>

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

            @yield('content')


             </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <!-- <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2025.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
          </div>
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Distributed by <a href="https://www.themewagon.com/" target="_blank">Themewagon</a></span>
          </div>
        </footer>  -->
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <!-- plugins:js -->
  <script src="{{asset("admin/vendors/js/vendor.bundle.base.js") }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="{{asset("admin/vendors/chart.js/Chart.min.js") }}"></script>
  <script src="{{asset("admin/vendors/datatables.net/jquery.dataTables.js") }}"></script>
  <script src="{{asset("admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js") }}"></script>
  <script src="js/dataTables.select.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{asset("admin/js/off-canvas.js") }}"></script>
  <script src="{{asset("admin/js/hoverable-collapse.js") }}"></script>
  <script src="{{asset("admin/js/template.js") }}"></script>
  <script src="{{asset("admin/js/settings.js") }}"></script>
  <script src="{{asset("admin/js/todolist.js") }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{asset("admin/js/dashboard.js") }}"></script>
  <script src="{{asset("admin/js/Chart.roundedBarCharts.js") }}"></script>
  <!-- End custom js for this page-->
</body>

</html>
