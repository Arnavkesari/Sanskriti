<?php
// Handle approve/reject actions
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $retailerID = $_POST['retailer_id'];
    
    if (isset($_POST['approve'])) {
        // Approve retailer
        $updateSql = "UPDATE Retailer SET Status = 'Approved' WHERE RID = '$retailerID'";
        $conn->query($updateSql);
    } elseif (isset($_POST['reject'])) {
        // Reject retailer
        $updateSql = "UPDATE Retailer SET Status = 'Rejected' WHERE RID = '$retailerID'";
        $conn->query($updateSql);
    }
    
    // Redirect to Admin_dashboard.php
    header("Location: Admin_dashboard.php");
    exit(); // Stop further execution after redirection
}

$conn->close();
?>
