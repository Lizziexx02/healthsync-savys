<?php
include('config.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form and sanitize
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    // Mapping form input to schema column 'prod_quantity' 
    $prod_quantity = mysqli_real_escape_string($conn, $_POST['product_quantity']);
    
    // Image upload handling
    $image_dir = "uploads/products/";
    if (!is_dir($image_dir)) {
        mkdir($image_dir, 0777, true);
    }

    $image_name = time() . '_' . $_FILES['product_image']['name']; 
    $image_tmp_name = $_FILES['product_image']['tmp_name'];
    $image_path = $image_dir . basename($image_name);

    if (move_uploaded_file($image_tmp_name, $image_path)) {
        // SQL query matches tbl_products schema attributes exactly [cite: 252-264]
        $sql = "INSERT INTO tbl_products (prod_name, prod_description, prod_price, prod_quantity, prod_image)
                VALUES ('$product_name', '$product_description', '$product_price', '$prod_quantity', '$image_path')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Product added successfully!'); window.location.href='admin-products.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin Panel</title>
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

    <section class="admin-add-product">
        <div class="form-container">
            <h2>Add New Product</h2>
            <form action="admin-add-product.php" method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" id="product_name" placeholder="Enter product name" required>
                </div>

                <div class="input-group">
                    <label for="product_description">Product Description</label>
                    <textarea name="product_description" id="product_description" rows="4" placeholder="Enter product details" required></textarea>
                </div>

                <div class="input-group">
                    <label for="product_price">Product Price (₱)</label>
                    <input type="number" step="0.01" name="product_price" id="product_price" placeholder="0.00" required>
                </div>

                <div class="input-group">
                    <label for="product_quantity">Initial Quantity in Stock</label>
                    <input type="number" name="product_quantity" id="product_quantity" placeholder="0" required>
                </div>

                <div class="input-group">
                    <label for="product_image">Product Image</label>
                    <input type="file" name="product_image" id="product_image" accept="image/*" required>
                    <small>Allowed formats: JPG, PNG, WEBP</small>
                </div>

                <button type="submit" class="btn-save">Save Product</button>
                <a href="admin-products.php" class="btn-cancel">Cancel</a>
            </form>
        </div>
    </section>

    <br>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>
</body>
</html>