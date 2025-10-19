@php
    $total = 0;
    $cart = session('cart') ?? [];
@endphp

<div class="header-cart-wrapitem w-full">
    @forelse($cart as $key => $item)
        @php $total += $item['price'] * $item['quantity']; @endphp
        <li class="header-cart-item flex-w flex-t m-b-12">
            <div class="header-cart-item-img">
                <img src="{{ $item['image'] }}" alt="IMG">
            </div>

            <div class="header-cart-item-txt p-t-8">
                <span class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                    {{ $item['name'] }}
                </span>

                <span class="header-cart-item-info">
                    {{ $item['quantity'] }} x Rs. {{ number_format($item['price']) }}
                </span>

                @if(!empty($item['custom_fields']) && is_array($item['custom_fields']))
                    @foreach($item['custom_fields'] as $label => $value)
                        @if(!empty($value))
                            <div class="small text-muted">{{ $label }}: {{ $value }}</div>
                        @endif
                    @endforeach
                @endif

                {{-- Remove Button --}}
                <form action="{{ route('cart.remove', $key) }}" method="POST" class="remove-cart-item-form mt-2">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: 0.8rem;">
                        × Remove
                    </button>
                </form>
            </div>
        </li>
    @empty
        <li class="p-2 text-muted text-center">Your cart is empty.</li>
    @endforelse
</div>

{{-- Show total + buttons only if cart has items --}}
@if(count($cart) > 0)
    <div class="header-cart-total w-full p-tb-40">
        Total: Rs. {{ number_format($total) }}

        <div class="header-cart-buttons flex-w w-full">
            <a href="{{ url('/shoping-cart') }}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                View Cart
            </a>
            <a href="{{ url('/checkout') }}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                Check Out
            </a>
        </div>
    </div>
@endif

{{-- JS for Remove --}}
<script>
    function bindRemoveCartEvents() {
        document.querySelectorAll('.remove-cart-item-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        loadCartItems(); // reload sidebar
                    }
                });
            });
        });
    }

function loadCartItems() {
    fetch('/cart-sidebar')
        .then(res => res.text())
        .then(html => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;

            const newWrap = tempDiv.querySelector('.header-cart-wrapitem');
            const newTotal = tempDiv.querySelector('.header-cart-total');

            const currentWrap = document.querySelector('.header-cart-wrapitem');
            const currentTotal = document.querySelector('.header-cart-total');

            if (currentWrap && newWrap) currentWrap.innerHTML = newWrap.innerHTML;
            if (currentTotal && newTotal) currentTotal.innerHTML = newTotal.innerHTML;
        });
}


    document.addEventListener('DOMContentLoaded', bindRemoveCartEvents);
    bindRemoveCartEvents(); // bind now also
</script>
