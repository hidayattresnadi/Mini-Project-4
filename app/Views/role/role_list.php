<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1><?= $title; ?></h1>

    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message'); ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="mb-3 mt-4">
        <a href="<?= base_url('/admin/roles/create'); ?>" class="btn btn-primary">Add New Role</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($roles as $role) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $role->name; ?></td>
                        <td><?= $role->description; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>