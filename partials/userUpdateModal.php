<div class="modal fade custom-modal" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateUserModalLabel">Update User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateUserForm" action="database/user_DB_add.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="updateFname" class="form-label text-dark fw-normal">First Name</label>
                        <input type="text" class="form-control" name="fname" id="updateFname" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateLname" class="form-label text-dark fw-normal">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="updateLname" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateEmail" class="form-label text-dark fw-normal">Email</label>
                        <input type="email" class="form-control" name="email" id="updateEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="updatePassword" class="form-label text-dark fw-normal">Password (Leave blank to keep current password)</label>
                        <input type="password" class="form-control" name="password" id="updatePassword">
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