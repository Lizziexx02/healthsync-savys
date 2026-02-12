<?php
include('config.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

if (isset($_GET['usact_id'])) {
    $usact_id = $_GET['usact_id'];

    // PERFORM SOFT DELETE (Update deleted_at instead of DELETE FROM)
    // This triggers the 'log_admin_soft_delete_user_history' trigger in your DB schema
    $sql_delete = "UPDATE tbl_user_account SET deleted_at = CURRENT_TIMESTAMP WHERE usact_id = '$usact_id'";

    if (mysqli_query($conn, $sql_delete)) {
        header('Location: admin-users.php'); 
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "No user ID specified.";
}
?>