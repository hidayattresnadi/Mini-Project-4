<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h2 class="text-center mb-4"><?= $title ?></h2>
    <div class="card mb-4">
        <div class="card-body">
            <form class="row" action="<?= base_url('report/users') ?>"
                method="post" target="_blank">
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        Generate Report</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>