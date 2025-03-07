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
            <h4 class="mb-0">Add Product</h4>
        </div>
        <div class="card-body">
            <form id="formData" method="post" action="<?= site_url('admin/products/create') ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Product Name"
                        data-pristine-required
                        data-pristine-required-message="Name required"
                        data-pristine-minlength="3"
                        data-pristine-minlength-message="Name minimal 3 characters">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description" rows="5" placeholder="Enter description"
                        data-pristine-required
                        data-pristine-required-message="Description Required"
                        data-pristine-maxlength="255"
                        data-pristine-maxlength-message="Description Cannot exceed 255 characters"></textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" id="price" name="price" class="form-control" placeholder="Enter Price" step="0.01"
                        data-pristine-required
                        data-pristine-required-message="Price required">
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" id="stock" name="stock" class="form-control" placeholder="Masukkan stok"
                        data-pristine-required
                        data-pristine-required-message="Stock required">
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" name="category_id" class="form-select"
                        data-pristine-required
                        data-pristine-required-message="Please select category">
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select"
                        data-pristine-required
                        data-pristine-required-message="Please select product status">
                        <option value="">-- Select Status --</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_new" name="is_new" value="1">
                    <label class="form-check-label" for="is_new">Is New</label>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_sale" name="is_sale" value="1">
                    <label class="form-check-label" for="is_sale">Is Sale</label>
                </div>


                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-50">
                        Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>