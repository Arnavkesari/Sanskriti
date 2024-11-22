<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MarketPlace</title>
    <link rel="stylesheet" href="mart.css?ver=1.5">
</head>
<body>
    <?php
    session_start();
    include 'db_connection.php'; // Include the database connection file
    include 'header.php'; // Include the header file

    $stateid = $_GET['stateid'];
    ?>

    <div class="region-select">
        <!-- Heading and Search Box -->
        <div class="header-container">
            <h2 class="region-heading">Search by State</h2>
        </div>
        <div class="region-section">
            <!-- Left Scroll Button -->
            <button class="scroll-button left" onclick="scrollLeft()">&#10094;</button>
            <!-- Regions Container -->
            <div class="regions-container" id="regionsContainer">
            <?php
                    // Query to get regions (states)
                    $sql = "SELECT Name, ID FROM States";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            ?>
                            <a href="mart_statewise.php?stateid='<?php echo htmlspecialchars($row["ID"])?>' " >
                                <div class="region-tile"><?php echo htmlspecialchars($row["Name"]) ?></div>
                            </a>
                            <?php
                        }
                    } else {
                        echo "No regions available.";
                    }
                ?>
            </div>
            <!-- Right Scroll Button -->
            <button class="scroll-button right" onclick="scrollRight()">&#10095;</button>
        </div>
    </div>

    <section class="products">
        <h2>Products</h2>
        <div class="product-grid">
            <?php
                // Fetch all products
                $sql = "SELECT Products.ID, Products.Name, Products.Description, Products.Image, Products.Price, Products.Quantity, States.Name AS sname
                        FROM Products, States
                        WHERE Products.StateID = States.ID
                        AND States.ID = $stateid";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="product-card">';
                        echo '<img src="' . htmlspecialchars($row["Image"]) . '" alt="Product Image">';
                        echo '<h3>' . htmlspecialchars($row["Name"]) . '</h3>';
                        echo '<p class="state">' . htmlspecialchars($row["sname"]) . '</p>';
                        echo '<p class="description">' . htmlspecialchars($row["Description"]) . '</p>';
                        echo '<p class="price">Rs ' . htmlspecialchars($row["Price"]) . '</p>';
                        echo '<div class="quantity-selector">';
                        echo '<button class="decrement" onclick="updateQuantity(this, -1)">−</button>';
                        echo '<span class="quantity">1</span>';
                        echo '<button class="increment" onclick="updateQuantity(this, 1)">+</button>';
                        echo '</div>';
                        echo '<button class="add-to-cart" data-product-id="' . htmlspecialchars($row["ID"]) . '">Add to Cart</button>';
                        echo '</div>';
                    }
                } else {
                    echo "No products available.";
                }
            ?>
        </div>
    </section>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <script src="mart.js?ver=1.4"></script>
</body>
</html>
