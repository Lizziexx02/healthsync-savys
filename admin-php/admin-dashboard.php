<?php
include('config.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

// Count total orders from tbl_orders
$sql_orders = "SELECT COUNT(*) AS total_orders FROM tbl_orders";
$result_orders = mysqli_query($conn, $sql_orders);
$total_orders = mysqli_fetch_assoc($result_orders)['total_orders'];

// Sum revenue using correct column names from schema
// status -> order_status
// total_price -> order_total
$sql_revenue = "SELECT SUM(order_total) AS total_revenue FROM tbl_orders WHERE order_status = 'Delivered'";
$result_revenue = mysqli_query($conn, $sql_revenue);
$total_revenue = mysqli_fetch_assoc($result_revenue)['total_revenue'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - HealthSync</title>
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
                <li><a href="admin-dashboard.php" class="nav-item active">Dashboard</a></li>
                <li><a href="admin-products.php" class="nav-item">Manage Products</a></li>
                <li><a href="admin-orders.php" class="nav-item">Manage Orders</a></li>
                <li><a href="admin-users.php" class="nav-item">Manage Users</a></li>
                <li><a href="admin-my-account.php" class="nav-item">My Account</a></li>
                <li><a href="logout.php" class="nav-item">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <section class="dashboard-summary">
        <div class="summary-box">
            <h3>Total Orders</h3>
            <p><?php echo $total_orders; ?></p>
        </div>

        <div class="summary-box">
            <h3>Total Revenue</h3>
            <p>₱<?php echo number_format($total_revenue ?? 0, 2); ?></p>
        </div>
    </section>
</body>
</html>