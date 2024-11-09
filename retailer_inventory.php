<?php
session_start();
include 'db_connection.php'; // Include database connection file

// Check if the user is logged in as a retailer
if (!isset($_SESSION['ID']) || $_SESSION['user_type'] != 'Retailer') {
    header('Location: login.html');
    exit();
}

$retailerID = $_SESSION['ID'];
// Fetch products for the logged-in retailer
$pendingProducts = [];
$listedProducts = [];

// Fetch pending products
$result = mysqli_query($conn, "SELECT * FROM Products WHERE RID = '$retailerID' AND Status = 'Pending'");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pendingProducts[] = $row;
    }
}

// Fetch approved products
$result = mysqli_query($conn, "SELECT * FROM Products WHERE RID = '$retailerID' AND Status = 'Approved'");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $listedProducts[] = $row;
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retailer Inventory</title>
    <link rel="stylesheet" href="retailer_inventory.css">
</head>
<body>
    <?php include 'header.html'; ?>

    <div class="heading-container">
        <div class="heading">Inventory</div>
        <a href="addProduct.html">
            <button class="add-new-button">Add New Product</button>
        </a>
    </div>


    <!-- Pending Products -->
    <section class="products">
        <h2>Pending Products</h2>
        <div class="product-grid">
            <?php if (empty($pendingProducts)): ?>
                <p>No pending products</p>
            <?php else: ?>
                <?php foreach ($pendingProducts as $product): ?>
                    <div class="product-card" data-product-id="<?= $product['ID'] ?>">
                        <img src="<?= htmlspecialchars($product['Image']) ?>" alt="Product Image">
                        <h3><?= htmlspecialchars($product['Name']) ?></h3>
                        <p class="description"><?= htmlspecialchars($product['Description']) ?></p>
                        <p class="price">$<?= htmlspecialchars($product['Price']) ?></p>
                        <p class="stock-quantity">In Stock: <span><?= htmlspecialchars($product['Quantity']) ?></span></p>
                        <div class="action-buttons">
                            <button class="delete-product" onclick="openModal('<?= htmlspecialchars($product['ID'], ENT_QUOTES) ?>')">Delete</button>
                            <button class="update-product" onclick="window.location.href='updateProduct.php?productID=<?= $product['ID'] ?>'">Update</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>


    <!-- Listed Products -->
    <section class="products">
        <h2>Listed Products</h2>
        <div class="product-grid">
            <?php if (empty($listedProducts)): ?>
                <p>No listed products</p>
            <?php else: ?>
                <?php foreach ($listedProducts as $product): ?>
                    <div class="product-card" data-product-id="<?= $product['ID'] ?>">
                        <img src="<?= htmlspecialchars($product['Image']) ?>" alt="Product Image">
                        <h3><?= htmlspecialchars($product['Name']) ?></h3>
                        <p class="description"><?= htmlspecialchars($product['Description']) ?></p>
                        <p class="price">$<?= htmlspecialchars($product['Price']) ?></p>
                        <p class="stock-quantity">In Stock: <span><?= htmlspecialchars($product['Quantity']) ?></span></p>
                        <div class="action-buttons">
                            <button class="delete-product" onclick="openModal('<?= htmlspecialchars($product['ID'], ENT_QUOTES) ?>')">Delete</button>
                            <button class="update-product" onclick="window.location.href='updateProduct.php?productID=<?= $product['ID'] ?>'">Update</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>


    <?php include 'footer.html'; ?>

    <!-- Modal for delete confirmation -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <p>Are you sure you want to delete this product?</p>
            <button class="confirm-delete" onclick="confirmDelete()">Yes, Delete</button>
            <button class="cancel-delete" onclick="closeModal()">Cancel</button>
        </div>
    </div>


    <!-- Notification for delete success -->
    <div class="notification" id="deleteNotification">Product deleted successfully!</div>

    <script>
        let productIDToDelete = null;

        // Function to open the modal and set the product ID to delete
        function openModal(productID) {
            console.log("Opening modal for product ID:", productID);
            productIDToDelete = productID;
            document.getElementById("deleteModal").style.display = "flex";
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById("deleteModal").style.display = "none";
            productIDToDelete = null;
        }


        // Function to show notification
        function showNotification() {
            const notification = document.getElementById("deleteNotification");
            notification.classList.add("show");

            // Hide the notification after 3 seconds
            setTimeout(() => {
                notification.classList.remove("show");
            }, 3000);
        }

        // Function to confirm deletion and send AJAX request
        function confirmDelete() {
            if (productIDToDelete) {
                fetch('delete_product.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ productID: productIDToDelete })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the product card from the DOM
                        document.querySelector(`.product-card[data-product-id='${productIDToDelete}']`).remove();
                        showNotification();
                    } else {
                        console.error("Error:", data.error);
                    }
                    closeModal();
                })
                .catch(error => console.error("Error:", error));
            }
        }
    </script>
</body>
</html>
