<?php
include 'db_connection.php'; // Include the database connection file

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['productID'])) {
    $productID = $data['productID'];

    // Delete the product from the pendingProducts table
    $sql = "DELETE FROM pendingProducts WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productID);

    if ($stmt->execute()) {
        // Return a success response
        echo json_encode(["success" => true]);
    } else {
        // Return an error response
        echo json_encode(["success" => false, "error" => "Failed to delete product"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "error" => "Invalid product ID"]);
}

$conn->close();
?>
