<?php
include('config.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

$usact_id = mysqli_real_escape_string($conn, $_GET['usact_id']);

$sql_user = "SELECT * FROM tbl_user_account WHERE usact_id = '$usact_id'";
$result_user = mysqli_query($conn, $sql_user);
$user = mysqli_fetch_assoc($result_user);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usact_username = mysqli_real_escape_string($conn, $_POST['usact_username']);
    $usact_email = mysqli_real_escape_string($conn, $_POST['usact_email']);

    $sql_update = "UPDATE tbl_user_account SET usact_username = '$usact_username', usact_email = '$usact_email' WHERE usact_id = '$usact_id'";

    if (mysqli_query($conn, $sql_update)) {
        header('Location: admin-users.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin-styles.css">
</head>
<body>
    <header>
        <div class="healthsync-logo">
            <img src="images/Logos/logo3.png" alt="HealthSync Logo" class="logo-img">
        </div>
        <nav>
            <ul>
                <li><a href="admin-dashboard.php" class="nav-item">Dashboard</a></li>
                <li><a href="admin-products.php" class="nav-item">Manage Products</a></li>
                <li><a href="admin-orders.php" class="nav-item">Manage Orders</a></li>
                <li><a href="admin-users.php" class="nav-item active">Manage Users</a></li>
                <li><a href="admin-my-account.php" class="nav-item">My Account</a></li>
                <li><a href="logout.php" class="nav-item">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <section class="admin-edit-user">
        <h2>Edit User</h2>
        <form action="admin-edit-user.php?usact_id=<?php echo $user['usact_id']; ?>" method="POST">
            <div class="input-group">
                <label for="usact_username">Username</label>
                <input type="text" name="usact_username" value="<?php echo $user['usact_username']; ?>" required>
            </div>

            <div class="input-group">
                <label for="usact_email">User Email</label>
                <input type="email" name="usact_email" value="<?php echo $user['usact_email']; ?>" required>
            </div>

            <button type="submit" class="btn-update">Update User</button>
            <a href="admin-users.php" class="btn-cancel" style="margin-left: 10px; text-decoration: none; color: #666;">Cancel</a>
        </form>
    </section>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>
</body>
</html>