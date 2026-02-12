<?php
include('config.php');
session_start();

$user_id = $_SESSION['user_id'];

// Clear the entire cart from the database
$query = "DELETE FROM tbl_cart WHERE usact_id = '$user_id'";

if (mysqli_query($conn, $query)) {
    // Clear session cart as well
    unset($_SESSION['cart']);
}

header('Location: user-cart.php');  // Redirect to cart page after clearing
exit();
?>
