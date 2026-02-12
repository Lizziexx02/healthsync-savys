<?php
include('config.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

$sql_users = "SELECT * FROM tbl_user_account WHERE deleted_at IS NULL ORDER BY usact_id DESC";
$result_users = mysqli_query($conn, $sql_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>
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

    <br>

    <section class="admin-users">
        <h2>Manage Users</h2>

        <table class="users-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($result_users)) { ?>
                    <tr>
                        <td><?php echo $user['usact_id']; ?></td>
                        <td><strong><?php echo $user['usact_username']; ?></strong></td>
                        <td><?php echo $user['usact_email']; ?></td>
                        <td>
                            <a href="admin-edit-user.php?usact_id=<?php echo $user['usact_id']; ?>" class="btn-edit">Edit</a> |
                            <a href="admin-delete-user.php?usact_id=<?php echo $user['usact_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>

</body>
</html>