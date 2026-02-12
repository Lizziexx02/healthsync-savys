<?php
ob_start(); 
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: user-login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// 1. Fetch User Data
$query_user = "SELECT usact_fName, usact_mName, usact_sName, usact_email FROM tbl_user_account WHERE usact_id = '$user_id'";
$result_user = mysqli_query($conn, $query_user);
$row_user = mysqli_fetch_assoc($result_user);
$full_name = $row_user['usact_fName'] . " " . ($row_user['usact_mName'] ? $row_user['usact_mName'] . " " : "") . $row_user['usact_sName'];
$email = $row_user['usact_email'];

// 2. Fetch Saved Addresses for Dropdown
$saved_addresses = mysqli_query($conn, "SELECT * FROM tbl_addresses WHERE usact_id = '$user_id' ORDER BY add_id DESC");

function calculateOrderTotal($user_id) {
    global $conn;
    $query_cart = "SELECT c.cart_quantity, p.prod_price FROM tbl_cart c JOIN tbl_products p ON c.prod_id = p.prod_id WHERE c.usact_id = '$user_id'";
    $result_cart = mysqli_query($conn, $query_cart);
    $total = 0;
    while ($row = mysqli_fetch_assoc($result_cart)) {
        $total += $row['cart_quantity'] * $row['prod_price'];
    }
    return $total;
}

