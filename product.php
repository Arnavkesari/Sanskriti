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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $image = ""; // Handle image upload logic here if needed

    // Check if the product exists
    $checkSql = "SELECT * FROM Products WHERE ID = :productId";
    $stmt = $pdo->prepare($checkSql);
    $stmt->bindParam(':productId', $productId);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Update existing product
        $updateSql = "UPDATE Products SET 
                        Name = :productName, 
                        Price = :price, 
                        Quantity = :quantity, 
                        Description = :description, 
                        Image = :image 
                      WHERE ID = :productId";

        $stmt = $pdo->prepare($updateSql);
        echo "Product updated successfully!";
    } else {
        // Insert new product
        $insertSql = "INSERT INTO Products (ID, Name, Price, Quantity, Description, Image) 
                      VALUES (:productId, :productName, :price, :quantity, :description, :image)";

        $stmt = $pdo->prepare($insertSql);
        echo "Product added successfully!";
    }

    // Bind parameters
    $stmt->bindParam(':productId', $productId);
    $stmt->bindParam(':productName', $productName);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $image);

    // Execute query
    if ($stmt->execute()) {
        echo "Operation successful!";
    } else {
        echo "Operation failed!";
    }
}
?>