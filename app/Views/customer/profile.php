<?php if (in_groups('administrator') || in_groups('product manager')) : ?>
    <?= $this->extend('layouts/admin_layout') ?>
<?php else : ?>
    <?= $this->extend('layouts/public_layout') ?>
<?php endif; ?>

<?= $this->section('content') ?>

<?= $content ?? '' ?>

<?= $this->endSection() ?>