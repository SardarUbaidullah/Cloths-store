<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bin Zaman Store</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- css login register -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- review css -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/icons/logo.01.png') }}" />

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('frontend/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">

    <!-- Material Design Iconic Font -->
    <link rel="stylesheet" href="{{ asset('frontend/fonts/iconic/css/material-design-iconic-font.min.css') }}">

    <!-- Linearicons -->
    <link rel="stylesheet" href="{{ asset('frontend/fonts/linearicons-v1.0.0/icon-font.min.css') }}">

    <!-- Animate -->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/animate/animate.css') }}">

    <!-- Hamburgers -->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/css-hamburgers/hamburgers.min.css') }}">

    <!-- Animsition -->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/animsition/css/animsition.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">

    <!-- Daterangepicker -->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/daterangepicker/daterangepicker.css') }}">

    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/slick/slick.css') }}">

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/MagnificPopup/magnific-popup.css') }}">

    <!-- Perfect Scrollbar -->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.css') }}">

    <!-- Swiper from CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('frontend/css/util.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/style1.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    a{
        text-decoration: none;
    }
.search-top-wrapper {
  position: relative;
  width: 260px; /* slightly compact */
}

.search-top-wrapper input {
  width: 100%;
  height: 36px; /* reduced from big to compact */
  border-radius: 8px;
  border: 1px solid #d9d9d9;
  padding: 0 38px 0 12px;
  font-size: 13px;
  background: #fff;
  color: #222;
  transition: .25s ease;
    outline: none;

}

.search-top-wrapper input:focus {
  border-color: #111;
  background: #fff;
  outline: none;
}

.search-top-wrapper button {
  position: absolute;
  right: 6px;
  top: 50%;
  transform: translateY(-50%);
  height: 26px; /* reduced for compact look */
  width: 26px;
  padding: 0;
  border-radius: 6px;
  border: none;
  background: #111;
  color: #fff;
  font-size: 13px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  transition: .25s ease;
  outline: none;
}

.search-top-wrapper button:hover {
  background: #000;
  transform: translateY(-50%) scale(1.08);
}
.premium-cart-badge {
  position: absolute;
  top: -6px;
  right: -6px;
  background: #e63946;
  color: #fff;
  font-size: 11px;
  font-weight: 600;
  padding: 2px 6px;
  border-radius: 50px;
  min-width: 18px;
  height: 18px;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>

</head>

<body class="animsition">
    <!-- Header -->
    <!--====================  LUXURY NAVBAR  ====================-->
<!-- ============ LUXURY NAVBAR START ============ -->
<!-- ======= PREMIUM NAVBAR START ======= -->
<header class="premium-header">
  <nav class="premium-navbar navbar navbar-expand-lg">
    <div class="container">
      <!-- Logo -->
      <a class="navbar-brand premium-logo" href="{{ url('/') }}">
  <img src="{{ asset('frontend/images/icons/logo.01.png') }}" class="white-logo" alt="Logo">
</a>

<style>
.white-logo {
  filter: brightness(0) invert(1);
}
</style>


      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#premiumNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu -->
      <div class="collapse navbar-collapse justify-content-center" id="premiumNav">
        <ul class="navbar-nav align-items-center premium-menu">
          <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->is('product') ? 'active' : '' }}" href="{{ url('/product') }}">Shop</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>
          @auth
          <li class="nav-item"><a class="nav-link" href="{{ route('user.orders') }}">My Orders</a></li>
          @endauth
        </ul>
      </div>

      <!-- Right Icons -->
      <div class="d-flex align-items-center gap-3">


     <!-- Search -->
<form action="{{ route('product.search') }}" method="GET" class="d-flex w-100 align-items-center" style="gap:0;">

    {{-- Category Dropdown --}}
    <div style="flex:0 0 200px;">
        <select name="category_id" class="form-select rounded-0 rounded-start-pill" style="height: 40px;">
            <option value="">All Categories</option>
            @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Search Input + Button inside --}}
    <div class="position-relative w-100">
        <input
            name="query"
            value="{{ request('query') }}"
            class="form-control rounded-0 rounded-end-pill ps-3 pe-5"
            style="height: 40px;"
            placeholder="Search products, brands, categories..."
        >

        <button
            type="submit"
            class="btn position-absolute top-50 translate-middle-y"
            style="right:5px; background:#D4A373; color:white; height:35px; width:35px; border-radius:50%; padding:0;"
        >
            <i class="fa fa-search"></i>
        </button>
    </div>

</form>


        <!-- Cart -->
       @php
