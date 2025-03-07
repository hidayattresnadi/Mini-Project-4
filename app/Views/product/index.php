<?= $this->extend('layouts/public_layout') ?>

<?= $this->section('content') ?>

<?= $content ?? '' ?>
<?= $pager->links('products', 'custom_pager') ?>

<?= $this->endSection() ?>