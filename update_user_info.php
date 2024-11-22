<?php
session_start();
include('db_connection.php');

// Check if the user is logged in as customer
if (!isset($_SESSION['ID']) || $_SESSION['user_type'] != 'Customer') {
    header('Location: login.html');
    exit();
}

// Get the user ID from the session
$userID = $_SESSION['ID'];

// Retrieve updated data from the form
$newPassword = $_POST['password'];
$newPhone = $_POST['phone'];
$newEmail = $_POST['email'];
$newStreet = $_POST['street'];
$newCity = $_POST['city'];
$newState = $_POST['state'];
$newPincode = $_POST['pincode'];

// Update the user's information in the Users table
$sql = "UPDATE Users SET Password = ?, Phone = ?, Email = ?, Street = ?, City = ?, State = ?, Pincode = ? WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $newPassword, $newPhone, $newEmail, $newStreet, $newCity, $newState, $newPincode, $userID);

if ($stmt->execute()) {
    // Update successful, redirect back to the dashboard with a success message
    header('Location: user_dashboard.php?update=success');
} else {
    // Handle error
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
