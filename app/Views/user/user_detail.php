<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-box"></i> Detail User</h4>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong><i class="bi bi-tag"></i> Nama:</strong> <?= esc($user->getFullName())  ?>
                </li>
                <li class="list-group-item">
                    <strong><i class="bi bi-tag"></i> Email:</strong> <?= esc($user->email)  ?>
                </li>
                <li class="list-group-item">
                    <strong><i class="bi bi-currency-dollar"></i> Username:</strong> <?= esc($user->username)  ?>
                </li>
                <li class="list-group-item">
                    <strong><i class="bi bi-tags"></i> Role:</strong> <?= esc($user->role) ?>
                </li>
                <li class="list-group-item">
                    <strong><i class="bi bi-tags"></i> Status:</strong> <?= esc($user->status) ?>
                </li>
                <li class="list-group-item">
                    <strong><i class="bi bi-tags"></i> Last Login:</strong> <?= esc($user->getFormattedLastLogin()) ?? 'This user has not logged in' ?>
                </li>
            </ul>
        </div>
        <div class="card-footer text-center">
            <a href="<?= site_url('admin/users') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>