$cartCount = session('cart') ? count(session('cart')) : 0;
$wishlistCount = auth()->check() ? auth()->user()->wishlist()->count() : 0;
@endphp

<!-- Cart -->
<!-- Cart -->
<a class="premium-icon position-relative"
   href="{{ route('frontend.shopping.cart') }}"
   onclick="document.querySelector('.js-show-cart').click();"
   style="margin-right: 8px;">
    <i class="zmdi zmdi-shopping-cart color-white" style="font-size: 25px;"></i>
    @if($cartCount > 0)
      <span class="premium-cart-badge" style="font-size: 12px; padding: 2px 6px; min-width: 20px; height: 20px;">
        {{ $cartCount }}
      </span>
    @endif
</a>

<!-- Wishlist -->
<a href="{{ route('user.wishlist') }}"
   class="premium-icon position-relative wish-btn"
   data-product=""
   style="margin-right: 8px;">
    <i class="zmdi zmdi-favorite {{ $wishlistCount > 0 ? 'text-red' : '' }}" style="font-size: 25px;"></i>
    @if($wishlistCount > 0)
      <span class="premium-cart-badge" style="font-size: 12px; padding: 2px 6px; min-width: 20px; height: 20px;">
        {{ $wishlistCount }}
      </span>
    @endif
</a>

</a>
@auth
    @php
        $initial = strtoupper(substr(auth()->user()->name, 0, 1));
    @endphp

    <div class="dropdown">
        <button class="premium-user-btn d-flex justify-content-center align-items-center"
                data-bs-toggle="dropdown"
                style="width:35px; height:35px; border-radius:50%; background:#D4A373; color:white; font-weight:600; font-size:18px; border:none;">
            {{ $initial }}
        </button>

        <ul class="dropdown-menu dropdown-menu-end premium-dropdown">
            <li><a class="dropdown-item" href="{{ url('/profile') }}">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button class="dropdown-item">Logout</button>
                </form>
            </li>
        </ul>
    </div>
@else
    <a href="{{ route('login') }}" class="premium-btn-login">Login</a>
    <a href="{{ route('register') }}" class="premium-btn-register">Register</a>
@endauth

      </div>
    </div>
  </nav>
</header>

<style>
/* ===== PREMIUM NAVBAR CSS ===== */
.premium-header { backdrop-filter: blur(12px); background: rgba(0,0,0,0.75); border-bottom: 1px solid rgba(255,255,255,0.05); }
.premium-navbar { padding: 10px 0; }

.premium-logo img { height: 42px; }

.premium-menu .nav-link {
  color: #eee !important;
  font-weight: 500;
  padding: 8px 18px !important;
  transition: all 0.3s ease;
}
.premium-menu .nav-link:hover,
.premium-menu .nav-link.active { color: #D4A373 !important; }

.premium-user-btn {
  background: none; border: 1px solid #555; color: #fff;
  padding: 5px 12px; border-radius: 4px; font-size: 14px;
}
.premium-user-btn:hover { border-color: #D4A373; color: #D4A373; }

.premium-btn-login, .premium-btn-register {
  border: 1px solid #D4A373; padding: 5px 12px; border-radius: 4px;
  color: #fff; text-decoration: none; font-size: 14px;
}
.premium-btn-login:hover, .premium-btn-register:hover { background: #D4A373; color: #000; }

.premium-icon { color: #eee; font-size: 18px; transition: 0.3s; margin-left: 12px; cursor: pointer; }
.premium-icon:hover { color: #D4A373; }

.premium-cart-badge {
  background: #D4A373; color: #ffffff;
  font-size: 10px; padding: 2px 6px;
  border-radius: 50%; position: absolute; top: -6px; right: -6px;
}

.premium-dropdown { background: #1f1f1f; border: 1px solid #333; }
.premium-dropdown .dropdown-item { color: #fff; }
.premium-dropdown .dropdown-item:hover { background: #D4A373; color: #000; }

@media(max-width: 991px){
    .premium-navbar { padding: 8px 0; }
    .premium-menu {
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }
    .premium-menu .nav-link {
        text-align: center;
        justify-content: center;
        padding: 12px 0 !important;
    }
    .premium-navbar .premium-logo img {
        height: 40px;
    }
    .navbar-icons {
        gap: 10px;
    }
}

@media(max-width: 576px){
    .premium-navbar {
        padding: 6px 0;
    }
    .premium-menu .nav-link {
        font-size: 14px;
        padding: 10px 0 !important;
    }
    .premium-navbar .premium-logo img {
        height: 35px;
    }
}
.premium-navbar{
    background: black;
    color: #ffffff;
}
</style>

