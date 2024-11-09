<?php
session_start();
include 'db_connection.php'; // Include your database connection file

// Check if the user is logged in as a retailer and that the request is valid
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['ID']) && $_SESSION['user_type'] == 'Retailer') {
    $data = json_decode(file_get_contents('php://input'), true);
    $productID = $data['productID'];
    $retailerID = $_SESSION['ID'];

    // Delete the product for the logged-in retailer
    $stmt = $conn->prepare("DELETE FROM Products WHERE ID = ? AND RID = ?");
    $stmt->bind_param("ii", $productID, $retailerID);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete product.']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Unauthorized request.']);
}

// Close the database connection
mysqli_close($conn);
?>
