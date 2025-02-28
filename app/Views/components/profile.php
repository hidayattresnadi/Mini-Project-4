<div class="container mt-4">
    <h2 class="mb-4">Profile</h2>
    <div class="row">
        <div class="col-12">
            <!-- User Personal Data -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">User Information</h5>
                </div>
                {!user_information!}
            </div>

            <!-- Activity History -->
            <!-- <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Activity History</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        {activity_history}
                        <li class="list-group-item">
                            <strong>{date}:</strong> {action|escape}
                        </li>
                        {/activity_history}
                    </ul>
                </div>
            </div> -->
        </div>
    </div>
</div>