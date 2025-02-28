<div class="container mt-4">
    <h2 class="mb-4">Product List</h2>
    <form method="get" action="products" class="row g-2">
        <div class="col-md-5">
            <input type="text" id="search" name="search" class="form-control"
                placeholder="Search products..." value="{search}">
        </div>
        <div class="col-md-4">
            <select name="filter" class="form-select">
                <option value="">All Status</option>
                <option value="active" {selected_active}>Active</option>
                <option value="inactive" {selected_inactive}>Inactive</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Search
            </button>
        </div>
    </form>

    <div class="row mt-5">
        {products}
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{name}</h5>
                    <h6 class="text-muted">{category}</h6>
                    <p class="card-text">
                        <strong>Price:</strong> {formattedPrice}
                    </p>

                    <p class="card-text">
                        <strong>Stock:</strong>
                        {stockStyling|noescape}
                    </p>

                    <p class="card-text">
                        <strong>Status:</strong>
                        <span>
                            {status}
                        </span>
                    </p>
                    <!-- Badge untuk Status Produk -->
                    {isNewSpan|noescape}
                    {isOnSaleSpan|noescape}
                    <div class="mt-2 d-flex justify-content-center">{buyButton|noescape}</div>


                </div>
            </div>
        </div>
        {/products}
    </div>
</div>