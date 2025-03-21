<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>

<?php if (session()->has('errors')): ?>
    <ul class="text-danger">
        <?php foreach (session('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<?= form_open_multipart('admin/products/' . $product_id . '/upload_product_image', ['id' => 'upload-form', 'class' => 'container mt-4']) ?>
<div class="card shadow-sm p-4">
    <h4 class="mb-3">Upload Product Image</h4>

    <div class="form-group">
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

    <button type="submit" class="btn btn-primary mt-3 w-50 m-auto">Upload</button>
</div>
</form>
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
        }, "Validasi file gagal", 5, false);


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


<!-- var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e) {
                const img = new Image();
                img.src = event.target.result;
                img.onload = function() {
                    if (img.width < minWidth || img.height < minHeight) {
                        fileError.textContent = "Image dimensions should be at least 600x600 pixels.";
                        fileError.style.display = "block";
                        return false;
                    } else {
                        fileError.style.display = "none";
                    }
                };
                filePreview.src = e.target.result;
                filePreview.style.display = 'block';
            } -->