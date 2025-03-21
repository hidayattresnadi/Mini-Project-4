<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-box"></i> Product Detail</h4>
        </div>
        <div class="card-body">
            <div style="text-align: center; margin-bottom: 15px;">
                <img src="<?= base_url($product->medium) ?>" alt="Product Thumbnail" style="max-width: 500px; border-radius: 5px; border: 1px solid #ddd;">
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong><i class="bi bi-tag"></i> Name:</strong> <?= esc($product->name) ?>
                </li>
                <li class="list-group-item">
                    <strong><i class="bi bi-currency-dollar"></i> Price:</strong> <?= $product->getFormattedPrice() ?>
                </li>
                <li class="list-group-item">
                    <strong><i class="bi bi-box-seam"></i> Stock:</strong> <?= esc($product->stock) ?>
                </li>
                <li class="list-group-item">
                    <strong><i class="bi bi-tags"></i> Category:</strong> <?= esc($product->category) ?>
                </li>
                <li class="list-group-item">
                    <strong><i class="bi bi-tags"></i> Description:</strong> <?= esc($product->description) ?>
                </li>
                <li class="list-group-item">
                    <strong><i class="bi bi-tags"></i> Status:</strong> <?= esc($product->getStatus()) ?>
                </li>
            </ul>
        </div>
        <div class="card-footer text-center">
            <a href="<?= site_url('admin/products') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>