<?php
// Database connection
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];
    $userId = 'id1234'; // Set this to the retailer's unique ID (use a session variable or hidden input for dynamic values)

    // Update query
    $sql = "UPDATE Users SET 
            Password = :password,
            Phone = :phone,
            Email = :email,
            Street = :street,
            City = :city,
            State = :state,
            Pincode = :pincode
            WHERE ID = :userId";

    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':street', $street);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':pincode', $pincode);
    $stmt->bindParam(':userId', $userId);

    // Execute the query
    if ($stmt->execute()) {
        echo "Retailer information updated successfully!";
    } else {
        echo "Failed to update retailer information.";
    }
}
?>
