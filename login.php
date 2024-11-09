<?php
session_start();
include('db_connection.php');

// Retrieve input from POST
$userID = $_POST['ID'];
$userPassword = $_POST['password'];

// Check for User login
$stmt = $conn->prepare("SELECT * FROM Users WHERE ID = ? AND Password = ?");
$stmt->bind_param("ss", $userID, $userPassword);
$stmt->execute();
$res = $stmt->get_result();

if ($result = $res->fetch_assoc()) {
    // Store user information in session
    $_SESSION['ID'] = $result['ID'];
    $_SESSION['user_type'] = $result['UserType'];
    $_SESSION['user_name'] = $result['Name']; // Assuming there’s a 'Name' field in Users table

    // Redirect to retailer dashboard
    header('Location: retailer_dashboard.php');
    exit();
}

// If not a User, check for Admin login
$stmt = $conn->prepare("SELECT * FROM Admin WHERE AdminID = ? AND Password = ?");
$stmt->bind_param("ss", $userID, $userPassword);
$stmt->execute();
$res = $stmt->get_result();

if ($result = $res->fetch_assoc()) {
    // Store admin information in session
    $_SESSION['ID'] = $result['AdminID'];
    $_SESSION['user_type'] = 'Admin';
    $_SESSION['user_name'] = $result['AdminName']; // Assuming there’s an 'AdminName' field in Admin table

    // Redirect to admin dashboard
    header('Location: admin_dashboard.php'); // Consider using a different dashboard for admins
    exit();
}

// If login fails, redirect to register page
header('Location: register.html');
exit();

$conn->close();
?>
