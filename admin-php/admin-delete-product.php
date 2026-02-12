<?php
include('config.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

if (isset($_GET['prod_id'])) { // Updated to prod_id
    $prod_id = $_GET['prod_id'];

    // Updated column name in DELETE query
    $sql_delete = "DELETE FROM tbl_products WHERE prod_id = '$prod_id'";

    if (mysqli_query($conn, $sql_delete)) {
        header('Location: admin-products.php');  
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "No product ID specified.";
}
?>