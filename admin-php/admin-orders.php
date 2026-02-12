<?php
include('config.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

// Fetch all orders including the new name columns from tbl_orders
// We use 'WHERE deleted_at IS NULL' to exclude soft-deleted orders
$sql_orders = "SELECT order_id, order_date, order_status, order_total, payment_status, usact_fname, usact_sname 
               FROM tbl_orders 
               WHERE deleted_at IS NULL 
               ORDER BY order_date DESC";
$result_orders = mysqli_query($conn, $sql_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin Panel</title>
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
                <li><a href="admin-orders.php" class="nav-item active">Manage Orders</a></li>
                <li><a href="admin-users.php" class="nav-item">Manage Users</a></li>
                <li><a href="admin-my-account.php" class="nav-item">My Account</a></li>
                <li><a href="logout.php" class="nav-item">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <section class="admin-orders">
        <h2>Manage Orders</h2>

        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User Full Name</th> <th>Order Date</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = mysqli_fetch_assoc($result_orders)) { 
                    // Concatenate fname and sname for display
                    $full_name = $order['usact_fname'] . " " . $order['usact_sname'];
                ?>
                    <tr>
                        <td>#<?php echo $order['order_id']; ?></td>
                        <td><?php echo $full_name; ?></td> 
                        <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                        <td>₱<?php echo number_format($order['order_total'], 2); ?></td>
                        <td>
                            <span class="status-badge <?php echo strtolower(str_replace(' ', '-', $order['order_status'])); ?>">
                                <?php echo $order['order_status']; ?>
                            </span>
                        </td>
                        <td><?php echo $order['payment_status']; ?></td>
                        <td>
                            <a href="admin-view-order.php?order_id=<?php echo $order['order_id']; ?>">View</a> | 
                            <a href="admin-update-order.php?order_id=<?php echo $order['order_id']; ?>">Update</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
</body>
</html>