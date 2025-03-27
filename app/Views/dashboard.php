<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <!-- Pie Chart: Product distribution by category -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="gradeChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bar Chart: Top 5 Categories with Most Product -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="creditChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Line Chart: Product Growth -->
        <div class="mt-4">
            <div class="card">
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="gpaChart" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->section('scriptChart') ?>
<script>
    const productsByCategory = <?= $productsByCategory ?>;
    const totalProducts = <?= $getTopFiveProducts ?>;
    const productGrowthMonth = <?= $productGrowthMonth ?>;
    const year = new Date().getFullYear();
    const gradeChart = new Chart(
        document.getElementById('gradeChart'), {
            type: 'pie',
            data: productsByCategory,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Product Distribution by Categories'
                    },
                    legend: {
                        position: 'right'
                    }
                }
            }
        }
    );
    const creditChart = new Chart(
        document.getElementById('creditChart'), {
            type: 'bar',
            data: totalProducts,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Products'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Category'
                        },
                        ticks: {
                            autoSkip: false, // Jangan otomatis skip label
                            maxRotation: 0, // Atur rotasi maksimal (0 = horizontal)
                            minRotation: 0 // Atur rotasi minimal
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Top 5 Total Products by Category'
                    }
                },
            }
        }
    );
    const gpaChart = new Chart(
        document.getElementById('gpaChart'), {
            type: 'line',
            data: productGrowthMonth,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        min: 0,
                        max: 20,
                        title: {
                            display: true,
                            text: 'Total Products'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        },
                        ticks: {
                            autoSkip: false, // Jangan otomatis skip label
                            maxRotation: 0, // Atur rotasi maksimal (0 = horizontal)
                            minRotation: 0 // Atur rotasi minimal
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: `Product Growth Month ${year}`
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Total Products: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        }
    );
</script>
</script>
<?= $this->endSection() ?>