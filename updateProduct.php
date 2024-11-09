<?php
session_start();
include 'db_connection.php'; // Database connection

// Check if the user is logged in as a retailer
if (!isset($_SESSION['ID']) || $_SESSION['user_type'] != 'Retailer') {
    header('Location: login.html');
    exit();
}

$retailerID = $_SESSION['ID'];
$productID = $_GET['productID'];

// Fetch product details from the database
$product = null;
$result = mysqli_query($conn, "SELECT * FROM Products WHERE ID = '$productID' AND RID = '$retailerID'");
if ($result && mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
} else {
    echo "Product not found or you do not have permission to edit this product.";
    exit();
}

// Fetch states for the state dropdown
$statesResult = mysqli_query($conn, "SELECT ID, Name FROM States");
$states = [];
while ($row = mysqli_fetch_assoc($statesResult)) {
    $states[] = $row;
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="updateProduct.css">
</head>
<body>
<header><iframe src="header.html" width="100%" height="100" frameborder="0"></iframe></header>

    <main class="container">
        <h2>Update Product</h2>

        <div class="form-container">
        <!-- Display the product details in a form -->
            <form action="updateProductAction.php" method="POST">
                <img src="<?= htmlspecialchars($product['Image']) ?>" alt="Product Image" class="image-box">
                <!-- Hidden field for Product ID -->
                <input type="hidden" name="productID" value="<?= htmlspecialchars($product['ID']) ?>">

                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" value="<?= htmlspecialchars($product['Name']) ?>" required>

                <label for="price">Price:</label>
                <input type="text" id="price" name="price" value="<?= htmlspecialchars($product['Price']) ?>" required>

                <label for="quantity">Quantity:</label>
                <input type="text" id="quantity" name="quantity" value="<?= htmlspecialchars($product['Quantity']) ?>" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?= htmlspecialchars($product['Description']) ?></textarea>

                <label for="state">State:</label>
                <select id="state" name="state" disabled>
                    <?php foreach ($states as $state): ?>
                        <option value="<?= $state['ID'] ?>" <?= ($state['ID'] === $product['StateID']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($state['Name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="hidden" name="state" value="<?= htmlspecialchars($product['StateID']) ?>">


                <label for="imagePath">Image Path:</label>
                <input type="text" id="imagePath" name="imagePath" value="<?= htmlspecialchars($product['Image']) ?>">

                <button type="submit" class="submit-button">Save Changes</button>
            </form>
        </div>
    </main>
</body>
</html>
