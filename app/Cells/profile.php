<div class="card-body">
    <p><strong>Name:</strong> <?= esc($this->userData['name']) ?></p>
    <p><strong>Email:</strong> <?= esc($this->userData['email']) ?></p>
    <p><strong>Registered at:</strong> <?= esc($this->userData['created_at']) ?></p>
    <p><strong>Status:</strong>
        <?php if ($this->userData['account_status'] == 'Active'): ?>
            <span class="badge bg-success"><?= htmlspecialchars($this->userData['account_status'], ENT_QUOTES, 'UTF-8') ?></span>
        <?php else: ?>
            <span class="badge bg-danger"><?= htmlspecialchars($this->userData['account_status'], ENT_QUOTES, 'UTF-8') ?></span>
        <?php endif; ?>
    </p>
    <p><strong>Role:</strong>
        <?php
        $groupModel = new \Myth\Auth\Models\GroupModel();
        $groups = $groupModel->getGroupsForUser($this->userData['user_id']);
        foreach ($groups as $group) {
            echo '<span class="badge bg-info me-1">' . $group['name'] . '</span>';
        }
        ?>
</div>