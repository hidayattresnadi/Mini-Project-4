<div class="container mt-4">
    <h2 class="mb-4">Product List</h2>
    <form method="get" action="products" class="row g-2">
        {inputSearch|noescape}
        {filterCategory|noescape}
        {selectPages|noescape}
        {filterPricesRange|noescape}
        <div class="col-md-5">
            <label class="text-muted mt-2 mb-2">Sort Options</label>
            <div class="d-flex gap-2">
                {thName|noescape}
                {thPrice|noescape}
                {thCreatedAt|noescape}
            </div>
        </div>


    </form>

    <div class="row mt-4">
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