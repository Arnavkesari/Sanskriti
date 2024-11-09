<?php
// Database configuration
$servername = "localhost"; // Your server (e.g., localhost)
$username = "your_db_username"; // Database username
$password = "your_db_password"; // Database password
$dbname = "sanskriti"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user inputs
    $userID = $_POST['user-id'];
    $userPassword = $_POST['password'];

    // Prepare SQL statement to check for user
    $sql = "SELECT * FROM Users WHERE ID = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $userID, $userPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful
        echo "Login successful!";
        // Redirect to dashboard or home page
        // header("Location: dashboard.php");
        // exit();
    } else {
        // Login failed
        echo "Invalid User ID or Password.";
    }

    // Close statement and connection
    $stmt->close();
}

$conn->close();
?>
