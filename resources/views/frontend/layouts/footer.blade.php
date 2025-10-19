	<!-- Footer -->
<footer class="site-footer">
    <div class="container footer-container">
        <div class="footer-column">
            <h3>Modern Threads</h3>
            <p>Your one-stop destination for the latest fashion trends. We offer premium quality clothing for men, women, and kids.</p>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-pinterest"></i></a>
            </div>
        </div>

        <div class="footer-column">
            <h3>Quick Links</h3>
            <ul class="footer-links">
                <li><a href="{{route("index")}}">Home</a></li>
                <li><a href="{{url("/about")}}">About Us</a></li>
                <li><a href="{{url("/product")}}">Shop</a></li>
                <li><a href="{{url('/contact')}}">Contact</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h3>Customer Service</h3>
            <ul class="footer-links">
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Shipping Policy</a></li>
                <li><a href="#">Return & Exchange</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Track Your Order</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h3>Contact Info</h3>
            <ul class="footer-links">
                <li><i class="fas fa-map-marker-alt"></i> 123 Fashion Street, New York</li>
                <li><i class="fas fa-phone"></i> +1 234 567 8900</li>
                <li><i class="fas fa-envelope"></i> info@modernthreads.com</li>
                <li><i class="fas fa-clock"></i> Mon-Sat: 9AM - 8PM</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 Designed and developed by . All Rights Reserved.</p>
    </div>
</footer>
<style>
    /* Footer Styling */
.site-footer {
    background: #111;
    color: #ddd;
    padding: 60px 0 20px;
    font-family: 'Poppins', sans-serif;
}

.footer-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 40px;
}

.footer-column h3 {
    font-size: 20px;
    color: #fff;
    margin-bottom: 20px;
    position: relative;
}

.footer-column h3::after {
    content: "";
    display: block;
    width: 50px;
    height: 3px;
    background: #c5a678;
    margin-top: 8px;
}

.footer-column p {
    font-size: 14px;
    line-height: 1.8;
    color: #aaa;
}

.footer-links li {
    margin-bottom: 10px;
    list-style: none;
}

.footer-links a {
    color: #bbb;
    font-size: 14px;
    text-decoration: none;
    transition: 0.3s;
}

.footer-links a:hover {
    color: #fff;
    padding-left: 5px;
}

.social-links a {
    display: inline-block;
    width: 35px;
    height: 35px;
    line-height: 35px;
    margin: 5px;
    text-align: center;
    background: #222;
    color: #c5a678;
    border-radius: 50%;
    transition: 0.3s;
}

.social-links a:hover {
    background: #c5a678;
    color: #111;
    transform: translateY(-3px);
}

.footer-bottom {
    border-top: 1px solid #222;
    text-align: center;
    margin-top: 40px;
    padding-top: 20px;
}

.footer-bottom p {
    font-size: 13px;
    color: #777;
}

/* Responsive */
@media(max-width: 768px) {
    .footer-container {
        text-align: center;
    }
    .social-links a {
        margin: 10px 5px;
    }
}

</style>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>


	<!-- add to cart  -->
	 <!-- Your existing footer HTML -->

{{-- Cart Sidebar Container --}}
<div id="cart-sidebar" class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">Your Cart</span>
            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
            <ul class="header-cart-wrapitem w-full" id="cart-items-list">
                <!-- AJAX-loaded items will go here -->
            </ul>

            <div class="w-full" id="cart-summary-section">
                <!-- Total & buttons will load here -->
            </div>
        </div>
    </div>
</div>

<!-- Your closing </body> and </html> -->


<!--===============================================================================================-->

<!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
 <!-- jQuery -->
<script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
<script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('frontend/vendor/select2/select2.min.js') }}"></script>

<!-- Animsition -->
<script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>

<!-- Perfect Scrollbar -->
<script src="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script>
	$('.js-pscroll').each(function(){
		$(this).css('position','relative');
		$(this).css('overflow','hidden');
		var ps = new PerfectScrollbar(this, {
			wheelSpeed: 1,
			scrollingThreshold: 1000,
			wheelPropagation: false,
		});
		$(window).on('resize', function(){
			ps.update();
		})
	});
</script>

<!-- Magnific Popup -->
<script src="{{ asset('frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>

<!-- SweetAlert -->
<script src="{{asset('frontend/vendor/sweetalert/sweetalert.min.js')}}"></script>


