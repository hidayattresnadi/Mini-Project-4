<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2 class="text-center mb-4"><?= $title ?></h2>
    <div class="card mb-4">
        <div class="card-body">
            <form class="row g-3 align-items-end" method="get" action="<?= site_url('report/products') ?>">
                <div class="col-md-4">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search"
                        placeholder="Search by Category" value="<?= $filters['search'] ?? '' ?>">
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Report Preview</button>
                    <a href="<?= site_url('report/products') ?>" class="btn btn-secondary me-2">Reset</a>
                    <a href="<?= site_url('report/productsExcel') . (!empty($filters['search']) ? '?' . http_build_query($filters) : '') ?>" class="btn btn-success">
                        <i class="bi bi-file-excel me-1"></i> Export Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Date Added</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="10" class="text-center">Data Not Found</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($products as $product): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $product->name ?></td>
                                <td><?= $product->category ?></td>
                                <td><?= $product->price ?></td>
                                <td><?= $product->stock ?></td>
                                <td><?= $product->created_at ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<?= $this->endSection() ?>