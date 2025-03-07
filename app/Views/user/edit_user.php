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
            <h4 class="mb-0">Edit User</h4>
        </div>
        <div class="card-body">
            <form id="formData" method="post" action="<?= site_url('admin/users/update/' . $user->id) ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-3">
                    <label for="full_name" class="form-label">Name</label>
                    <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Enter name" value="<?= esc($user->full_name) ?>"
                        data-pristine-required
                        data-pristine-required-message="Name required"
                        data-pristine-minlength="3"
                        data-pristine-minlength-message="Name minimal 3 characters">
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" value="<?= esc($user->username) ?>"
                        data-pristine-required
                        data-pristine-required-message="Username required"
                        data-pristine-minlength="3"
                        data-pristine-minlength-message="Username minimal 3 characters">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter email" value="<?= esc($user->email) ?>"
                        data-pristine-required
                        data-pristine-required-message="Email required"
                        data-pristine-email
                        data-pristine-email-message="Email format is not valid">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter new password"
                        data-pristine-required
                        data-pristine-required-message="Password required"
                        data-pristine-minlength="8"
                        data-pristine-minlength-message="Password minimal 8 characters">
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-select" required
                        data-pristine-required
                        data-pristine-required-message="Please Select Role">
                        <option value="">-- Select Role --</option>
                        <option value="admin" <?= ($user->role == "admin") ? 'selected' : '' ?>>Admin</option>
                        <option value="user" <?= ($user->role == "user") ? 'selected' : '' ?>>User</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Active</label>
                    <select id="status" name="status" class="form-select" required
                        data-pristine-required
                        data-pristine-required-message="Please select Status">
                        <option value="">-- Select Status --</option>
                        <option value="active" <?= ($user->status == "active") ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= ($user->status == "inactive") ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-50">
                        Edit User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection() ?>