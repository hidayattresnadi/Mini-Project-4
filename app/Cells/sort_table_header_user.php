<a href="<?= $params->getSortUrl($tableField, $baseUrl) ?>"
    class="<?= $style ?>">
    <?= $tableTitleHeader  ?>
    <?= $params->isSortedBy($tableField) ? ($params->getSortDirection() == 'asc' ? '↑' : '↓') : '↓' ?>
</a>