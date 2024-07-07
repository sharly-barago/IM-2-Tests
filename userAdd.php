<?php
// session start
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');
$_SESSION['table'] = 'users';
$user = $_SESSION['user'];
$users = include('database/showUsers.php');

$pageTitle = 'User Add';
include('partials/header.php');
?>

<div id="dashboardMainContainer">
    <?php include('partials/sideBar.php') ?>

    <div class="dashboard_content_container" id="dashboard_content_container">
        <?php include('partials/topNavBar.php') ?>

        <div class="dashboard_content d-flex justify-content-center">
            <div class="container m-0 p-0 mw-100">

                <?php include('partials/userAddModal.php') ?>
                <?php include('partials/userUpdateModal.php') ?>

                <div class="card h-100 border-0">

                    <div class="card-header p-3 bg-white d-flex justify-content-between">
                        <h2 class="card-title m-2"><i class="fa fa-list"></i> List of Users</h2>
                        <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            Add New User
                        </button>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive flex-grow-1" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                            <table class="table table-hover table-striped border-top">
                                <thead class="bg-white">
                                    <tr class="userAdd sticky-top">
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = 0;
                                    foreach ($users as $user) { ?>
                                        <tr>
                                            <td class="pt-3"><?= ++$index ?></td>
                                            <td class="pt-3"><?= htmlspecialchars($user['fname']) ?></td>
                                            <td class="pt-3"><?= htmlspecialchars($user['lname']) ?></td>
                                            <td class="pt-3"><?= htmlspecialchars($user['email']) ?></td>
                                            <td class="pt-3"><?= date('M d, Y @ h:i:s A', strtotime($user['created_at'])) ?></td>
                                            <td class="pt-3"><?= date('M d, Y @ h:i:s A', strtotime($user['updated_at'])) ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary updateUser m-1" data-bs-toggle="modal" data-bs-target="#updateUserModal" data-user-id="<?= $user['id'] ?>" data-fname="<?= htmlspecialchars($user['fname']) ?>" data-lname="<?= htmlspecialchars($user['lname']) ?>" data-email="<?= htmlspecialchars($user['email']) ?>">
                                                    <i class="fa fa-pencil"></i> Edit </button>
                                                <button class="btn btn-sm btn-outline-danger deleteUser m-1" data-user-id="<?= $user['id'] ?>" data-fname="<?= htmlspecialchars($user['fname']) ?>" data-lname="<?= htmlspecialchars($user['lname']) ?>">
                                                    <i class="fa fa-trash"></i> Delete </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-muted mt-0 mx-3"><?= count($users) ?> Users</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addUserForm = document.getElementById('addUserForm');
        const updateUserForm = document.getElementById('updateUserForm');

        addUserForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(addUserForm);

            fetch('database/user_DB_add.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });

        updateUserForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(updateUserForm);

            fetch('database/user_DB_add.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.updateUser')) {
                e.preventDefault();
                const updateButton = e.target.closest('.updateUser');
                const userId = updateButton.dataset.userId;
                const fname = updateButton.dataset.fname;
                const lname = updateButton.dataset.lname;
                const email = updateButton.dataset.email;

                updateUserForm.querySelector('#id').value = userId;
                updateUserForm.querySelector('#updateFname').value = fname;
                updateUserForm.querySelector('#updateLname').value = lname;
                updateUserForm.querySelector('#updateEmail').value = email;
                updateUserForm.querySelector('#updatePassword').value = '';

                const updateUserModal = new bootstrap.Modal(document.getElementById('updateUserModal'));
                updateUserModal.show();
            }

            if (e.target.closest('.deleteUser')) {
                e.preventDefault();
                const deleteButton = e.target.closest('.deleteUser');
                const userId = deleteButton.dataset.userId;
                const fname = deleteButton.dataset.fname;
                const lname = deleteButton.dataset.lname;
                const fullName = `${fname} ${lname}`;

                if (confirm(`Are you sure you want to delete ${fullName}?`)) {
                    fetch('database/deleteUser.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                user_id: userId
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                            if (data.success) {
                                location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred. Please try again.');
                        });
                }
            }
        });
    });
</script>

<?php include('partials/footer.php'); ?>