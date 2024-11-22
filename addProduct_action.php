<?php
session_start();
include 'db_connection.php'; // Include your database connection file

// Check if the user is logged in as a retailer
if (!isset($_SESSION['ID']) || $_SESSION['user_type'] != 'Retailer') {
    header('Location: login.html');
    exit();
}

// Get retailer ID from session
$retailerID = $_SESSION['ID'];

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form inputs
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $imagePath = mysqli_real_escape_string($conn, $_POST['imagePath']);
    $stateName = mysqli_real_escape_string($conn, $_POST['stateName']);

    // Retrieve StateID from States table based on stateName
    $stateQuery = "SELECT ID FROM States WHERE Name = '$stateName' LIMIT 1";
    $stateResult = mysqli_query($conn, $stateQuery);

    if (mysqli_num_rows($stateResult) > 0) {
        $stateRow = mysqli_fetch_assoc($stateResult);
        $stateID = $stateRow['ID'];

        // Insert the new product into the Products table
        $sql = "INSERT INTO pendingProducts (Name, Price, Quantity, Description, Image, StateID, RID, ID)
                VALUES ('$productName', '$price', '$quantity', '$description', '$imagePath', '$stateID', '$retailerID', 'NEWPR')";

        if (mysqli_query($conn, $sql)) {
            echo "Product added successfully!";
            header('Location: retailer_inventory.php'); // Redirect back to the inventory page
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: State not found. Please enter a valid state name.";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
