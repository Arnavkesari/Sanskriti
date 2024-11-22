<?php
session_start();
include('db_connection.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $id = $_POST['UserID'];
    $pass = $_POST['pass'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];
    $userType = isset($_POST['gstin']) ? 'Retailer' : 'Customer';  // Determine user type based on GSTIN

    // Insert data into Users table
    $sql = "INSERT INTO Users (ID, Password, Phone, Email, Name, Street, City, State, Pincode, UserType) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $id, $pass, $phone, $email, $name, $street, $city, $state, $pincode, $userType);

    if ($stmt->execute()) {
        
        header('Location: login.php?newuser=true');
    } else {
        echo "Error: " . $stmt->error;
    }

    // If user is a retailer, insert data into the Retailer table
    if ($userType === 'Retailer') {
        $gstin = $_POST['gstin'];
        $retailerSql = "INSERT INTO Retailer (RID, GST, Status) VALUES (?, ?, 'Pending')";
        $retailerStmt = $conn->prepare($retailerSql);
        $retailerStmt->bind_param("ss", $id, $gstin);

        if ($retailerStmt->execute()) {
            
            header('Location: login.php?newuser=true');
        } else {
            echo "Error: " . $retailerStmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>
