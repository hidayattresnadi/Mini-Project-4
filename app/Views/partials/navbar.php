<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#" id="toggleSidebar">MyApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= route_to('products') ?>">Home</a></li>
                <?php if (logged_in()) : ?>
                    <li class="nav-item"><a class="nav-link" href="<?= route_to('profile') ?>">Profile</a></li>
                <?php endif; ?>

            </ul>
            <?php if (logged_in()) : ?>
                <span class="navbar-text">Welcome, <?= user()->username; ?></span>
            <?php endif; ?>
        </div>
        <li>
            <?php if (logged_in()) : ?>
                <a class="navbar-text text-decoration-none" href="/logout">Logout</a>
            <?php else : ?>
                <a class="navbar-text text-decoration-none" href="/login">Login</a>
            <?php endif; ?>
        </li>
    </div>
</nav>