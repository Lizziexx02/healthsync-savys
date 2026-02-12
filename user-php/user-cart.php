<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: user-login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items from DB
$query = "SELECT c.prod_id, c.cart_quantity, p.prod_name, p.prod_price, p.prod_image 
          FROM tbl_cart c 
          JOIN tbl_products p ON c.prod_id = p.prod_id 
          WHERE c.usact_id = '$user_id'";

$result = mysqli_query($conn, $query);

// Syncing with session
$_SESSION['cart'] = array(); 
while ($row = mysqli_fetch_assoc($result)) {
    $_SESSION['cart'][$row['prod_id']] = [
        'prod_name' => $row['prod_name'],
        'prod_price' => $row['prod_price'],
        'prod_image' => $row['prod_image'],
        'cart_quantity' => $row['cart_quantity']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - HealthSync</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="user-styles-2.css">
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
                <li><a href="user-cart.php" class="nav-item active">Cart</a></li>
                <li><a href="user-my-account.php" class="nav-item">My Account</a></li>
                <li><a href="user-logout.php" class="nav-item">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="cart-section">
        <div class="cart-container">
            <h2 class="cart-title">Shopping Cart</h2>

            <div class="cart-header-labels">
                <span class="label-prod">Products</span>
                <span class="label-qty">Quantity</span>
                <span class="label-total">Total</span>
                <span class="label-remove">Remove</span>
            </div>

            <hr class="cart-divider">

            <div id="cart-items-wrapper">
                <?php if (!empty($_SESSION['cart'])): ?>
                    <?php foreach ($_SESSION['cart'] as $prod_id => $item): ?>
                        <div class="cart-item" data-prod-id="<?php echo $prod_id; ?>">
                            <div class="product-info">
                                <img src="<?php echo $item['prod_image']; ?>" alt="Product">
                                <div class="product-details">
                                    <h3><?php echo $item['prod_name']; ?></h3>
                                    <p>₱<?php echo number_format($item['prod_price'], 2); ?></p>
                                </div>
                            </div>

                            <div class="quantity-control">
                                <button type="button" class="qty-btn" onclick="updateQuantity(<?php echo $prod_id; ?>, -1)">-</button>
                                <input type="number" value="<?php echo $item['cart_quantity']; ?>" readonly>
                                <button type="button" class="qty-btn" onclick="updateQuantity(<?php echo $prod_id; ?>, 1)">+</button>
                            </div>

                            <div class="total-price">
                                <p>₱<?php echo number_format($item['prod_price'] * $item['cart_quantity'], 2); ?></p>
                            </div>

                            <div class="remove-item">
                                <button onclick="removeItem(<?php echo $prod_id; ?>)">Remove</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align:center; padding: 20px;">Your cart is empty.</p>
                <?php endif; ?>
            </div>

            <hr class="cart-divider">

            <div class="cart-footer">
                <div class="terms-container">
                    <input type="checkbox" id="terms">
                    <label for="terms">I have reviewed the order summary and agree to the Terms and Conditions.</label>
                </div>
                <button class="btn-checkout" id="checkoutBtn">Checkout</button>
                <button class="btn-clear-cart" onclick="clearCart()">Clear Cart</button>
            </div>
        </div>
    </section>

    <script>
    function updateQuantity(prod_id, change) {
        window.location.href = 'update-cart.php?prod_id=' + prod_id + '&change=' + change;
    }

    function removeItem(prod_id) {
        if(confirm("Remove this item?")) {
            window.location.href = 'remove-cart-item.php?prod_id=' + prod_id;
        }
    }

    function clearCart() {
        if(confirm("Clear your entire cart?")) {
            window.location.href = 'clear-cart.php';
        }
    }

    document.getElementById('checkoutBtn').addEventListener('click', function() {
        const isChecked = document.getElementById('terms').checked;
        if (!isChecked) {
            alert("Please agree to the Terms & Conditions.");
            return;
        }
        window.location.href = 'user-checkout.php';
    });
    </script>
</body>
</html>