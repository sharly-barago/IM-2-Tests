<?php
include('connect.php');

$stmt = $conn->prepare("SELECT * FROM purchase_requests ORDER BY id DESC");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

return $stmt->fetchAll();
