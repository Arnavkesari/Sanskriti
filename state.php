<?php
// Database connection
include 'db_connection.php'; // Include the database connection file
include 'header.php'; // Include the header HTML file

// Check if state ID is provided in the URL
if (isset($_GET['id'])) {
    $state_id = $_GET['id'];
    
    // Fetch state info for the provided state ID
    $stateStmt = $conn->prepare("SELECT * FROM States WHERE ID = ?");
    $stateStmt->bind_param("s", $state_id);
    $stateStmt->execute();
    $stateResult = $stateStmt->get_result();
    $state = $stateResult->fetch_assoc();

    // Check if the state was found
    if ($state) {
        // Fetch cultural sites associated with the state
        $culturalSitesStmt = $conn->prepare("SELECT * FROM Cultural_Site WHERE StateID = ? LIMIT 4");
        $culturalSitesStmt->bind_param("s", $state_id);
        $culturalSitesStmt->execute();
        $culturalSites = $culturalSitesStmt->get_result()->fetch_all(MYSQLI_ASSOC);

        // Fetch products associated with the state
        $productsStmt = $conn->prepare("SELECT * FROM Products WHERE StateID = ? LIMIT 4");
        $productsStmt->bind_param("s", $state_id);
        $productsStmt->execute();
        $products = $productsStmt->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        // Redirect to home or show an error if the state ID is invalid
        header("Location: home.html");
        exit();
    }
} else {
    // Redirect to home if no state ID is provided
    header("Location: homepage.html");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanskriti - Cultural Heritage of <?php echo htmlspecialchars($state['Name']); ?></title>
    <link rel="stylesheet" href="state.css">
</head>
<body>

<div class="container">
    <!-- State Information Section -->
    <div class="video-section">
        <h2><?php echo htmlspecialchars($state['Name']); ?></h2>
        <p><?php echo htmlspecialchars($state['About']); ?></p>
        <p><strong>Language:</strong> <?php echo htmlspecialchars($state['Lang']); ?></p>
        <p><strong>Dance Forms:</strong> <?php echo htmlspecialchars($state['Dance_Forms']); ?></p>
        <p><strong>Cuisine:</strong> <?php echo htmlspecialchars($state['Cuisine']); ?></p>
        <p><strong>Clothing:</strong> <?php echo htmlspecialchars($state['Clothing']); ?></p>
    </div>

    <!-- Cultural Sites Section -->
    <div class="cultural-sites">
        <h3>Cultural Sites</h3>
        <?php foreach ($culturalSites as $site): ?>
            <div class="site">
                <img src="<?php echo htmlspecialchars($site['Image']); ?>" alt="<?php echo htmlspecialchars($site['Name']); ?>">
                <div class="description"><?php echo htmlspecialchars($site['Description']); ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Products Section -->
    <div class="products">
        <h3>Local Artist Products</h3>
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="<?php echo htmlspecialchars($product['Image']); ?>" alt="<?php echo htmlspecialchars($product['Name']); ?>">
                <div class="message">Buy now for a unique experience!</div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Include Footer -->
<?php include 'footer.php'; ?>

</body>
</html>