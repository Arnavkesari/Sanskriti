<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="Admin_dashboard.css">
</head>
<body>
    <?php
    session_start();
    include 'db_connection.php'; // Include the database connection file
    include 'header.php';
    if (!isset($_SESSION['ID'])) {
        header('Location: login.html');
        exit();
    }
    $userID = $_SESSION['ID'];
    // Query to get count of pending retailers
    $countSql = "SELECT COUNT(*) AS pending_count FROM Retailer WHERE Status = 'Pending'";
    $countResult = $conn->query($countSql);
    $pendingCount = $countResult->fetch_assoc()['pending_count'];

    ?>

    <section class="Retailer">
        <h2>Pending Retailers (<?php echo $pendingCount; ?>)</h2>
        <div class="retailer-grid">
            <?php
            if ($pendingCount > 0) {
                // Query to get pending retailers' details
                   $sql = "SELECT Users.Name AS UserName, Retailer.GST, Users.ID AS UserID, Users.State 
                   FROM Users
                   INNER JOIN Retailer ON Users.ID = Retailer.RID
                   WHERE Retailer.Status = 'Pending'";
                   $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="retailer-card">
                        <p><strong>Name:</strong> <?php echo $row['UserName']; ?></p>
                        <p><strong>GST Number:</strong> <?php echo $row['GST']; ?></p>
                        <p><strong>User ID:</strong> <?php echo $row['UserID']; ?></p>
                        <p><strong>State:</strong> <?php echo $row['State']; ?></p>
                        <form method="post" action="retailer_check.php">
                            <input type="hidden" name="retailer_id" value="<?php echo $row['UserID']; ?>">
                            <button type="submit" name="approve" class="approve-btn">Approve</button>
                            <button type="submit" name="reject" class="reject-btn">Reject</button>
                        </form>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No pending retailers at the moment.</p>";
            }
            ?>
        </div>
    </section>

    
    <?php
        $countSql = "SELECT COUNT(*) AS pending_count FROM pendingProducts";
        $countResult = $conn->query($countSql);
        $pendingCount1 = $countResult->fetch_assoc()['pending_count'];

        $pendingProducts = [];
        $result = mysqli_query($conn, "SELECT * FROM pendingProducts");
        if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pendingProducts[] = $row;
        }
       }
    ?>
    <section class="products">
    <h2>Pending Products (<?php echo $pendingCount1; ?>)</h2>
            <div class="product-grid">
                <?php foreach ($pendingProducts as $product): ?>
                    <div class="product-card" data-product-id="<?= $product['ID'] ?>">
                        <img src="<?= htmlspecialchars($product['Image']) ?>" alt="Product Image">
                        <h3><?= htmlspecialchars($product['Name']) ?></h3>
                        <p class="description"><?= htmlspecialchars($product['Description']) ?></p>
                        <p class="price">$<?= htmlspecialchars($product['Price']) ?></p>
                        <p class="stock-quantity">In Stock: <span><?= htmlspecialchars($product['Quantity']) ?></span></p>
                        <div class="action-buttons">
                            <form method="post" action="product_check.php">
                                <input type="hidden" name="product_id" value="<?= $product['ID'] ?>">
                                <button type="submit" name="approve" class="approve-product">Approve</button>
                                <button type="submit" name="reject" class="reject-product">Reject</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php
        if($pendingCount1==0)
        echo "<p>No pending products at the moment.</p>";

        ?> 
    </section>
    
    <?php  $conn->close();include 'footer.php'; ?>
</body>
</html>