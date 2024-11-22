<?php
session_start();
include 'db_connection.php';

// Parse incoming JSON request
$data = json_decode(file_get_contents("php://input"), true);
$productId = $data['productId'];
$action = $data['action'];
$customer_id = $_SESSION['ID'];

// Check if the product exists and get its available stock
$productQuery = "SELECT Quantity FROM Products WHERE ID = ?";
$productStmt = $conn->prepare($productQuery);
$productStmt->bind_param("s", $productId);
$productStmt->execute();
$productResult = $productStmt->get_result();

if ($productResult->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Product not found.']);
    exit();
}

$productRow = $productResult->fetch_assoc();
$productStock = $productRow['Quantity'];

// Get the current quantity in the cart
$cartQuery = "SELECT Quantity FROM Cart WHERE ProductID = ? AND CustID = ?";
$cartStmt = $conn->prepare($cartQuery);
$cartStmt->bind_param("ss", $productId, $customer_id);
$cartStmt->execute();
$cartResult = $cartStmt->get_result();

if ($cartResult->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Product not found in cart.']);
    exit();
}

$cartRow = $cartResult->fetch_assoc();
$currentCartQuantity = $cartRow['Quantity'];

// Handle increment action
if ($action === 'increment') {
    if ($currentCartQuantity >= $productStock) {
        echo json_encode(['success' => false, 'message' => 'Cannot add more items. Stock limit reached.']);
        exit();
    }

    $updateQuery = "UPDATE Cart SET Quantity = Quantity + 1 WHERE ProductID = ? AND CustID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ss", $productId, $customer_id);
    if ($updateStmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update quantity.']);
    }
}

// Handle decrement action
elseif ($action === 'decrement') {
    if ($currentCartQuantity > 1) {
        $updateQuery = "UPDATE Cart SET Quantity = Quantity - 1 WHERE ProductID = ? AND CustID = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ss", $productId, $customer_id);
        if ($updateStmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update quantity.']);
        }
    } else {
        // If quantity is 1 and action is decrement, remove the product from the cart
        $deleteQuery = "DELETE FROM Cart WHERE ProductID = ? AND CustID = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("ss", $productId, $customer_id);
        if ($deleteStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Product removed from cart.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to remove product from cart.']);
        }
    }
}

else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
}
?>
