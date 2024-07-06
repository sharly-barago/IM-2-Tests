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

        <div class="dashboard_content">
            <div class="container">
                <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    Add New User
                </button>

                <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
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

                <div class="card">
                    <div class="card-header border-bottom-0 my-2 mx-2 bg-white">
                        <h2 class="card-title"><i class="fa fa-list"></i> List of Users</h2>
                    </div>
                    <div class="card-body p-0 ">
                        <div class="table-responsive border-top">
                            <table class="table table-hover table-striped border-top">
                                <thead class="bg-white">
                                    <tr class="userAdd">
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
                                                <button class="btn btn-sm btn-outline-primary updateUser m-1" data-user-id="<?= $user['id'] ?>" data-fname="<?= htmlspecialchars($user['fname']) ?>" data-lname="<?= htmlspecialchars($user['lname']) ?>" data-email="<?= htmlspecialchars($user['email']) ?>">
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

        document.addEventListener('click', function(e) {
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

                if (e.target.classList.contains('updateUser')) {
                    e.preventDefault();
                    const {
                        userId,
                        fname,
                        lname,
                        email
                    } = e.target.dataset;
                    console.log(`Update user: ${fname} ${lname}, Email: ${email}, ID: ${userId}`);
                }
            }
        });
    });
</script>

<?php include('partials/footer.php'); ?>