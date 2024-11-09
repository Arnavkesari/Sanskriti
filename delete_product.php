<?php
session_start();
include 'db_connection.php'; // Include your database connection file here

// Read JSON input from JavaScript fetch
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['productID'])) {
    $productID = intval($data['productID']);
    $query = "DELETE FROM products WHERE ID = $productID";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Deletion failed."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid product ID."]);
}

mysqli_close($conn);
?>
