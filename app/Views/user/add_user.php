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
            <h4 class="mb-0">Add User</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?= site_url('admin/users/store') ?>">

                <div class="mb-3">
                    <label for="full_name" class="form-label">Name</label>
                    <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Enter name">
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter username">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter email">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select">
                        <option value="">-- Select Role --</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Active</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">-- Select Status --</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-50">
                        Add User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>