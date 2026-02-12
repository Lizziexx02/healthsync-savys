<?php
include('config.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

// Fetch all products that are NOT soft deleted
// Selecting all attributes to ensure we have access to full product details [cite: 1]
$sql_products = "SELECT * FROM tbl_products WHERE deleted_at IS NULL";
$result_products = mysqli_query($conn, $sql_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Admin Panel</title>
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
                <li><a href="admin-products.php" class="nav-item active">Manage Products</a></li>
                <li><a href="admin-orders.php" class="nav-item">Manage Orders</a></li>
                <li><a href="admin-users.php" class="nav-item">Manage Users</a></li>
                <li><a href="admin-my-account.php" class="nav-item">My Account</a></li>
                <li><a href="logout.php" class="nav-item">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <br>

    <section class="manage-products">
        <h2>Manage Products</h2>

        <a href="admin-add-product.php" class="btn-add-product">Add New Product</a>

        <table class="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = mysqli_fetch_assoc($result_products)) { ?>
                    <tr>
                        <td><?php echo $product['prod_id']; ?></td>
                        <td><?php echo $product['prod_name']; ?></td>
                        <td><?php echo $product['prod_description']; ?></td>
                        <td>₱<?php echo number_format($product['prod_price'], 2); ?></td>
                        <td><?php echo $product['prod_quantity']; ?></td>
                        <td>
                            <a href="admin-edit-product.php?prod_id=<?php echo $product['prod_id']; ?>" class="btn-edit">Edit</a> | 
                            <a href="admin-delete-product.php?prod_id=<?php echo $product['prod_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>

</body>
</html>