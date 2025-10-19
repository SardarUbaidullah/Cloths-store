@extends('admin.layout.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Admin Dashboard Analytics</h2>

    <div class="row">

        <!-- Monthly Sales Line Graph -->
        <div class="col-md-6 mb-4">
            <div class="card p-3">
                <h5>Monthly Sales (Last 6 Months)</h5>
                <canvas id="salesChart" height="200"></canvas>
            </div>
        </div>

        <!-- Low Stock Products Bar Graph -->
        <div class="col-md-6 mb-4">
            <div class="card p-3">
                <h5>Low Stock Products</h5>
                <canvas id="lowStockChart" height="200"></canvas>
            </div>
        </div>

        <!-- Category-wise Product Pie Chart -->
        <div class="col-md-6 mb-4">
            <div class="card p-3">
                <h5>Category-wise Products</h5>
                <canvas id="categoryChart" height="200"></canvas>
            </div>
        </div>

    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ----- Monthly Sales Line Chart -----
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Products Sold',
                data: @json($sales),
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { responsive: true }
    });

    // ----- Low Stock Products Bar Chart -----
    const lowStockCtx = document.getElementById('lowStockChart').getContext('2d');
    new Chart(lowStockCtx, {
        type: 'bar',
        data: {
            labels: @json($lowStockNames),
            datasets: [{
                label: 'Quantity',
                data: @json($lowStockQty),
                backgroundColor: 'rgba(255, 99, 132, 0.7)'
            }]
        },
        options: { responsive: true }
    });

    // ----- Category-wise Products Pie Chart -----
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'pie',
        data: {
            labels: @json($categoryNames),
            datasets: [{
                data: @json($categoryCounts),
                backgroundColor: [
                    '#FF6384','#36A2EB','#FFCE56','#4BC0C0','#9966FF','#FF9F40'
                ]
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection
