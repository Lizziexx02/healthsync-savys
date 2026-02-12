<?php
include('config.php');
session_start();

if (isset($_GET['prod_id'])) {
    $prod_id = $_GET['prod_id'];
    $user_id = $_SESSION['user_id'];

    // Remove the item from the database
    $query = "DELETE FROM tbl_cart WHERE prod_id = '$prod_id' AND usact_id = '$user_id'";

    if (mysqli_query($conn, $query)) {
        // Remove item from session as well
        unset($_SESSION['cart'][$prod_id]);
    }
}
header('Location: user-cart.php');  // Redirect to cart page after removal
exit();
?>
