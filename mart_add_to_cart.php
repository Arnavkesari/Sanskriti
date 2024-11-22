<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['ID'])) {
    echo "Please log in to add items to your cart.";
    exit();
}


// Get POST data
$productID = $_POST['productID'];
$quantity = $_POST['quantity'];
$userID = $_SESSION['user_id'];

// Check if the product is already in the cart
$sql = "SELECT * FROM Cart WHERE ProductID = ? AND CustID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $productID, $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity if the product is already in the cart
    $sql = "UPDATE Cart SET Quantity = Quantity + ? WHERE ProductID = ? AND CustID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $quantity, $productID, $userID);
} else {
    // Insert new product into the cart
    $sql = "INSERT INTO Cart (ProductID, CustID, Quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $productID, $userID, $quantity);
}

if ($stmt->execute()) {
    echo "Product added to cart successfully!";
} else {
    echo "Failed to add product to cart.";
}

$stmt->close();
$conn->close();
?>