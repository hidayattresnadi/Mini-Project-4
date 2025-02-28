<div class="container mt-4">
    <h2 class="text-center fs-1">{title}</h2>
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body d-flex align-items-center justify-content-center flex-column h-100 p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                    </svg>
                    <h5 class="card-title fs-3 mt-3">Total Active Users</h5>
                    <p class="card-text fs-2">{activeUsers}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-body d-flex align-items-center justify-content-center flex-column h-100 p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z" />
                    </svg>
                    <h5 class="card-title fs-3 mt-3">Total Users</h5>
                    <p class="card-text fs-2">{totalUsers}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 ">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body d-flex align-items-center justify-content-center flex-column h-100 p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5" />
                    </svg>
                    <h5 class="card-title fs-3 mt-3">New Users</h5>
                    <p class="card-text fs-2">{newUsers}</p>
                </div>
            </div>
        </div>
    </div>
</div>