<!-- Daterangepicker -->
<script src="{{ asset('frontend/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/daterangepicker/daterangepicker.js') }}"></script>

<!-- Slick -->
<script src="{{ asset('frontend/vendor/slick/slick.min.js') }}"></script>
<script src="{{ asset('frontend/js/slick-custom.js') }}"></script>

<!-- Parallax -->
<script src="{{ asset('frontend/vendor/parallax100/parallax100.js') }}"></script>
<script>
	$('.parallax100').parallax100();
</script>

<!-- Swiper -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
	const swiper = new Swiper(".mySwiper", {
		slidesPerView: 1,
		spaceBetween: 10,
		loop: true,
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		breakpoints: {
			640: { slidesPerView: 1 },
			768: { slidesPerView: 2 },
			1024: { slidesPerView: 3 },
		},
	});
</script>

<!-- Google Maps -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
<script src="{{ asset('frontend/js/map-custom.js') }}"></script> -->

<!-- Isotope Filtering & Sorting -->
<script src="{{asset('frontend/vendor/isotope/isotope.pkgd.min.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
	const grid = document.querySelector('.row.isotope-grid');
	if (!grid) return; // Prevent error if grid doesn't exist

	const allProducts = Array.from(document.querySelectorAll('.isotope-item'));
	let filteredProducts = [...allProducts];

	let currentCategory = 'all';
	let currentPriceRange = 'all';
	let currentSort = 'default';

	const iso = new Isotope(grid, {
		itemSelector: '.isotope-item',
		layoutMode: 'fitRows',
		hiddenStyle: { opacity: 0, transform: 'scale(0.001)' },
		visibleStyle: { opacity: 1, transform: 'scale(1)' }
	});

	function filterProducts() {
		return allProducts.filter(p => {
			const inCategory = currentCategory === 'all' || p.classList.contains(currentCategory);
			const price = parseFloat(p.getAttribute('data-price'));
			if (currentPriceRange === 'all') return inCategory;
			const [min, max] = currentPriceRange.split('-').map(Number);
			return inCategory && price >= min && price <= max;
		});
	}

	function sortProducts(products) {
		switch (currentSort) {
			case 'low': return products.sort((a, b) => a.dataset.price - b.dataset.price);
			case 'high': return products.sort((a, b) => b.dataset.price - a.dataset.price);
			default: return products.sort((a, b) => allProducts.indexOf(a) - allProducts.indexOf(b));
		}
	}

	function renderProducts(products) {
		grid.innerHTML = '';
		products.forEach(p => grid.appendChild(p));
		iso.reloadItems();
		iso.arrange();
	}

	function applyFilters() {
		const filtered = sortProducts(filterProducts());
		filteredProducts = filtered;
		renderProducts(filteredProducts);
	}

	document.querySelectorAll('.category-filter button').forEach(btn => {
		btn.addEventListener('click', () => {
			currentCategory = btn.dataset.filter;
			document.querySelectorAll('.category-filter button').forEach(b => b.classList.remove('active'));
			btn.classList.add('active');
			applyFilters();
		});
	});

	document.querySelectorAll('.filter-group[aria-label="Price filter"] ul li a').forEach(link => {
		link.addEventListener('click', e => {
			e.preventDefault();
			currentPriceRange = link.dataset.price;
			document.querySelectorAll('.filter-group[aria-label="Price filter"] ul li a').forEach(l => l.classList.remove('active'));
			link.classList.add('active');
			applyFilters();
		});
	});

	document.querySelectorAll('.filter-group[aria-label="Sort options"] ul li a').forEach(link => {
		link.addEventListener('click', e => {
			e.preventDefault();
			currentSort = link.dataset.sort;
			document.querySelectorAll('.filter-group[aria-label="Sort options"] ul li a').forEach(l => l.classList.remove('active'));
			link.classList.add('active');
			applyFilters();
		});
	});

	renderProducts(allProducts);
});

</script>

<!-- Modal Search -->
<script>
	document.querySelector('.js-show-modal-search')?.addEventListener('click', () => {
		document.querySelector('.modal-search-header')?.style.setProperty('display', 'block');
	});

	document.querySelectorAll('.js-hide-modal-search')?.forEach(btn => {
		btn.addEventListener('click', () => {
			document.querySelector('.modal-search-header')?.style.setProperty('display', 'none');
		});
	});
</script>

<!-- Main JS -->
<script src="{{ asset('frontend/js/main.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
