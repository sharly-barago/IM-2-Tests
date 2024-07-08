<?php
session_start();
if (!isset($_SESSION['user'])) header('location: login.php');
$_SESSION['table'] = 'purchase_requests';
$user = $_SESSION['user'];

$pageTitle = 'Update Purchase Request';
include('partials/header.php');

$requestData = [];
if (isset($_GET['id'])) {
    include('database/connect.php');
    $stmt = $conn->prepare("SELECT * FROM purchase_requests WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $requestData = $stmt->fetch(PDO::FETCH_ASSOC);
    $products = explode(',', $requestData['products']);
}
?>

<div id="dashboardMainContainer">
    <?php include('partials/sideBar.php') ?>

    <div class="dashboard_content_container" id="dashboard_content_container">
        <?php include('partials/topNavBar.php') ?>

        <div class="dashboard_content d-flex justify-content-center">
            <div class="container">
                <div class="card m-5">
                    <div class="card-header p-3 bg-white">
                        <h2 class="card-title my-2 mx-4">Update Purchase Request</h2>
                    </div>
                    <div class="card-body p-5">
                        <form action="database/PR_DB_add.php" method="POST" class="AddForm">
                            <input type="hidden" name="id" id="request_id" value="<?= $requestData['id'] ?? '' ?>">
                            <div class="addFormContainer mb-3">
                                <label for="date_needed" class="form-label">Date Needed</label>
                                <input type="date" class="form-control" name="date_needed" id="date_needed" value="<?= $requestData['date_needed'] ?? '' ?>">
                            </div>
                            <div class="addFormContainer mb-3">
                                <label for="estimated_cost" class="form-label">Estimated Cost</label>
                                <input type="text" class="form-control" name="estimated_cost" id="estimated_cost" value="<?= $requestData['estimated_cost'] ?? '' ?>">
                            </div>
                            <div id="productContainer" class="mb-3">
                                <label for="product" class="form-label">Products</label>
                                <?php foreach ($products as $product) : ?>
                                    <div class="productInput mb-2">
                                        <input type="text" class="form-control" name="products[]" value="<?= htmlspecialchars($product) ?>" placeholder="Product Name">
                                        <button type="button" class="btn btn-danger btn-sm removeProduct">Remove</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" id="addProductButton" class="btn btn-success btn-sm mb-3">Add Product</button>
                            <div class="d-flex flex-row-reverse flex-wrap">
                                <button type="submit" class="btn btn-primary mx-1 mt-4">Submit</button>
                                <a href="PR.php" class="btn btn-secondary mx-1 mt-4">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productContainer = document.getElementById('productContainer');
        const addProductButton = document.getElementById('addProductButton');

        addProductButton.addEventListener('click', function() {
            const productInput = document.createElement('div');
            productInput.classList.add('productInput', 'mb-2');
            productInput.innerHTML = `
                <input type="text" class="form-control" name="products[]" placeholder="Product Name">
                <button type="button" class="btn btn-danger btn-sm removeProduct">Remove</button>
            `;
            productContainer.appendChild(productInput);
        });

        productContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeProduct')) {
                e.target.parentElement.remove();
            }
        });
    });
</script>

<?php include('partials/footer.php'); ?>