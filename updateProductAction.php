<?php
session_start();
include 'db_connection.php'; // Database connection

// Check if the user is logged in as a retailerk
if (!isset($_SESSION['ID']) || $_SESSION['user_type'] != 'Retailer') {
    header('Location: login.html');
    exit();
}

$retailerID = $_SESSION['ID'];
$productID = $_POST['productID'];
$productName = mysqli_real_escape_string($conn, $_POST['productName']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$stateID = mysqli_real_escape_string($conn, $_POST['state']);
$imagePath = mysqli_real_escape_string($conn, $_POST['imagePath']);

// Update the product in the database
$sql = "UPDATE Products SET 
            Name = '$productName', 
            Price = '$price', 
            Quantity = '$quantity', 
            Description = '$description', 
            StateID = '$stateID', 
            Image = '$imagePath' 
        WHERE ID = '$productID' AND RID = '$retailerID'";

if (mysqli_query($conn, $sql)) {
    header("Location: retailer_inventory.php?update=success");
} else {
    echo "Error updating product: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
