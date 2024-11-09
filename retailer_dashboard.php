<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['ID']) || $_SESSION['user_type'] != 'Retailer') {
    // echo "Please log in as a retailer.";
    header('Location: login.html');
    exit();
}

// Retrieve retailer information from the Users table
$userID = $_SESSION['ID'];
$sql = "SELECT * FROM Users WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$sql1 = "SELECT * FROM Retailer WHERE RID = ?";
$stmt = $conn->prepare($sql1);
$stmt->bind_param("s", $userID);
$stmt->execute();
$result = $stmt->get_result();
$GST = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retailer Dashboard</title>
    <link rel="stylesheet" href="retailer_dashboard.css">
</head>
<body>

<header><iframe src="header.html" width="100%" height="100" frameborder="0"></iframe></header>

<main class="container">
    <h2>Retailer Dashboard</h2>




    <?php if (isset($_GET['update']) && $_GET['update'] == 'success'): ?>
    <p style="color: green; text-align: center; font-weight: bold; margin-top: 20px;">Your information was updated successfully!</p>
    <?php endif; ?>




    <div class="form-container">
        <button class="submit-button" onclick="window.location.href='retailer_inventory.php'">Go To Inventory</button>

        <div class="info">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['Name']); ?></p>
            <p><strong>UserId:</strong> <?php echo htmlspecialchars($user['ID']); ?></p>
            <p><strong>GST NO:</strong> <?php echo htmlspecialchars($GST['GST']); ?></p>
        </div>

        <form action="update_retailer_info.php" method="POST">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user['Password']); ?>" required>

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['Phone']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>

            <h4 id="address">Address</h4>
            <label for="street">Street:</label>
            <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($user['Street']); ?>" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['City']); ?>" required>

            <label for="state">State:</label>
            <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($user['State']); ?>" required>

            <label for="pincode">Pincode:</label>
            <input type="text" id="pincode" name="pincode" value="<?php echo htmlspecialchars($user['Pincode']); ?>" required>

            <div id="save">
                <button type="submit" class="submit-button">Update</button>
            </div>
        </form>
    </div>
</main>

<footer></footer>

</body>
</html>

<?php
$conn->close();
?>
