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
        <img src="{{ asset('frontend/images/icons/logo.01.png') }}" alt="Logo">
      </a>

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
        @auth
        <div class="dropdown">
          <button class="premium-user-btn" data-bs-toggle="dropdown">
            <i class="fa fa-user-circle"></i> {{ Auth::user()->name }}
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


        <!-- Search -->
        <!-- Search Icon -->
<!-- Search Icon -->
<a class="premium-icon" id="openSearch">
  <i class="zmdi zmdi-search"></i>
</a>

<!-- Search Modal -->
<div id="searchModal" class="search-modal">
  <div class="search-box">
    <form id="searchForm" action="/search" method="GET" class="search-form">
      <input type="text" id="searchInput" name="query" placeholder="Search for products..." autocomplete="off">
      <button type="submit" class="search-btn"><i class="zmdi zmdi-search"></i></button>
      <button type="button" id="closeSearch" class="close-btn"><i class="zmdi zmdi-close"></i></button>
    </form>
    <div id="searchResults" class="search-results"></div>
  </div>
</div>

<script>
const openBtn = document.getElementById('openSearch');
const closeBtn = document.getElementById('closeSearch');
const modal = document.getElementById('searchModal');
const input = document.getElementById('searchInput');
const resultsBox = document.getElementById('searchResults');
const form = document.getElementById('searchForm');

// Open search
openBtn.addEventListener('click', () => {
  modal.style.display = 'flex';
  document.body.style.overflow = 'hidden';
  input.focus();
});

// Close search
closeBtn.addEventListener('click', () => {
  modal.style.display = 'none';
  document.body.style.overflow = 'auto';
  resultsBox.style.display = 'none';
});

// Live search
input.addEventListener('input', async function() {
  const query = this.value.trim();
  if (query.length < 2) {
    resultsBox.style.display = 'none';
    return;
  }

  const response = await fetch(`/search?query=${encodeURIComponent(query)}`);
  const products = await response.json();

  if (products.length) {
    resultsBox.innerHTML = products.map(p => `
      <div class="search-result-item" onclick="window.location='/product/${p.id}'">${p.name}</div>
    `).join('');
    resultsBox.style.display = 'block';
  } else {
    resultsBox.innerHTML = `<div class="search-result-item">No results found</div>`;
    resultsBox.style.display = 'block';
  }
});
</script>


        <!-- Cart -->
       @php
$cartCount = session('cart') ? count(session('cart')) : 0;
$wishlistCount = auth()->check() ? auth()->user()->wishlist()->count() : 0;
@endphp

<!-- Cart -->
<a class="premium-icon position-relative" href="{{ route('frontend.shopping.cart') }}" onclick="document.querySelector('.js-show-cart').click();">
    <i class="zmdi zmdi-shopping-cart color-white"></i>
    @if($cartCount > 0)
    <span class="premium-cart-badge">{{ $cartCount }}</span>
    @endif
</a>

<!-- Wishlist -->
<a href="{{route("user.wishlist")}}" class="premium-icon position-relative wish-btn" data-product="">
    <i class="zmdi zmdi-favorite {{ $wishlistCount > 0 ? 'text-red' : '' }}"></i>
    @if($wishlistCount > 0)
    <span class="premium-cart-badge">{{ $wishlistCount }}</span>
    @endif
</a>

      </div>
    </div>
  </nav>
</header>

<style>
   /* --- SEARCH OVERLAY --- */
.search-modal {
  position: fixed;
  inset: 0;
  background: rgba(255,255,255,0.97);
  display: none;
  justify-content: center;
  align-items: flex-start;
  z-index: 999999;
  padding-top: 120px;
  animation: fadeIn .3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* --- SEARCH BOX --- */
.search-box {
  width: 90%;
  max-width: 720px;
  text-align: center;
}

.search-form {
  position: relative;
  display: flex;
  align-items: center;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 50px;
  padding: 10px 20px;
  box-shadow: 0 5px 25px rgba(0,0,0,0.08);
}

.search-form input {
  flex: 1;
  border: none;
  outline: none;
  font-size: 16px;
  color: #222;
  background: transparent;
  padding: 8px;
}

.search-btn {
  background: #D4A373;
  border: none;
  color: #fff;
  font-size: 18px;
  padding: 8px 16px;
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.25s ease;
}

.search-btn:hover {
  transform: scale(1.05);
  background: #c59264;
}

.close-btn {
  background: none;
  border: none;
  color: #666;
  font-size: 20px;
  margin-left: 10px;
  cursor: pointer;
}

.close-btn:hover {
  color: #111;
}

/* --- RESULTS --- */
.search-results {
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 8px 35px rgba(0,0,0,0.08);
  margin-top: 20px;
  text-align: left;
  display: none;
  overflow: hidden;
}

.search-result-item {
  padding: 14px 20px;
  border-bottom: 1px solid #eee;
  cursor: pointer;
  transition: all .2s ease;
}

.search-result-item:hover {
  background: #f9f9f9;
}

@media (max-width: 576px) {
  .search-box { width: 95%; }
  .search-form { padding: 8px 14px; }
  .search-btn { padding: 6px 12px; font-size: 16px; }
}

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

