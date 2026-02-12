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

// Fetch current data
$sql_order = "SELECT * FROM tbl_orders WHERE order_id = '$order_id'";
$result_order = mysqli_query($conn, $sql_order);
$order = mysqli_fetch_assoc($result_order);

if (!$order) {
    echo "Order not found.";
    exit();
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_status = mysqli_real_escape_string($conn, $_POST['order_status']);
    $payment_status = mysqli_real_escape_string($conn, $_POST['payment_status']);

    // Update both columns in tbl_orders
    $sql_update = "UPDATE tbl_orders 
                   SET order_status = '$order_status', 
                       payment_status = '$payment_status' 
                   WHERE order_id = '$order_id'";

    if (mysqli_query($conn, $sql_update)) {
        // Redirect back to view order so admin can see changes
        header("Location: admin-view-order.php?order_id=" . $order_id);
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
    <title>Update Order #<?php echo $order_id; ?> - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin-styles.css">
    <style>
        .form-container { max-width: 500px; margin: 50px auto; padding: 30px; background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #590D2E; }
        .input-group select { width: 100%; padding: 12px; border: 1px solid #FFD6D6; border-radius: 8px; font-family: 'Poppins', sans-serif; }
        .btn-save { width: 100%; background: linear-gradient(90deg, #FF8FAB 0%, #FF64D4 100%); color: white; padding: 12px; border: none; border-radius: 30px; font-weight: 700; cursor: pointer; transition: 0.3s; }
        .btn-save:hover { opacity: 0.9; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #FF8FAB; text-decoration: none; font-size: 14px; }
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

    <section class="admin-edit-order">
        <div class="form-container">
            <h2>Update Status</h2>
            <p style="margin-bottom: 20px; font-size: 14px; color: #666;">Editing Order ID: <strong>#<?php echo $order['order_id']; ?></strong></p>
            
            <form action="admin-update-order.php?order_id=<?php echo $order['order_id']; ?>" method="POST">
                
                <div class="input-group">
                    <label for="order_status">Order Status</label>
                    <select name="order_status" id="order_status">
                        <option value="Pending" <?php if ($order['order_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Ready for Pickup" <?php if ($order['order_status'] == 'Ready for Pickup') echo 'selected'; ?>>Ready for Pickup</option>
                        <option value="Shipped" <?php if ($order['order_status'] == 'Shipped') echo 'selected'; ?>>Shipped</option>
                        <option value="Delivered" <?php if ($order['order_status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                        <option value="Cancelled" <?php if ($order['order_status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                    </select>
                </div>

                <div class="input-group">
                    <label for="payment_status">Payment Status</label>
                    <select name="payment_status" id="payment_status">
                        <option value="Unpaid" <?php if ($order['payment_status'] == 'Unpaid') echo 'selected'; ?>>Unpaid</option>
                        <option value="Paid" <?php if ($order['payment_status'] == 'Paid') echo 'selected'; ?>>Paid</option>
                        <option value="Refunded" <?php if ($order['payment_status'] == 'Refunded') echo 'selected'; ?>>Refunded</option>
                    </select>
                </div>

                <button type="submit" class="btn-save">Save Changes</button>
                <a href="admin-view-order.php?order_id=<?php echo $order['order_id']; ?>" class="back-link">Cancel and Go Back</a>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>
</body>
</html>