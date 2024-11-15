<?php
session_start();
include 'db_connection.php';

$data = json_decode(file_get_contents("php://input"), true);
$address = $data['address'];
$customer_id = $_SESSION['ID'];

// Start transaction
$conn->begin_transaction();

try {
    // Insert into Order table
    $order_id = uniqid(); // Unique order ID
    $date = date('Y-m-d');
    $time = date('H:i:s');

    $sql = "INSERT INTO `Order` (ID, CustID, Date, Time, Address) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement for Order insertion: " . $conn->error);
    }
    $stmt->bind_param("sssss", $order_id, $customer_id, $date, $time, $address);
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute Order insertion: " . $stmt->error);
    }
    
    // Insert products into Products_in_Order from Cart
    $sql = "INSERT INTO Products_in_Order (OrderID, ProductID, Qty)
            SELECT ?, ProductID, Quantity FROM Cart WHERE CustID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement for Products_in_Order insertion: " . $conn->error);
    }
    $stmt->bind_param("ss", $order_id, $customer_id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute Products_in_Order insertion: " . $stmt->error);
    }

    // Clear the Cart for this user
    $sql = "DELETE FROM Cart WHERE CustID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement for Cart clearing: " . $conn->error);
    }
    $stmt->bind_param("s", $customer_id);
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute Cart clearing: " . $stmt->error);
    }

    // Commit transaction
    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Rollback transaction if something goes wrong and output detailed error message
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Order placement failed: ' . $e->getMessage()]);
}
?>