// 3. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $street = mysqli_real_escape_string($conn, $_POST['street_address']);
    $postal = mysqli_real_escape_string($conn, $_POST['postal_code']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $province = mysqli_real_escape_string($conn, $_POST['province']);
    $region = mysqli_real_escape_string($conn, $_POST['region']);
    $shipping_method = mysqli_real_escape_string($conn, $_POST['shipping_method']);
    $saved_add_id = mysqli_real_escape_string($conn, $_POST['saved_address_id']);

    // Since tbl_orders has no 'shipping_method' column, we append it to the address snapshot
    $full_address_text = "$street, $barangay, $city, $province, $region, $postal (Method: $shipping_method)";

    // --- STEP 1: ADDRESS HANDLING ---
    if (!empty($saved_add_id)) {
        $add_id = $saved_add_id;
    } else {
        $ins_addr = "INSERT INTO tbl_addresses (usact_id, add_fName, add_mName, add_sName, add_phone, add_street_addr, add_postal_code, add_barangay, add_city, add_province, add_region)
                     VALUES ('$user_id', '$first_name', '$middle_name', '$last_name', '$phone', '$street', '$postal', '$barangay', '$city', '$province', '$region')";
        if (!mysqli_query($conn, $ins_addr)) { die("Address Table Error: " . mysqli_error($conn)); }
        $add_id = mysqli_insert_id($conn);
    }

    // --- STEP 2: CREATE ORDER (Matching your exact DB columns) ---
    $order_total = calculateOrderTotal($user_id);
    
    // SQL matches columns 1-10 in your screenshot: order_id(auto), usact_id, usact_fname, usact_sname, add_id, order_address, order_phone, order_total, order_status, payment_status
    $ins_order = "INSERT INTO tbl_orders (usact_id, usact_fname, usact_sname, add_id, order_address, order_phone, order_total, order_status, payment_status)
                  VALUES ('$user_id', '$first_name', '$last_name', '$add_id', '$full_address_text', '$phone', '$order_total', 'Pending', 'Unpaid')";

    if (mysqli_query($conn, $ins_order)) {
        $order_id = mysqli_insert_id($conn);

        // --- STEP 3: MOVE ITEMS ---
        $cart_items = mysqli_query($conn, "SELECT c.prod_id, c.cart_quantity, p.prod_name, p.prod_price FROM tbl_cart c JOIN tbl_products p ON c.prod_id = p.prod_id WHERE c.usact_id = '$user_id'");
        while ($item = mysqli_fetch_assoc($cart_items)) {
            $p_id = $item['prod_id'];
            $p_name = mysqli_real_escape_string($conn, $item['prod_name']);
            $qty = $item['cart_quantity'];
            $price = $item['prod_price'];
            $subtotal = $price * $qty;

            // Adjust these column names to match your tbl_order_items if they differ
            $ins_item = "INSERT INTO tbl_order_items (order_id, prod_id, prod_name, quantity, price_at_purchase, total_item_price)
                         VALUES ('$order_id', '$p_id', '$p_name', '$qty', '$price', '$subtotal')";
            mysqli_query($conn, $ins_item);
        }

        // --- STEP 4: CLEANUP ---
        mysqli_query($conn, "DELETE FROM tbl_cart WHERE usact_id = '$user_id'");
        header("Location: user-confirmation.php?order_id=" . $order_id);
        exit();
    } else {
        die("Order Table Error: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - HealthSync</title>
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
                <li><a href="user-buy-now.php" class="nav-item">Products</a></li>
                <li><a href="user-cart.php" class="nav-item">Cart</a></li>
                <li><a href="user-my-account.php" class="nav-item">My Account</a></li>
            </ul>
        </nav>
    </header>

    <section class="checkout-section">
        <div class="checkout-container">
            <h2>Information</h2>
            <form action="user-checkout.php" method="POST" id="checkoutForm">
                <input type="hidden" name="saved_address_id" id="saved_address_id" value="">

                <div class="contact-section">
                    <h3>Contact</h3>
                    <p><?php echo $full_name; ?> (<?php echo $email; ?>)</p>
                </div>

                <div class="shipping-address">
                    <h3>Shipping Address</h3>
                    
                    <select id="address_selector" class="nav-item" style="width: 100%; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                        <option value="">-- Use a new address --</option>
                        <?php while($addr = mysqli_fetch_assoc($saved_addresses)): ?>
                            <option value='<?php echo json_encode($addr); ?>'>
                                <?php echo $addr['add_street_addr'] . ", " . $addr['add_city']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <div class="address-fields">
                        <input type="text" name="first_name" id="f_name" placeholder="First Name" required>
                        <input type="text" name="middle_name" id="m_name" placeholder="Middle Name (optional)">
                        <input type="text" name="last_name" id="l_name" placeholder="Last Name" required>
                        <input type="text" name="phone" id="phone" placeholder="Phone Number" required>
                        <input type="text" name="street_address" id="street" placeholder="Street Address" required>
                        <input type="text" name="postal_code" id="postal" placeholder="Postal Code" required>
                        <input type="text" name="barangay" id="barangay" placeholder="Barangay" required>
                        <input type="text" name="city" id="city" placeholder="City" required>
                        <input type="text" name="province" id="province" placeholder="Province" required>
                        <input type="text" name="region" id="region" placeholder="Region" required>
                    </div>
                </div>

                <div class="shipping-method">
                    <h3>Shipping Method</h3>
                    <label>
                        <input type="radio" name="shipping_method" value="own_delivery" required> Book Your Own Delivery
                        <p>You will book and pay for your own delivery service.</p>
                    </label>
                    <label>
                        <input type="radio" name="shipping_method" value="store_pickup" required> Pick Up In Store
                        <p>Orders can be picked up at 123 Tomas Mapua St., Manila.</p>
                    </label>
                </div>

                <div class="payment-method">
                    <h3>Payment Method</h3>
                    <p>After confirming your order, our staff will personally call you regarding the payment method. Please wait for our call.</p>
                </div>

                <div class="buttons">
                    <button type="button" class="btn-return" onclick="window.location.href='user-cart.php'">Return to cart</button>
                    <button type="submit" class="btn-confirm">Confirm</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.getElementById('address_selector').addEventListener('change', function() {
            const savedIdField = document.getElementById('saved_address_id');
            if (this.value !== "") {
                const addr = JSON.parse(this.value);
                savedIdField.value = addr.add_id; 
                document.getElementById('f_name').value = addr.add_fName;
                document.getElementById('m_name').value = addr.add_mName || "";
                document.getElementById('l_name').value = addr.add_sName;
                document.getElementById('phone').value = addr.add_phone;
                document.getElementById('street').value = addr.add_street_addr;
                document.getElementById('postal').value = addr.add_postal_code;
                document.getElementById('barangay').value = addr.add_barangay;
                document.getElementById('city').value = addr.add_city;
                document.getElementById('province').value = addr.add_province;
                document.getElementById('region').value = addr.add_region;
            } else {
                savedIdField.value = "";
                document.getElementById('checkoutForm').reset();
            }
        });
    </script>
</body>
</html>