<?php
include('config.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

if (!isset($_GET['order_id'])) {
    header('Location: admin-orders.php');
    exit();
}

$order_id = mysqli_real_escape_string($conn, $_GET['order_id']);

// 1. Fetch Order & User details (Using CONCAT for the name)
$sql_order = "SELECT o.*, 
              CONCAT(u.usact_fName, ' ', u.usact_sName) AS customer_name, 
              u.usact_email 
              FROM tbl_orders o 
              JOIN tbl_user_account u ON o.usact_id = u.usact_id 
              WHERE o.order_id = '$order_id'";
$result_order = mysqli_query($conn, $sql_order);
$order = mysqli_fetch_assoc($result_order);

if (!$order) {
    echo "Order not found.";
    exit();
}

// 2. Fetch the actual items in the order
$sql_items = "SELECT * FROM tbl_order_items WHERE order_id = '$order_id'";
$result_items = mysqli_query($conn, $sql_items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Order #<?php echo $order_id; ?> - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin-styles.css">
    <style>
        .order-details { padding: 40px; max-width: 900px; margin: 20px auto; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .order-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .order-table td { padding: 12px; border-bottom: 1px solid #f0f0f0; color: #590D2E; }
        
        .items-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .items-table th { background: #FFB3C1; color: #590D2E; padding: 10px; text-align: left; }
        .items-table td { padding: 10px; border-bottom: 1px solid #FFD6D6; }

        .admin-actions { margin-top: 30px; display: flex; gap: 15px; }
        .btn-action { padding: 12px 25px; text-decoration: none; border-radius: 30px; font-weight: 600; font-size: 14px; transition: 0.3s; }
        .btn-edit { background: #590D2E; color: white; }
        .btn-update { background: linear-gradient(90deg, #FF8FAB 0%, #FF64D4 100%); color: white; }
        .btn-edit:hover, .btn-update:hover { opacity: 0.9; transform: translateY(-2px); }
    </style>
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
                <li><a href="logout.php" class="nav-item">Log Out</a></li>
            </ul>
        </nav>
    </header>

   <section class="order-details">
        <h2>Order #<?php echo $order['order_id']; ?></h2>

        <table class="order-table">
            <tr>
                <td><strong>Customer:</strong></td>
                <td><?php echo $order['customer_name']; ?> (<?php echo $order['usact_email']; ?>)</td>
                <td><strong>Date:</strong></td>
                <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
            </tr>
            <tr>
                <td><strong>Address:</strong></td>
                <td><?php echo $order['order_address']; ?></td>
                <td><strong>Phone:</strong></td>
                <td><?php echo $order['order_phone']; ?></td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>
                    <?php echo $order['order_status']; ?>
                </td>
                <td><strong>Payment:</strong></td>
                <td>
                    <?php echo $order['payment_status']; ?>
                </td>
            </tr>
        </table>

        <h3>Items Ordered</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while($item = mysqli_fetch_assoc($result_items)): ?>
                <tr>
                    <td><?php echo $item['prod_name']; ?></td>
                    <td>₱<?php echo number_format($item['price_at_purchase'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₱<?php echo number_format($item['total_item_price'], 2); ?></td>
                </tr>
                <?php endwhile; ?>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Grand Total:</strong></td>
                    <td><strong>₱<?php echo number_format($order['order_total'], 2); ?></strong></td>
                </tr>
            </tbody>
        </table>

        <div class="admin-actions">
            <a href="admin-update-order.php?order_id=<?php echo $order['order_id']; ?>" class="btn-action btn-update">Update Order & Payment</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>
</body>
</html>