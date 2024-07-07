<div class="modal fade custom-modal" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addUserForm" action="database/user_DB_add.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fname" class="form-label text-dark fw-normal">First Name</label>
                        <input type="text" class="form-control" name="fname" id="fname" required>
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label text-dark fw-normal">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="lname" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label text-dark fw-normal">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-dark fw-normal">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>