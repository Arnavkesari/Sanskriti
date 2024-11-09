<?php
// Database connection details
$host = "localhost";      // Database host
$username = "root";       // Database username
$password = "";           // Database password
$dbname = "your_database"; // Database name

// Establishing database connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
