<?php
include('config.php');
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the new values for the name
    $first_name = mysqli_real_escape_string($conn, $_POST['fname']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['mname']);
    $surname = mysqli_real_escape_string($conn, $_POST['sname']);

    // Update the admin's name in the database
    $update_sql = "UPDATE tbl_admin SET admin_fName='$first_name', admin_mName='$middle_name', admin_sName='$surname' WHERE admin_id='$admin_id'";

    if (mysqli_query($conn, $update_sql)) {
        // Redirect to the admin's account page after updating
        header('Location: admin-my-account.php');
        exit();
    } else {
        echo "Error updating name: " . mysqli_error($conn);
    }
}
?>
