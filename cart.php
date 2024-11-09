<?php
// Database connection
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "sanskriti";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Cart and Product data for a specific customer
$customer_id = 'your_customer_id'; // Replace with actual customer ID or get it dynamically

$sql = "SELECT p.Image, p.Description, p.Price, c.Quantity 
        FROM Cart c 
        JOIN Products p ON c.ProductID = p.ID 
        WHERE c.CustID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// Calculate the total
$total = 0;
foreach ($products as $product) {
    $total += $product['Price'] * $product['Quantity'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="cart_css.css">
</head>
<body>
<div class="container my-5">
    <header class="header text-center p-3">HEADER</header>
    <div class="card my-4">
        <div class="card-body">
            <h5 class="card-title">Products</h5>
            
            <?php foreach ($products as $product): ?>
            <div class="product-item d-flex align-items-center mb-3">
                <img src="<?php echo htmlspecialchars($product['Image']); ?>" alt="Product Image" class="product-img mr-3">
                <div class="product-info mr-auto">
                    <p class="description mb-1"><?php echo htmlspecialchars($product['Description']); ?></p>
                    <div class="quantity-control d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary mr-2">+</button>
                        <span class="quantity"><?php echo htmlspecialchars($product['Quantity']); ?></span>
                        <button class="btn btn-sm btn-outline-secondary ml-2">-</button>
                    </div>
                </div>
                <span class="price">$<?php echo htmlspecialchars(number_format($product['Price'], 2)); ?></span>
            </div>
            <?php endforeach; ?>

            <div class="d-flex justify-content-end align-items-center my-3">
                <span class="total-label mr-3">Total</span>
                <span class="total-amount">$<?php echo number_format($total, 2); ?></span>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" placeholder="Enter Address">
            </div>
            <button class="btn btn-primary btn-save">Save</button>
        </div>
    </div>
    <footer class="footer text-center p-3">FOOTER</footer>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
