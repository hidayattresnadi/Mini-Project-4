<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li style="color: red;"><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Product</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?= site_url('admin/products/' . $product->id) ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Product Name" value="<?= esc($product->name) ?>">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description" rows="5" placeholder="Enter description"><?= esc($product->description ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" id="price" name="price" class="form-control" placeholder="Enter Price" step="0.01" value="<?= esc($product->price) ?>">
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" id="stock" name="stock" class="form-control" placeholder="Masukkan stok" value="<?= esc($product->stock) ?>">
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" class="form-select">
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $category): ?>
                            <option <?= ($product->category_id == $category->id) ? 'selected' : '' ?> value="<?= $category->id ?>"><?= $category->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">-- Select Status --</option>
                        <option value="active" <?= ($product->status == "active") ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= ($product->status == "inactive") ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="mb-3 form-check">
                    <input type="hidden" name="is_new" value="0">
                    <input type="checkbox" class="form-check-input" id="is_new" name="is_new" value="1" <?= ($product->is_new ?? false) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_new">Is New</label>
                </div>

                <div class="mb-3 form-check">
                    <input type="hidden" name="is_sale" value="0">
                    <input type="checkbox" class="form-check-input" id="is_sale" name="is_sale" value="1" <?= ($product->is_sale ?? false) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_sale">Is Sale</label>
                </div>


                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-50">
                        Edit Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>