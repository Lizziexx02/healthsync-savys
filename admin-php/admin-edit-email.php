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
    // Get the new email value
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if the email already exists
    $check_email_query = "SELECT * FROM tbl_admin WHERE admin_email='$new_email' AND admin_id != '$admin_id'";
    $result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($result) > 0) {
        echo "This email is already in use. Please choose another one.";
        exit();
    }

    // Update the admin's email in the database
    $update_email_query = "UPDATE tbl_admin SET admin_email='$new_email' WHERE admin_id='$admin_id'";

    if (mysqli_query($conn, $update_email_query)) {
        // Redirect to the admin's account page after updating
        header('Location: admin-my-account.php');
        exit();
    } else {
        echo "Error updating email: " . mysqli_error($conn);
    }
}
?>
