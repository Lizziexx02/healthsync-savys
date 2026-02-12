<?php
include('config.php');
session_start();

// 1. Security Check: Must be logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: user-login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. Validate Order ID
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "Order ID missing.";
    exit();
}

$order_id = mysqli_real_escape_string($conn, $_GET['order_id']);

// 3. Fetch Order Header Details
// We use the data directly from tbl_orders (the snapshot)
$query_order = "SELECT * FROM tbl_orders WHERE order_id = '$order_id' AND usact_id = '$user_id'";
$res_order = mysqli_query($conn, $query_order);

if (mysqli_num_rows($res_order) == 0) {
    echo "Order not found or access denied.";
    exit();
}

$order_info = mysqli_fetch_assoc($res_order);

// 4. Fetch Order Items
$query_items = "SELECT * FROM tbl_order_items WHERE order_id = '$order_id'";
$res_items = mysqli_query($conn, $query_items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - HealthSync</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="user-styles-2.css">
    <style>
        .conf-container { max-width: 800px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .success-banner { text-align: center; color: #28a745; margin-bottom: 30px; }
        .order-details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .order-details-table th, .order-details-table td { border-bottom: 1px solid #ddd; padding: 12px; text-align: left; }
        .summary-box { background: #f9f9f9; padding: 20px; border-radius: 5px; margin-top: 20px; border-left: 5px solid #28a745; }
        .status-badge { display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; }
        .status-pending { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>
    <header>
        <div class="healthsync-logo">
            <img src="images/Logos/logo3.png" alt="HealthSync Logo" class="logo-img">
        </div>
    </header>

    <div class="conf-container">
        <div class="success-banner">
            <h1>Thank You for Your Order!</h1>
            <p>Your order <strong>#<?php echo $order_id; ?></strong> has been placed successfully.</p>
        </div>

        <div class="summary-box">
            <h3>Delivery Details:</h3>
            <p><strong>Recipient:</strong> <?php echo $order_info['usact_fname'] . " " . $order_info['usact_sname']; ?></p>
            <p><strong>Address:</strong> <?php echo $order_info['order_address']; ?></p>
            <p><strong>Phone:</strong> <?php echo $order_info['order_phone']; ?></p>
            <p><strong>Order Status:</strong> <span class="status-badge status-pending"><?php echo $order_info['order_status']; ?></span></p>
            <p><strong>Payment Status:</strong> <?php echo $order_info['payment_status']; ?></p>
        </div>

        <h3>Order Summary</h3>
        <table class="order-details-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while($item = mysqli_fetch_assoc($res_items)): ?>
                <tr>
                    <td><?php echo $item['prod_name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₱<?php echo number_format($item['price_at_purchase'], 2); ?></td>
                    <td>₱<?php echo number_format($item['total_item_price'], 2); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align:right;"><strong>Grand Total:</strong></td>
                    <td><strong>₱<?php echo number_format($order_info['order_total'], 2); ?></strong></td>
                </tr>
            </tfoot>
        </table>

        <div style="margin-top: 30px; text-align: center;">
            <p>Our staff will contact you shortly at <strong><?php echo $order_info['order_phone']; ?></strong> to confirm your payment.</p>
            <button class="btn-confirm" onclick="window.location.href='index.php'">Continue Shopping</button>
        </div>
    </div>
</body>
</html>