<?php
session_start();

$table_name = $_SESSION['table'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$password = $_POST['password'];
$encrypted = password_hash($password, PASSWORD_DEFAULT);
$userId = isset($_POST['id']) ? $_POST['id'] : null;

$response = ['success' => false, 'message' => 'An error occurred.'];

try {
    include('connect.php');

    if ($userId) {
        // Update existing user
        if (!empty($password)) {
            $command = "UPDATE $table_name SET fname = :fname, lname = :lname, email = :email, password = :encrypted, updated_at = NOW() WHERE id = :id";
            $stmt = $conn->prepare($command);
            $stmt->bindParam(':encrypted', $encrypted);
        } else {
            $command = "UPDATE $table_name SET fname = :fname, lname = :lname, email = :email, updated_at = NOW() WHERE id = :id";
            $stmt = $conn->prepare($command);
        }
        $stmt->bindParam(':id', $userId);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $response = [
            'success' => true,
            'message' => $fname . ' ' . $lname . ' successfully updated.'
        ];
    } else {
        // Insert new user
        $command = "INSERT INTO $table_name (fname, lname, password, email, created_at, updated_at) VALUES (:fname, :lname, :encrypted, :email, NOW(), NOW())";
        $stmt = $conn->prepare($command);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':encrypted', $encrypted);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $response = [
            'success' => true,
            'message' => $fname . ' ' . $lname . ' successfully added to the system.'
        ];
    }
} catch (PDOException $e) {
    $response['message'] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
