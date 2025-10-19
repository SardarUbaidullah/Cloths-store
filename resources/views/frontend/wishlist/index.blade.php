@extends('frontend.layouts.main')
@section('main-container')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #ffffff;
            color: #000000;
            line-height: 1.6;
        }

        .wishlist-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 50px;
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 300;
            letter-spacing: 2px;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .page-header h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 2px;
            background-color: #000000;
        }

        .page-header p {
            font-size: 1rem;
            color: #333;
            margin-top: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .wishlist-stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
            opacity: 0;
            animation: fadeIn 0.8s ease 0.3s forwards;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 300;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .wishlist-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            opacity: 0;
            animation: fadeIn 0.8s ease 0.5s forwards;
        }

        .sort-options select {
            padding: 8px 15px;
            border: 1px solid #000000;
            background-color: white;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sort-options select:hover {
            background-color: #f5f5f5;
        }

        .action-buttons button {
            padding: 10px 20px;
            background-color: white;
            border: 1px solid #000000;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            margin-left: 10px;
        }

        .action-buttons button:hover {
            background-color: #000000;
            color: white;
        }

        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .wishlist-item {
            background-color: white;
            border: 1px solid #e0e0e0;
            overflow: hidden;
            position: relative;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
            transition: all 0.3s ease;
        }

        .wishlist-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .item-image {
            position: relative;
            overflow: hidden;
            height: 300px;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .wishlist-item:hover .item-image img {
            transform: scale(1.05);
        }

        .item-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            flex-direction: column;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .wishlist-item:hover .item-actions {
            opacity: 1;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: white;
            border: 1px solid #000000;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background-color: #000000;
            color: white;
        }

        .item-details {
            padding: 20px;
        }

        .item-category {
            font-size: 0.8rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .item-name {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .item-price {
            font-size: 1.2rem;
            font-weight: 400;
            margin-bottom: 15px;
        }

        .item-status {
            display: inline-block;
            padding: 5px 10px;
            font-size: 0.8rem;
            border: 1px solid #000000;
            margin-bottom: 15px;
        }

        .item-buttons {
            display: flex;
            justify-content: space-between;
        }

        .item-buttons button {
            padding: 8px 15px;
            background-color: white;
            border: 1px solid #000000;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            flex: 1;
            margin: 0 5px;
        }

        .item-buttons button:first-child {
            margin-left: 0;
        }

        .item-buttons button:last-child {
            margin-right: 0;
        }

        .item-buttons button:hover {
            background-color: #000000;
            color: white;
        }

        .empty-wishlist {
            text-align: center;
            padding: 60px 20px;
            opacity: 0;
            animation: fadeIn 1s ease 0.7s forwards;
        }

        .empty-wishlist-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .empty-wishlist h2 {
            font-size: 1.8rem;
            font-weight: 300;
            margin-bottom: 15px;
        }

        .empty-wishlist p {
            max-width: 500px;
            margin: 0 auto 30px;
            color: #555;
        }

        .empty-wishlist button {
            padding: 12px 30px;
            background-color: white;
            border: 1px solid #000000;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .empty-wishlist button:hover {
            background-color: #000000;
            color: white;
        }

        .wishlist-footer {
            margin-top: 60px;
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #e0e0e0;
            opacity: 0;
            animation: fadeIn 0.8s ease 1s forwards;
        }

        .wishlist-footer p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .wishlist-stats {
                flex-direction: column;
                gap: 20px;
            }

            .wishlist-controls {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }

            .wishlist-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
    </style>
<div class="wishlist-container">
    <header class="page-header">
        <h1>Your Wishlist</h1>
        <p>Save your favorite items for later. Your personal collection of style inspirations.</p>
    </header>
@if($wishlistItems->count() > 0)
    <div class="wishlist-stats">
        <div class="stat-item">
            <div class="stat-number" id="item-count">{{ $wishlistItems->count() }}</div>
            <div class="stat-label">Items</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" id="total-value">
                ${{ number_format($wishlistItems->sum(fn($i) => $i->product->price), 2) }}
            </div>
            <div class="stat-label">Total Value</div>
        </div>

    </div>



    <div class="wishlist-grid" id="wishlist-items">
        @foreach($wishlistItems as $item)
            <div class="wishlist-item" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="item-image">
                    <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : asset('frontend/images/product-placeholder.jpg') }}" alt="{{ $item->product->name }}">

                </div>
                <div class="item-details">
                    <div class="item-category">{{ $item->product->category->name ?? 'Uncategorized' }}</div>
                    <h3 class="item-name">{{ $item->product->name }}</h3>
                    <div class="item-price">${{ number_format($item->product->price,2) }}</div>
                    <div class="item-status">{{ $item->product->stock_status ?? 'In Stock' }}</div>
                    <div class="item-buttons">
                        <form action="{{ route('frontend.add.to.cart.direct') }}" method="POST" style="flex:1; margin-right:5px;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit">Add to Cart</button>
                        </form>
                        <a href="{{ route('frontend.product-detail', $item->product->id) }}" class="view-details" style="flex:1; margin-left:5px; display:inline-block; text-align:center; text-decoration:none; padding:8px 15px; border:1px solid #000;">View Details</a>
                    </div>
                </div>
            </div>



        @endforeach
    </div>
 @else
    <div class="empty-wishlist">
        <img src="{{ asset('frontend/images/wish.png') }}" alt="Empty Wishlist">
        <h3>No Items in Wishlist</h3>
        <p>Your favorite products will appear here.</p>
        <a href="{{ url('/') }}">Continue Shopping</a>
    </div>
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove from wishlist ajax
    document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.id;
            const itemCard = this.closest('.wishlist-item');

            fetch("{{ route('frontend.wishlist.toggle') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'removed') {
                    itemCard.style.opacity = 0;
                    itemCard.style.transform = 'scale(0.9)';
                    setTimeout(() => itemCard.remove(), 300);
                }
            });
        });
    });

    // Save for later visual feedback
    document.querySelectorAll('.save-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            this.textContent = '✓';
            this.style.backgroundColor = '#000';
            this.style.color = '#fff';
            setTimeout(() => { this.textContent = '⚡'; this.style.backgroundColor=''; this.style.color=''; }, 1000);
        });
    });

    // Clear all wishlist
    document.getElementById('clear-all')?.addEventListener('click', function() {
        if(confirm('Are you sure you want to clear your entire wishlist?')) {
            document.querySelectorAll('.wishlist-item').forEach(item => {
                item.style.opacity = 0;
                item.style.transform = 'translateY(20px)';
            });
            setTimeout(() => location.reload(), 500);
        }
    });
});
</script>

@endsection
