<?php
// Database configuration
$host = "localhost";  // Update as needed
$dbname = "sanskriti";  // Update as needed
$username = "your_db_username";  // Update as needed
$password = "your_db_password";  // Update as needed

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $id = $_POST['UserID'];
    $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);  // Hash the password
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
        echo "Registration successful!";
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
            echo "Retailer information submitted successfully!";
        } else {
            echo "Error: " . $retailerStmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>
