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
            <?= form_open_multipart('admin/products/create', ['id' => 'upload-form', 'class' => 'container mt-4']) ?>

            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Product Name"
                    data-pristine-required
                    data-pristine-required-message="Name required"
                    data-pristine-minlength="3"
                    data-pristine-minlength-message="Name minimal 3 characters">
            </div>

            <div class="mb-3">
                <label for="userfile" class="form-label">Choose file (JPG,PNG,Webp - Max 5MB):</label>
                <input
                    type="file"
                    name="userfile"
                    id="userfile"
                    class="form-control mt-2"
                    data-pristine-required-message="Please choose file to upload" />
            </div>
            <div id="file-error" class="text-danger mt-2" style="display: none;">
            </div>

            <div class="mt-3">
                <img
                    id="file-preview"
                    class="w-100 border rounded shadow-sm"
                    height="500px"
                    style="display: none;">
                </img>
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

<?= $this->section('script') ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var form = document.getElementById("upload-form");

        var pristine = new Pristine(form, {
            classTo: 'mb-3',
            errorClass: 'is-invalid',
            successClass: 'is-valid',
            errorTextParent: 'mb-3',
            errorTextTag: 'div',
            errorTextClass: 'text-danger',
        });

        var fileInput = document.getElementById('userfile');
        var fileError = document.getElementById('file-error');
        var filePreview = document.getElementById('file-preview');

        var maxSize = 5 * 1024 * 1024;
        var allowedTypes = ['image/jpg', 'image/png', 'image/webp'];
        var allowedExtensions = ['.jpg', '.png', '.webp'];
        var minWidth = 600;
        var minHeight = 600;

        pristine.addValidator(fileInput, function(value) {
            filePreview.style.display = 'none';

            if (fileInput.files.length === 0) {
                fileError.textContent = "Please choose a file to upload";
                fileError.style.display = 'block';
                return false;
            }

            var file = fileInput.files[0];
            var validType = allowedTypes.includes(file.type);

            if (!validType) {
                var fileName = file.name.toLowerCase();
                validType = allowedExtensions.some(function(ext) {
                    return fileName.endsWith(ext);
                });
            }

            if (!validType) {
                fileError.textContent = 'File format should be JPG, PNG, or WebP';
                fileError.style.display = 'block';
                return false;
            }

            if (file.size > maxSize) {
                fileError.textContent = "File size should not be more than 5 MB";
                fileError.style.display = 'block';
                return false;
            }

            const img = new Image();
            img.src = URL.createObjectURL(file); // Membuat URL sementara untuk gambar

            var reader = new FileReader();
            reader.onload = function(e) {
                img.onload = function() {
                    const minWidth = 600;
                    const minHeight = 600;

                    if (img.width < minWidth || img.height < minHeight) {
                        fileError.textContent = "File dimension should be at least 600x600 pixels.";
                        fileError.style.display = "block";
                        return;
                    } else {
                        filePreview.src = e.target.result;
                        filePreview.style.display = 'block';
                        fileError.style.display = "none";
                        URL.revokeObjectURL(img.src); // Hapus URL sementara
                    }
                };
            }
            reader.readAsDataURL(file);
            return true;
        }, "", 5, false);


        form.addEventListener('submit', function(e) {
            var valid = pristine.validate();
            if (!valid) {
                e.preventDefault();
            }
        });


        fileInput.addEventListener('change', function() {
            fileError.style.display = 'none';
            fileError.style.display = 'none';
            pristine.validate(fileInput);
        });
    });
</script>

<?= $this->endSection() ?>