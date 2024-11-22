<?php
session_start();
include 'db_connection.php'; // Database connection

// Check if the user is logged in as a retailer
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

// Check if a product with the same ID already exists
$sql_check = "SELECT ID FROM pendingProducts WHERE ID = '$productID'";
$result = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result) > 0) {
    // If the product exists, update the row
    $sql_update = "UPDATE pendingProducts 
                   SET Name = '$productName', 
                       Price = '$price', 
                       Quantity = '$quantity', 
                       Description = '$description', 
                       Image = '$imagePath', 
                       StateID = '$stateID', 
                       RID = '$retailerID' 
                   WHERE ID = '$productID'";
    if (mysqli_query($conn, $sql_update)) {
        header("Location: retailer_inventory.php?update=success");
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
} else {
    // If the product does not exist, insert a new row
    $sql_insert = "INSERT INTO pendingProducts (Name, Price, Quantity, Description, Image, StateID, RID, ID)
                   VALUES ('$productName', '$price', '$quantity', '$description', '$imagePath', '$stateID', '$retailerID', '$productID')";
    if (mysqli_query($conn, $sql_insert)) {
        header("Location: retailer_inventory.php?insert=success");
    } else {
        echo "Error inserting product: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
