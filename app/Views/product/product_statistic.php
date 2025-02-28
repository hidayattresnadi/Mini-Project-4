<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <h3>Product Sales & Inventory Statistics</h3>
    <canvas id="salesChart"></canvas>
    <canvas id="inventoryChart"></canvas>
</div>

<script>
    function fetchStatistics() {
        $.ajax({
            url: "<?= site_url('product-statistics/getStatistics') ?>",
            type: "GET",
            dataType: "json",
            success: function(data) {
                updateSalesChart(data.sales_trends);
                updateInventoryChart(data.inventory_levels);
            }
        });
    }

    function updateSalesChart(salesData) {
        let labels = salesData.map(item => item.month);
        let sales = salesData.map(item => item.sales);

        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales Trends',
                    data: sales,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            }
        });
    }

    function updateInventoryChart(inventoryData) {
        let labels = inventoryData.map(item => item.product);
        let stock = inventoryData.map(item => item.stock);

        new Chart(document.getElementById('inventoryChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Inventory Levels',
                    data: stock,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }]
            }
        });
    }

    // Fetch data every 1 hour
    fetchStatistics();
    setInterval(fetchStatistics, 3600000);
</script>

<?= $this->endSection() ?>