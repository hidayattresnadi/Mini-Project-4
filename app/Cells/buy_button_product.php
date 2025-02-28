<?php if ($this->stock > 0): ?>
    <button class="btn btn-primary">Buy Now</button>
<?php else: ?>
    <button class="btn btn-secondary" disabled>Buy Now</button>
<?php endif; ?>