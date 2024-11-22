<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Header Design</title>
  <style>
    /* Base styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
     
    }

    header {
      background-color: #000000;
      color: #fff;
      padding: 1rem 0;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      z-index: 100;
    }

    .container1 {
      margin: 0 auto;
      padding: 0 1.5rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    /* Logo styles */
    .logo {
      display: flex;
      align-items: center;
    }

    .logo img {
      height: 3.2rem;
      width: 6rem;
      margin-right: 0.75rem;
    }

    .logo a {
      font-size: 1.75rem;
      font-weight: bold;
      text-decoration: none;
      color: #fff;
      transition: color 0.3s ease;
    }

    .logo a:hover {
      color: #ddd;
    }

    /* Navigation styles */
    nav {
      display: flex;
      align-items: center;
    }

    nav a {
      color: #fff;
      text-decoration: none;
      margin-left: 1.5rem;
      font-size: 1rem;
      transition: color 0.3s ease;
      padding: 0.5rem 0;
      position: relative;
    }

    nav a::after {
      content: '';
      display: block;
      width: 0;
      height: 2px;
      background: #007bff;
      transition: width 0.3s;
      position: absolute;
      bottom: 0;
      left: 0;
    }

    nav a:hover::after {
      width: 100%;
    }

    /* Register Button */
    .register-btn {
      background-color: #007bff;
      color: #fff;
      padding: 0.5rem 1rem;
      border-radius: 0.25rem;
      margin-left: 2rem;
      font-weight: bold;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .register-btn:hover {
      background-color: #0056b3;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <header>
    <div class="container1">
      <div class="logo">
        <img src="sanskriti_logo.jpeg" alt="Logo">
      </div>
      <nav>
        <a href="./homepage.php">Home</a>
        <a href="./mart.php">Mart</a>

        <?php if (isset($_SESSION['ID'])): ?>
          <!-- Links for logged-in users -->
          <a href="./cart.php">Cart</a>

          <?php if ($_SESSION['user_type'] == 'Retailer'): ?>
            <a href="./retailer_dashboard.php">Profile</a>
          <?php elseif($_SESSION['user_type'] == 'Customer'): ?>
            <a href="./user_dashboard.php">Profile</a>
            <a href="./order.php">Orders</a>
          <?php else: ?>
            <a href="./Admin_dashboard.php">Profile</a>
          <?php endif; ?>

          <a href="logout.php">Logout</a>
        <?php else: ?>
          <!-- Links for logged-out users -->
          <a href="./login.php">Login</a>
          <a href="./register.php" class="register-btn">Register</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>
</body>
</html>
