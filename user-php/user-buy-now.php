<?php
include('config.php');
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: user-login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Since you are selling just one specific product, we fetch ID 1
$product_id = 1; 

// Fetch product details using prefixes (prod_)
$sql_product = "SELECT * FROM tbl_products WHERE prod_id = '$product_id' LIMIT 1";
$result_product = mysqli_query($conn, $sql_product);
$product = mysqli_fetch_assoc($result_product);

// Handle "Order Now" (Add to Cart logic)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    // Check if item already exists in cart for this user
    $check_cart = "SELECT * FROM tbl_cart WHERE usact_id = '$user_id' AND prod_id = '$product_id'";
    $res_check = mysqli_query($conn, $check_cart);

    if (mysqli_num_rows($res_check) > 0) {
        // Update quantity if already in cart
        $sql_action = "UPDATE tbl_cart SET cart_quantity = cart_quantity + $quantity WHERE usact_id = '$user_id' AND prod_id = '$product_id'";
    } else {
        // Insert new cart record
        $sql_action = "INSERT INTO tbl_cart (usact_id, prod_id, cart_quantity) VALUES ('$user_id', '$product_id', '$quantity')";
    }

    if (mysqli_query($conn, $sql_action)) {
        // Redirect to cart page after successful add
        header('Location: user-cart.php');
        exit();
    } else {
        echo "Error adding to cart: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['prod_name']; ?> - HealthSync</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="user-styles-2.css">
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            margin-top: 5px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: #590D2E;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }
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
                <li><a href="user-buy-now.php" class="nav-item active">Shop</a></li>
                <li><a href="user-cart.php" class="nav-item">Cart</a></li>
                <li class="dropdown">
                    <a href="#" class="nav-item">My Account</a>
                    <div class="dropdown-content">
                        <a href="user-my-account.php" >Profile</a>
                        <a href="user-order-history.php">Order History</a>
                    </div>
                </li>
                <li><a href="user-logout.php" class="nav-item">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="product-info-section">
        <div class="product-card">
            <div class="product-image-box">
                <img src="<?php echo $product['prod_image']; ?>" alt="Product Image">
            </div>
            <div class="product-details-box">
                <h2><?php echo $product['prod_name']; ?></h2>
                <p class="price">₱<?php echo number_format($product['prod_price'], 2); ?></p>
                
                <div class="description-section">
                    <h4>Description</h4>
                    <p><?php echo $product['prod_description']; ?></p>
                </div>

                <form action="user-buy-now.php" method="POST">
                    <div class="qty-input-row">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="1" value="1" required>
                    </div>
                    <button type="submit" class="btn-order-now">Order Now</button>
                </form>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>

    <script>
        // Dropdown toggle script
        const dropdown = document.querySelector('.dropdown');
        const menu = document.querySelector('.dropdown-content');

        dropdown.addEventListener('mouseover', () => {
            menu.style.display = 'block';
        });

        dropdown.addEventListener('mouseleave', () => {
            menu.style.display = 'none';
        });
    </script>

</body>
</html>