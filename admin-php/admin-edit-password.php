<?php
include('config.php');
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Fetch admin details
$sql = "SELECT * FROM tbl_admin WHERE admin_id = '$admin_id'";
$result = mysqli_query($conn, $sql);
$admin = mysqli_fetch_assoc($result);

// Handle form submission for changing password
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form input values
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if new password and confirm password match
    if ($new_password !== $confirm_password) {
        echo "<script>
                alert('New password and confirm password do not match.');
                window.location.reload();
              </script>";
        exit();
    }

    // Verify current password (you should compare the entered current password with the one stored in the database)
    if ($current_password !== $admin['admin_password']) {
        echo "<script>
                alert('Current password is incorrect.');
                window.location.reload();
              </script>";
        exit();
    }

    // Update the password in the database
    $update_sql = "UPDATE tbl_admin SET admin_password = '$new_password' WHERE admin_id = '$admin_id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>
                alert('Password updated successfully.');
                window.location.reload(); // Refresh page
              </script>";
    } else {
        echo "<script>
                alert('Error updating password: " . mysqli_error($conn) . "');
                window.location.reload();
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password - Admin Panel</title>
    <link rel="stylesheet" href="admin-styles.css">
</head>
<body>

    <header>
        <div class="healthsync-logo">
            <img src="images/Logos/logo3.png" alt="HealthSync Logo" class="logo-img">
        </div>
    </header>

    <section class="edit-password-section">
        <div class="form-container">
            <h2>Update Password</h2>
            <form action="admin-edit-password.php" method="POST">
                <div class="input-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" name="current_password" required>
                </div>

                <div class="input-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" name="new_password" required>
                </div>

                <div class="input-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" name="confirm_password" required>
                </div>

                <button type="submit" class="btn-save">Update Password</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>

</body>
</html>
