<?php
include 'db_connection.php'; // Database connection

if (isset($_GET['state'])) {
    $state = $_GET['state'];

    $stmt = $conn->prepare("SELECT Products.ID, Products.Name, Products.Description, Products.Image, Products.Price, Products.Quantity 
                            FROM Products 
                            JOIN States ON Products.StateID = States.ID 
                            WHERE States.Name = ?");
    $stmt->bind_param("s", $state);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product-card">';
            echo '<img src="' . htmlspecialchars($row["Image"]) . '" alt="Product Image">';
            echo '<h3>' . htmlspecialchars($row["Name"]) . '</h3>';
            echo '<p class="description">' . htmlspecialchars($row["Description"]) . '</p>';
            echo '<p class="price">$' . htmlspecialchars($row["Price"]) . '</p>';
            echo '<div class="quantity-selector">';
            echo '<button class="decrement" onclick="updateQuantity(this, -1)">−</button>';
            echo '<span class="quantity">1</span>';
            echo '<button class="increment" onclick="updateQuantity(this, 1)">+</button>';
            echo '</div>';
            echo '<button class="add-to-cart" data-product-id="' . htmlspecialchars($row["ID"]) . '">Add to Cart</button>';
            echo '</div>';
        }
    } else {
        echo "No products available for this state.";
    }

    $stmt->close();
}
$conn->close();
?>
