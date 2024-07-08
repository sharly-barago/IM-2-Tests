<?php
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');
$_SESSION['table'] = 'purchase_requests';
$user = $_SESSION['user'];
$purchaseRequests = include('database/showPRs.php');

$pageTitle = 'Purchase Requests';
include('partials/header.php');
?>

<div id="dashboardMainContainer">
    <?php include('partials/sideBar.php') ?>

    <div class="dashboard_content_container" id="dashboard_content_container">
        <?php include('partials/topNavBar.php') ?>

        <div class="dashboard_content d-flex justify-content-center p-0">
            <div class="container m-0 p-0 mw-100">
                <div class="card h-100 border-0">
                    <div class="card-header p-3 bg-white d-flex justify-content-between">
                        <h2 class="card-title m-2"><i class="fa fa-list"></i> Purchase Requests</h2>
                        <div class="d-flex m-2">
                            <a href="#" class="btn btn-primary mx-2">
                                Suggestions
                            </a>
                            <a href="PRAddForm.php" class="btn btn-primary mx-2">
                                Create Purchase Request
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive flex-grow-1" style="max-height: calc(100vh - 200px); overflow-y: auto;">
                            <table class="table table-hover table-striped border-top">
                                <thead class="bg-white">
                                    <tr class="purchaseRequestAdd sticky-top">
                                        <th>#</th>
                                        <th>User ID</th>
                                        <th>Date Needed</th>
                                        <th>Status</th>
                                        <th>Estimated Cost</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $index = 0;
                                    foreach ($purchaseRequests as $request) { ?>
                                        <tr>
                                            <td class="pt-3"><?= ++$index ?></td>
                                            <td class="pt-3"><?= htmlspecialchars($request['user_id']) ?></td>
                                            <td class="pt-3"><?= htmlspecialchars($request['date_needed']) ?></td>
                                            <td class="pt-3"><?= htmlspecialchars($request['status']) ?></td>
                                            <td class="pt-3"><?= htmlspecialchars($request['estimated_cost']) ?></td>
                                            <td class="pt-3"><?= date('M d, Y @ h:i:s A', strtotime($request['date_created'])) ?></td>
                                            <td class="text-center">
                                                <a href="PRUpdateForm.php?id=<?= $request['id'] ?>" class="btn btn-sm btn-outline-primary m-1">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                                <button class="btn btn-sm btn-outline-danger deleteRequest m-1" data-request-id="<?= $request['id'] ?>">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <p class="text-muted mt-0 mx-3"><?= count($purchaseRequests) ?> Purchase Requests</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php
        if (isset($_SESSION['success_message'])) {
            echo "alert('" . addslashes($_SESSION['success_message']) . "');";
            unset($_SESSION['success_message']);
        }
        if (isset($_SESSION['error_message'])) {
            echo "alert('Error: " . addslashes($_SESSION['error_message']) . "');";
            unset($_SESSION['error_message']);
        }
        ?>
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e) {
            if (e.target.closest('.deleteRequest')) {
                e.preventDefault();
                const deleteButton = e.target.closest('.deleteRequest');
                const requestId = deleteButton.dataset.requestId;

                if (confirm(`Are you sure you want to delete this purchase request?`)) {
                    fetch('database/deletePR.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                request_id: requestId
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