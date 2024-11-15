<?php
session_start();
include 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$productId = $data['productId'];
$action = $data['action'];
$customer_id = $_SESSION['ID'];

if ($action === 'increment') {
    $sql = "UPDATE Cart SET Quantity = Quantity + 1 WHERE ProductID = ? AND CustID = ?";
} else {
    $sql = "UPDATE Cart SET Quantity = GREATEST(Quantity - 1, 0) WHERE ProductID = ? AND CustID = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $productId, $customer_id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update quantity.']);
}
?>
