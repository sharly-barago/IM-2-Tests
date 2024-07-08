<?php
session_start();

$table_name = $_SESSION['table'];
$date_needed = $_POST['date_needed'];
$status = $_POST['status'];
$estimated_cost = $_POST['estimated_cost'];
$product_names = isset($_POST['products']) ? $_POST['products'] : [];

// Convert product names array to comma-separated string
$product_names_str = implode(', ', $product_names);

$PR_id = isset($_POST['id']) ? $_POST['id'] : null;

try {
    include('connect.php');

    if ($PR_id) {
        // Update existing purchase request
        $command = "UPDATE $table_name SET user_id = :user_id, date_needed = :date_needed, status = :status, estimated_cost = :estimated_cost, products = :products, updated_at = NOW() WHERE id = :id";
        $stmt = $conn->prepare($command);
        $stmt->bindParam(':id', $PR_id);
    } else {
        // Insert new purchase request
        $command = "INSERT INTO $table_name (user_id, date_needed, status, estimated_cost, products, date_created) VALUES (:user_id, :date_needed, :status, :estimated_cost, :products, NOW())";
        $stmt = $conn->prepare($command);
    }

    $stmt->bindParam(':user_id', $user_id); // Assuming $user_id is set elsewhere
    $stmt->bindParam(':date_needed', $date_needed);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':estimated_cost', $estimated_cost);
    $stmt->bindParam(':products', $product_names_str);
    $stmt->execute();

    $message = "Purchase request successfully " . ($PR_id ? "updated" : "added") . ".";
    $_SESSION['success_message'] = $message;
    header('location: ../PR.php');
} catch (PDOException $e) {
    // Handle any database errors
    $_SESSION['error_message'] = 'Error processing purchase request: ' . $e->getMessage();
    header('location: ../PR.php');
}
