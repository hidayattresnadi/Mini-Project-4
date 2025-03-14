<?= $this->extend('layouts/admin_layout') ?>


<?= $this->section('content') ?>
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-sm col-md-6 ">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add User Role</h4>
        </div>
        <div class="card-body">
            <form id="formData" method="post" action="<?= site_url('/addUserToGroup') ?>">
                <div class="mb-3">
                    <label for="userId" class="form-label">User Id</label>
                    <input type="number" id="userId" name="userId" class="form-control" placeholder="Enter UserId">
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <input type="text" id="role" name="role" class="form-control" placeholder="Enter Role">
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success w-75">
                        Add User Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>