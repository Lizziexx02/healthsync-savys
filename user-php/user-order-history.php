<?php
include('config.php');
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: user-login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's order history using JOIN for efficiency
// Matching your columns: order_id, usact_id, order_status, order_date (tbl_orders)
// Matching your columns: prod_name, quantity, price_at_purchase, total_item_price (tbl_order_items)
$query_orders = "
    SELECT 
        o.order_id, o.order_status, o.order_date, o.order_total,
        oi.prod_id, oi.prod_name, oi.quantity, oi.price_at_purchase, oi.total_item_price,
        p.prod_image
    FROM tbl_orders o
    JOIN tbl_order_items oi ON o.order_id = oi.order_id
    LEFT JOIN tbl_products p ON oi.prod_id = p.prod_id
    WHERE o.usact_id = '$user_id' AND o.deleted_at IS NULL
    ORDER BY o.order_date DESC, o.order_id DESC";

$result_orders = mysqli_query($conn, $query_orders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - HealthSync</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="user-styles-3.css">
    <style>
        /* Maintaining your dropdown styles */
        .dropdown { position: relative; display: inline-block; }
        .dropdown-content { 
            display: none; position: absolute; background-color: #f1f1f1; 
            min-width: 160px; box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); 
            z-index: 1; margin-top: 5px; 
        }
        .dropdown:hover .dropdown-content { display: block; }
        .dropdown-content a { color: #590D2E; padding: 12px 16px; text-decoration: none; display: block; }
        .dropdown-content a:hover { background-color: #ddd; }
        
        /* Basic card styling for history */
        .order-card { background: #fff; border-radius: 15px; padding: 20px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .order-header { display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; font-weight: bold; color: #7D1535; }
        .order-item { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; }
        .product-info { display: flex; align-items: center; gap: 15px; }
        .product-info img { width: 60px; height: 60px; object-fit: contain; border-radius: 8px; border: 1px solid #eee; }
        .order-footer { margin-top: 15px; text-align: right; border-top: 1px dashed #ccc; padding-top: 10px; font-size: 1.1rem; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; background: #FFD6D6; color: #7D1535; }
    </style>
</head>
<body>

    <header>
        <div class="healthsync-logo">
            <img src="images/Logos/logo3.png" alt="HealthSync Logo" class="logo-img">
        </div>
        <nav>
            <ul>
                <li><a href="index.php" class="nav-item">Home</a></li>
                <li><a href="user-buy-now.php" class="nav-item">Shop</a></li>
                <li><a href="user-cart.php" class="nav-item">Cart</a></li>
                <li class="dropdown">
                    <a href="#" class="nav-item active">My Account</a>
                    <div class="dropdown-content">
                        <a href="user-my-account.php">Profile</a>
                        <a href="user-order-history.php">Order History</a>
                    </div>
                </li>
                <li><a href="user-logout.php" class="nav-item">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="order-history-section">
        <div class="order-history-container" style="max-width: 800px; margin: 40px auto; padding: 0 20px;">
            <h2 style="color: #590D2E; margin-bottom: 30px;">Your Order History</h2>

            <?php
            if (mysqli_num_rows($result_orders) > 0) {
                $current_order_id = null;
                
                while ($row = mysqli_fetch_assoc($result_orders)) {
                    // Start a new card when order_id changes
                    if ($current_order_id != $row['order_id']) {
                        if ($current_order_id != null) {
                            echo '</div><div class="order-footer"><strong>Order Total: ₱' . number_format($order_total, 2) . '</strong></div>';
                            echo '</div>'; // Close previous order-card
                        }
                        
                        $current_order_id = $row['order_id'];
                        $order_total = $row['order_total']; // From tbl_orders

                        echo '<div class="order-card">';
                        echo '<div class="order-header">';
                        echo '<span>Order #' . $row['order_id'] . '</span>';
                        echo '<span>' . date("M d, Y", strtotime($row['order_date'])) . '</span>';
                        echo '<span class="status-badge">' . $row['order_status'] . '</span>';
                        echo '</div>';
                        echo '<div class="order-items-list">';
                    }

                    // Individual product row (using columns from tbl_order_items)
                    echo '<div class="order-item">';
                    echo '<div class="product-info">';
                    // If product image is missing in p table (deleted), use a placeholder
                    $img_path = !empty($row['prod_image']) ? $row['prod_image'] : 'uploads/products/default.png';
                    echo '<img src="' . $img_path . '" alt="Product">';
                    echo '<div class="product-details">';
                    echo '<div style="font-weight: 600;">' . $row['prod_name'] . '</div>';
                    echo '<div style="font-size: 0.9rem; color: #666;">₱' . number_format($row['price_at_purchase'], 2) . ' x ' . $row['quantity'] . '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="product-total">₱' . number_format($row['total_item_price'], 2) . '</div>';
                    echo '</div>';
                }
                
                // Close the very last order card
                echo '</div><div class="order-footer"><strong>Order Total: ₱' . number_format($order_total, 2) . '</strong></div>';
                echo '</div>'; 
                
            } else {
                echo '<div class="order-card" style="text-align:center;"><p>You haven\'t placed any orders yet.</p></div>';
            }
            ?>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>

</body>
</html>