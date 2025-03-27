<h5 class="me-3">Admin Menu</h5>
<ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link text-white" href="<?= route_to('dashboard') ?>">Dashboard</a></li>
    <li class="nav-item"><a class="nav-link text-white" href="<?= route_to('admin_products') ?>">Products</a></li>
    <?php if ((in_groups('product manager'))) : ?>
        <li class="nav-item"><a class="nav-link text-white" href="<?= route_to('report/products') ?>">Report Products</a></li>
    <?php endif; ?>
    <li class="nav-item"><a class="nav-link text-white" href="<?= route_to('product_statistic') ?>">Statistics</a></li>

    <?php if ((in_groups('administrator'))) : ?>
        <li class="nav-item"><a class="nav-link text-white" href="<?= route_to('customers') ?>">Customers</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="<?= route_to('user_dashboard') ?>">Customer Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="<?= route_to('users') ?>">Users</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="<?= route_to('report/users') ?>">Report Users</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="<?= route_to('roles') ?>">Roles</a></li>
    <?php endif; ?>

</ul>