<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h1 class="mb-4">Product Lists</h1>
    <form method="get" action="<?= site_url('admin/products') ?>" class="form-inline">
        <div class="row g-3 mb-4">
            <!-- Search Input -->
            <div class="col-md-5">
                <label class="form-label mb-1">Search Product</label>
                <div class="input-group">
                    <input type="text" class="form-control" name="search" value="<?= $params->search ?>" placeholder="Search here...">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </div>
            </div>

            <!-- filter Categories -->
            <div class="col-md-2 ms-md-5">
                <label class="form-label mb-1">Filter by Categories</label>
                <select name="category" class="form-control" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category ?>" <?= ($params->category == $category) ? 'selected' : '' ?>><?= ucfirst($category) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- filter Price Range -->
            <div class="col-md-2">
                <label class="form-label mb-1">Filter by Price Range</label>
                <select name="price" class="form-control" onchange="this.form.submit()">
                    <option value="">All Prices Range</option>
                    <?php
                    foreach ($priceRanges as $label => $range):
                        $value = $range[0] . '-' . ($range[1] ?? 'above'); // Format value
                    ?>
                        <option value="<?= $value ?>" <?= ($params->price == $value) ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Results per Page -->
            <div class="col-md-2">
                <label class="form-label mb-1">Results per Page</label>
                <select name="perPage" class="form-control" onchange="this.form.submit()">
                    <option value="2" <?= ($params->perPage == 2) ? 'selected' : '' ?>>2 results per page</option>
                    <option value="10" <?= ($params->perPage == 10) ? 'selected' : '' ?>>10 results per page</option>
                    <option value="25" <?= ($params->perPage == 25) ? 'selected' : '' ?>>25 results per page</option>
                    <option value="50" <?= ($params->perPage == 50) ? 'selected' : '' ?>>50 results per page</option>
                </select>
            </div>
        </div>
        <input type="hidden" name="sort" value="<?= $params->sort; ?>">
        <input type="hidden" name="order" value="<?= $params->order; ?>">
    </form>
</div>




<div class="container mt-4">


    <a href="<?= site_url('admin/products/new') ?>" class="btn btn-success mb-3">Add Product</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th><?= view_cell('SortTableHeaderCell',  ['params' => $params, 'baseUrl' => $baseUrl, 'tableField' => 'name', 'tableTitleHeader' => 'Name']) ?></th>
                    <th><?= view_cell('SortTableHeaderCell',  ['params' => $params, 'baseUrl' => $baseUrl, 'tableField' => 'price', 'tableTitleHeader' => 'Price']) ?></th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Images</th>
                    <th><?= view_cell('SortTableHeaderCell',  ['params' => $params, 'baseUrl' => $baseUrl, 'tableField' => 'created_at', 'tableTitleHeader' => 'Date']) ?></th>
                    <th>Detail</th>
                    <th>Edit</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product->name ?></td>
                        <td><?= $product->getFormattedPrice() ?></td>
                        <td><?= $product->stock ?></td>
                        <td><?= $product->category ?></td>
                        <td style="width: 25%;">
                            <div id="carousel<?= $product->id ?>" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach ($product->images as $index => $image) : ?>
                                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?> ">
                                            <img src="<?= base_url($image) ?>" class="w-100" alt="Product Image">
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $product->id ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $product->id ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                            </div>

                        </td>
                        <td><?= $product->created_at ?></td>
                        <td>
                            <a href="<?= route_to('product_details', $product->id) ?>" class="btn btn-primary btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                </svg>
                            </a>
                        </td>
                        <td>
                            <a href="<?= site_url('admin/products/' .  $product->id . '/edit') ?>" class="btn btn-warning btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                </svg>
                            </a>
                        </td>
                        <td>
                            <form action="<?= site_url('admin/products/' . $product->id) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $pager->links('products', 'custom_pager') ?>
<?= $this->endSection() ?>