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
        header("Location: homepage.php");
        exit();
    }
} else {
    // Redirect to home if no state ID is provided
    header("Location: homepage.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanskriti - Cultural Heritage of <?php echo htmlspecialchars($state['Name']); ?></title>
    <link rel="stylesheet" href="state.css?ver=1.8">
</head>
<body>

<div class="container">
    <!-- State Information Section -->
    <div class="state-section">
        <div class="stateInfo">
            <h1><?php echo htmlspecialchars($state['Name']); ?></h1>
            <p><?php echo htmlspecialchars($state['About']); ?></p>
            <p><strong>Language:</strong> <?php echo htmlspecialchars($state['Lang']); ?></p>
            <p><strong>Dance Forms:</strong> <?php echo htmlspecialchars($state['Dance_Forms']); ?></p>
            <p><strong>Cuisine:</strong> <?php echo htmlspecialchars($state['Cuisine']); ?></p>
            <p><strong>Clothing:</strong> <?php echo htmlspecialchars($state['Clothing']); ?></p>
        </div>
        <div>
            <img src="<?php echo htmlspecialchars($state['Image']); ?>" alt="">
        </div>
    </div>

    <!-- Cultural Sites Section -->
    <div class="content-box">
        <h1>Cultural Sites</h1>
        <div class="tile-grid">
            <?php foreach ($culturalSites as $site): ?>
                <div class="debit-card">
                    <div class="debit-card-inner">
                        <div class="debit-card-front">
                        <img src="<?php echo htmlspecialchars($site['Image']); ?>" alt="<?php echo htmlspecialchars($site['Name']); ?>">
                        </div>
                        <div class="debit-card-back">
                            <div class="title"><?php echo htmlspecialchars($site['Name']); ?></div>
                            <p><?php echo htmlspecialchars($site['Description']); ?></p>
                            <div class="loc">Location: <?php echo htmlspecialchars($site['Location']); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Products Section -->
    <div class="content-box">
        <h1>Local Artist Products</h1>
        <div class="tile-grid">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <a href="mart.php"><img src="<?php echo htmlspecialchars($product['Image']); ?>" alt="<?php echo htmlspecialchars($product['Name']); ?>"></a>
                    <div class="message"><?php echo htmlspecialchars($product['Name']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Include Footer -->
<?php include 'footer.php'; ?>

</body>
</html>