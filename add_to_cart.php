<?php
session_start();
include 'db_connection.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['ID'])) {
    $data = json_decode(file_get_contents('php://input'), true);

    $productId = $data['productId'];
    $quantity = $data['quantity'];
    $userId = $_SESSION['ID']; // Assuming user ID is stored in the session

    if (isset($userId)) {
        // Insert or update the cart table
        $stmt = $conn->prepare("
            INSERT INTO Cart (ProductID, CustID, Quantity) 
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE Quantity = Quantity + VALUES(Quantity)
        ");
        $stmt->bind_param("sss", $productId, $userId, $quantity);

        if ($stmt->execute()) {
            echo "Product added to cart successfully.";
        } else {
            echo "Error adding product to cart.";
        }

        $stmt->close();
    } else {
        echo "User not logged in.";
    }
}
else {
    echo "Please login First";
}
$conn->close();
?>
