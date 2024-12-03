<?php
include APP_DIR . 'views/templates/header.php';
?>

<body>

    <main class="mt-3 pt-3">
        <div class="container">
            <h2 class="fw-bold">Recent Activity</h2>
        </div>
        <div class="container">
            <!-- Row for the cards -->
            <div class="row ">
                <div class="col mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center w-full fw-bold mb-1"><?= $productCount ?></h3>
                            <p class="card-text w-full text-center mb-1">Qty</p>
                            <h5 class="card-text w-full text-center mb-1">Total Products</h5>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center w-full fw-bold mb-1">100</h3>
                            <p class="card-text w-full text-center mb-1">Qty</p>
                            <h5 class="card-text w-full text-center mb-1">Total Sales</h5>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="col mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center w-full fw-bold mb-1">100</h3>
                            <p class="card-text w-full text-center mb-1">Qty</p>
                            <h5 class="card-text w-full text-center mb-1">New Items</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-4">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-start w-full fw-bold mb-1">Sales</h4>
                            <canvas id="salesChart" style="min-width: 10rem;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-start w-full fw-bold mb-1">Top Item Categories</h4>
                            <!-- Canvas for Categories Chart (Pie Chart) -->
                            <canvas id="categoriesChart"></canvas>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="container ">
            <div class="row ">
                <div style="width: 40%">
                    <div class="card">
                        <div class="card-body" style="height: 12rem">
                            <h4 class="card-title text-start w-full fw-bold mb-1">Stock Numbers</h4>
                        </div>
                    </div>
                </div>
                <div style="width: 60%">
                    <div class="card">
                        <div class="card-body" style="height: 12rem">
                            <h4 class="card-title text-start w-full fw-bold mb-1">Stores List</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Fake sales data
        const salesData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Sales ($)',
                data: [1500, 1800, 1300, 2200, 2500, 3000, 3500], // Fake sales data
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 1
            }]
        };

        // Create the chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar', // You can change this to 'bar' for a bar chart
            data: salesData,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Sales Performance Over Time'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return `$${tooltipItem.raw.toFixed(2)}`; // Format as currency
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Fake categories data for demonstration
        const categoriesData = {
            labels: ['Category A', 'Category B', 'Category C', 'Category D'],
            datasets: [{
                data: [30, 25, 20, 25],  // Example data
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#FF5722'],
                hoverBackgroundColor: ['#FF5169', '#36A1D8', '#FFB83D', '#FF3B20']
            }]
        };

        const categCtx = document.getElementById('categoriesChart').getContext('2d');

        // Create the Pie chart with smaller size
        new Chart(categCtx, {
            type: 'pie',
            data: categoriesData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + '%'; // Adding percentage to label
                            }
                        }
                    }
                },
                aspectRatio: 1,  // Ensures it's a square, adjust as necessary
            }
        });
    </script>

</body>

</html>