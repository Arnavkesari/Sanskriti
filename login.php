<?php

session_start();
include('db_connection.php');

    $userID = $_POST['ID'];
    $userPassword = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE ID = '$userID' AND Password = '$userPassword'";
    $res=mysqli_query($conn,$sql);

    if($result=mysqli_fetch_assoc($res)){
        $_SESSION['ID']=$result['ID'];
        header('location:retailer_dashboard.html');
    }
    else{ 
        $sql = "SELECT * FROM Admin WHERE AdminID = '$userID' AND Password = '$userPassword'";
        $res=mysqli_query($conn,$sql);
        if($result=mysqli_fetch_assoc($res)){
            $_SESSION['ID']=$result['ID'];
            header('location:retailer_dashboard.html');
        }
        else
        header('location:register.html'); 
    }

$conn->close();
?>
