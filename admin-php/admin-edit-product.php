<?php
include('config.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

// Get the product ID and ensure it exists
if (!isset($_GET['prod_id'])) {
    header('Location: admin-products.php');
    exit();
}
$prod_id = mysqli_real_escape_string($conn, $_GET['prod_id']);

// Set actor ID for the database trigger
$admin_id = $_SESSION['admin_id'];
mysqli_query($conn, "SET @current_actor_id = $admin_id");

// Fetch the current product details
$sql_product = "SELECT * FROM tbl_products WHERE prod_id = '$prod_id' AND deleted_at IS NULL LIMIT 1";
$result_product = mysqli_query($conn, $sql_product);
$product = mysqli_fetch_assoc($result_product);

if (!$product) {
    header('Location: admin-products.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prod_name = mysqli_real_escape_string($conn, $_POST['prod_name']);
    $prod_description = mysqli_real_escape_string($conn, $_POST['prod_description']);
    $prod_price = mysqli_real_escape_string($conn, $_POST['prod_price']);
    $prod_quantity = mysqli_real_escape_string($conn, $_POST['prod_quantity']);
    
    // Handle image upload
    if (!empty($_FILES['prod_image']['name'])) {
        $image_dir = "uploads/products/";
        if (!is_dir($image_dir)) mkdir($image_dir, 0777, true);
        
        $image_name = time() . '_' . $_FILES['prod_image']['name'];
        $image_tmp_name = $_FILES['prod_image']['tmp_name'];
        $image_path = $image_dir . basename($image_name);

        if (move_uploaded_file($image_tmp_name, $image_path)) {
            // Success: $image_path is set to new file
        } else {
            $image_path = $product['prod_image']; // Fallback
            echo "<script>alert('Error uploading new image. Keeping old one.');</script>";
        }
    } else {
        $image_path = $product['prod_image']; // Keep existing if no file chosen
    }

    // Update Query: Using exact schema names
    $sql_update = "UPDATE tbl_products SET 
        prod_name = '$prod_name', 
        prod_description = '$prod_description', 
        prod_price = '$prod_price', 
        prod_quantity = '$prod_quantity', 
        prod_image = '$image_path' 
        WHERE prod_id = '$prod_id'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Product updated successfully!'); window.location.href='admin-products.php';</script>";
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
    <title>Edit Product - Admin Panel</title>
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

    <section class="admin-edit-product">
        <div class="form-container">
            <h2>Edit Product</h2>
            <form action="admin-edit-product.php?prod_id=<?php echo $product['prod_id']; ?>" method="POST" enctype="multipart/form-data">
                
                <div class="input-group">
                    <label for="prod_name">Product Name</label>
                    <input type="text" name="prod_name" value="<?php echo htmlspecialchars($product['prod_name']); ?>" required>
                </div>

                <div class="input-group">
                    <label for="prod_description">Product Description</label>
                    <textarea name="prod_description" rows="5" required><?php echo htmlspecialchars($product['prod_description']); ?></textarea>
                </div>

                <div class="input-group">
                    <label for="prod_price">Product Price (₱)</label>
                    <input type="number" step="0.01" name="prod_price" value="<?php echo $product['prod_price']; ?>" required>
                </div>

                <div class="input-group">
                    <label for="prod_quantity">Stock Quantity</label>
                    <input type="number" name="prod_quantity" value="<?php echo $product['prod_quantity']; ?>" required>
                </div>

                <div class="input-group">
                    <label>Current Image</label><br>
                    <img src="<?php echo $product['prod_image']; ?>" alt="Current Product Image" style="max-width: 150px; border-radius: 8px; margin-bottom: 10px;">
                    <br>
                    <label for="prod_image">Change Image (Leave blank to keep current)</label>
                    <input type="file" name="prod_image" accept="image/*">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">Save Changes</button>
                </div>
            </form>
        </div>
    </section>

    <br>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>
</body>
</html>