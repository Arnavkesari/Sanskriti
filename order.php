<?php
    session_start();
    include 'db_connection.php'; // Include the database connection file
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    include 'header.html';
    if (!isset($_SESSION['ID'])) {
        header('Location: login.html');
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Orders</title>
  <link rel="stylesheet" href="orders.css">
</head>
<body>
  
  <main>
  

    <section class="order-list">
    <h1>My Orders</h1>
      <?php
     
      $userID = $_SESSION['ID'];
      

      // Query to get orders for the specific user
      $orderQuery = "SELECT * FROM `order` WHERE CustID = '$userID'";
      $orderResult = $conn->query($orderQuery);

      if ($orderResult->num_rows > 0) {
          // Loop through each order
          while ($orderRow = $orderResult->fetch_assoc()) {
              $orderID = $orderRow['ID'];
              $orderDate = $orderRow['Date'];
              $orderStatus = "Shipped"; // Assuming you have a field for status; replace accordingly

              echo "<div class='order-card'>";
              echo "<h2>Order {$orderID}</h2>";
              echo "<p><strong>Date:</strong> " . date("F j, Y", strtotime($orderDate)) . "</p>";
              echo "<p><strong>Status:</strong> {$orderStatus}</p>";
              echo "<div class='order-items'>";

              // Query to get products in the current order
              $productQuery = "
                  SELECT p.Name, p.Price, p.Image, po.Qty
                  FROM Products p JOIN Products_in_Order po
                  ON p.ID = po.ProductID
                  WHERE po.OrderID = '$orderID'
              ";
              $productResult = $conn->query($productQuery);

              $total = 0;
              if ($productResult->num_rows > 0) {
                  while ($productRow = $productResult->fetch_assoc()) {
                      $productName = $productRow['Name'];
                      $productPrice = $productRow['Price'];
                      $productImage = $productRow['Image'];
                      $productQuantity = $productRow['Qty'];

                      // Calculate total cost for this order
                      $total += $productPrice * $productQuantity;

                      echo "<div class='item'>";
                      echo "<img src='{$productImage}' alt='Product Image'>";
                      echo "<div class='item-details'>";
                      echo "<h3 class='item-name'>{$productName}</h3>";
                      echo "<p class='item-quantity'><b>Quantity</b>: {$productQuantity}</p>";
                      echo "<p class='item-price'><b>Price</b>: $" . number_format($productPrice, 2) . "</p>";
                      echo "</div>";
                      echo "</div>";
                  }
              }
              echo "</div>"; // Close order-items
              echo "<p class='total'><strong>Total:</strong> $" . number_format($total, 2) . "</p>";
              echo "</div>"; // Close order-card
          }
      } else {
          echo "<p>No orders found.</p>";
      }

      $conn->close();
      ?>
    </section>
  </main>
  <?php
    include 'footer.html';
    ?>
</body>
</html>

