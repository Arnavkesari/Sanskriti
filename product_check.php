<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product_id'])) {
        $productID = $_POST['product_id'];
        
        if (isset($_POST['approve'])) {
            // Fetch product details from pendingProducts table
            $pendingProductSql = "SELECT * FROM pendingProducts WHERE ID = '$productID'";
            $result = $conn->query($pendingProductSql);
            if ($result && $result->num_rows > 0) {
                $pendingProduct = $result->fetch_assoc();
                
                // Check if the product already exists in the Products table
                $checkProductSql = "SELECT * FROM Products WHERE ID = '$productID'";
                $existingProductResult = $conn->query($checkProductSql);

                if ($existingProductResult && $existingProductResult->num_rows > 0) {
                    // Product exists, update its details
                    $updateProductSql = "
                        UPDATE Products
                        SET 
                            Name = '" . $pendingProduct['Name'] . "',
                            Description = '" . $pendingProduct['Description'] . "',
                            Image = '" . $pendingProduct['Image'] . "',
                            Price = " . $pendingProduct['Price'] . ",
                            Quantity = " . $pendingProduct['Quantity'] . ",
                            StateID = '" . $pendingProduct['StateID'] . "',
                            RID = '" . $pendingProduct['RID'] . "'
                        WHERE ID = '$productID'
                    ";
                    $conn->query($updateProductSql);
                } else {
                    // Product doesn't exist, create a new entry
                    $insertProductSql = "
                        INSERT INTO Products (ID, Name, Description, Image, Price, Quantity, StateID, RID)
                        VALUES (
                            '" . $pendingProduct['ID'] . "',
                            '" . $pendingProduct['Name'] . "',
                            '" . $pendingProduct['Description'] . "',
                            '" . $pendingProduct['Image'] . "',
                            " . $pendingProduct['Price'] . ",
                            " . $pendingProduct['Quantity'] . ",
                            '" . $pendingProduct['StateID'] . "',
                            '" . $pendingProduct['RID'] . "'
                        )
                    ";
                    $conn->query($insertProductSql);
                }

                // Remove the product from the pendingProducts table
                $deletePendingProductSql = "DELETE FROM pendingProducts WHERE ID = '$productID'";
                $conn->query($deletePendingProductSql);
            } 
        } elseif (isset($_POST['reject'])) {
            // Reject the product and remove it from the pendingProducts table
            $deletePendingProductSql = "DELETE FROM pendingProducts WHERE ID = '$productID'";
            $conn->query($deletePendingProductSql);
        }

        // Redirect to Admin_dashboard.php
        header("Location: Admin_dashboard.php");
        exit(); // Ensure the script stops executing after the redirection
    }
}

$conn->close();
?>
