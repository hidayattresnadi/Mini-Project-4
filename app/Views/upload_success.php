<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content'); ?>
<h3>Your file was successfully uploaded!</h3>

<ul>
    <li>name: <?= esc($uploaded_fileinfo->getBasename()) ?></li>
    <li>size: <?= esc($uploaded_fileinfo->getSizeByUnit('kb')) ?> KB</li>
    <li>extension: <?= esc($uploaded_fileinfo->guessExtension()) ?></li>
</ul>

<p><?= anchor($baseUrl, 'Upload Another File!') ?></p>
<?= $this->endSection(); ?>