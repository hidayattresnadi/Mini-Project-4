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
            <h4 class="mb-0">Add Role</h4>
        </div>
        <div class="card-body">
            <form id="formData" method="post" action="<?= site_url('admin/roles/create') ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Group Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter Group Name"
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

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-50">
                        Add Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>