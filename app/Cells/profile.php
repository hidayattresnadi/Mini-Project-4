<div class="card-body">
    <p><strong>Name:</strong> <?= esc($this->userData['name']) ?></p>
    <p><strong>Email:</strong> <?= esc($this->userData['email']) ?></p>
    <p><strong>Birthdate:</strong> <?= esc($this->userData['birthdate']) ?></p>
    <p><strong>Status:</strong>
        <?php if ($this->userData['account_status'] == 'Active'): ?>
            <span class="badge bg-success"><?= htmlspecialchars($this->userData['account_status'], ENT_QUOTES, 'UTF-8') ?></span>
        <?php else: ?>
            <span class="badge bg-danger"><?= htmlspecialchars($this->userData['account_status'], ENT_QUOTES, 'UTF-8') ?></span>
        <?php endif; ?>
    </p>

</div>