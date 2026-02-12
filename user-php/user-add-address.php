<?php
include('config.php');
session_start();

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $first_name = mysqli_real_escape_string($conn, $_POST['first-name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle-name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last-name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $street_address = mysqli_real_escape_string($conn, $_POST['street-address']);
    $postal_code = mysqli_real_escape_string($conn, $_POST['postal-code']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $province = mysqli_real_escape_string($conn, $_POST['province']);
    $region = mysqli_real_escape_string($conn, $_POST['region']);
    $is_default = isset($_POST['default']) ? 1 : 0;

    // Insert into tbl_addresses
    $insert_sql = "INSERT INTO tbl_addresses (usact_id, add_fName, add_mName, add_sName, add_phone, add_street_addr, add_postal_code, add_barangay, add_city, add_province, add_region, add_is_default) 
                   VALUES ('$user_id', '$first_name', '$middle_name', '$last_name', '$phone', '$street_address', '$postal_code', '$barangay', '$city', '$province', '$region', '$is_default')";

    if (mysqli_query($conn, $insert_sql)) {
        header('Location: user-my-account.php');  // Redirect to account page
        exit();
    } else {
        echo "Error adding address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Address - HealthSync</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="user-styles-3.css">
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
                <li><a href="user-buy-now.php" class="nav-item">Shop</a></li>
                <li><a href="user-cart.php" class="nav-item">Cart</a></li>
                <li class="dropdown">
                    <a href="#" class="nav-item active">My Account</a>
                    <div class="dropdown-content">
                        <a href="user-my-account.php" >Profile</a>
                        <a href="user-order-history.php">Order History</a>
                    </div>
                </li>
                <li><a href="user-logout.php" class="nav-item">Logout</a></li>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Add Address Form Page -->
    <section class="add-address-page">
        <div class="form-container">
            <h2>Add Address</h2>

            <form action="user-add-address.php" method="POST">
                <!-- Name -->
                <div class="input-group double-input">
                    <div class="input-half">
                        <label for="first-name">First name</label>
                        <input type="text" name="first-name" id="first-name" required>
                    </div>
                    <div class="input-half">
                        <label for="last-name">Last name</label>
                        <input type="text" name="last-name" id="last-name" required>
                    </div>
                </div>

                <!-- Middle Name -->
                <div class="input-group">
                    <label for="middle-name">Middle Name</label>
                    <input type="text" name="middle-name" id="middle-name">
                </div>

                <!-- Phone -->
                <div class="input-group">
                    <label for="phone">Phone</label>
                    <input type="tel" name="phone" id="phone" required>
                </div>

                <!-- Address -->
                <div class="input-group">
                    <label for="street-address">Street Address</label>
                    <input type="text" name="street-address" id="street-address" required>
                </div>

                <!-- Postal Code -->
                <div class="input-group">
                    <label for="postal-code">Postal Code</label>
                    <input type="text" name="postal-code" id="postal-code" required>
                </div>

                <!-- Barangay -->
                <div class="input-group">
                    <label for="barangay">Barangay</label>
                    <input type="text" name="barangay" id="barangay" required>
                </div>

                <!-- City -->
                <div class="input-group">
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" required>
                </div>

                <!-- Province -->
                <div class="input-group">
                    <label for="province">Province</label>
                    <input type="text" name="province" id="province" required>
                </div>

                <!-- Region -->
                <div class="input-group">
                    <label for="region">Region</label>
                    <input type="text" name="region" id="region" required>
                </div>

                <!-- Default Address Checkbox -->
                <div class="input-group">
                    <label>
                        <input type="checkbox" name="default" id="default">
                        Set as Default Address
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-save">Add Address</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>
</body>
</html>
