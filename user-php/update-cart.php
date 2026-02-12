<?php
include('config.php');
session_start();

$user_id = $_SESSION['user_id'];
$prod_id = $_GET['prod_id'];
$change = $_GET['change'];

// Update the database quantity
$sql = "UPDATE tbl_cart SET cart_quantity = cart_quantity + $change 
        WHERE usact_id = '$user_id' AND prod_id = '$prod_id'";

mysqli_query($conn, $sql);

// If quantity hits 0, remove it
mysqli_query($conn, "DELETE FROM tbl_cart WHERE cart_quantity <= 0");

header('Location: user-cart.php');
?>