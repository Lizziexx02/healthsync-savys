<?php
include('config.php');
session_start();

$user_id = $_SESSION['user_id'];

// Check if the address ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "Address ID is missing.";
    exit();
}

$address_id = $_GET['id'];

// Fetch the existing address details for the provided address ID
$sql_address = "SELECT * FROM tbl_addresses WHERE usact_id='$user_id' AND add_id='$address_id'";
$result_address = mysqli_query($conn, $sql_address);
$address = mysqli_fetch_assoc($result_address);

if (!$address) {
    echo "Address not found.";
    exit();
}

// Handle the form submission to update the address
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = mysqli_real_escape_string($conn, $_POST['add_fName']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['add_mName']);
    $surname = mysqli_real_escape_string($conn, $_POST['add_sName']);
    $phone = mysqli_real_escape_string($conn, $_POST['add_phone']);
    $street_address = mysqli_real_escape_string($conn, $_POST['add_street_addr']);
    $postal_code = mysqli_real_escape_string($conn, $_POST['add_postal_code']);
    $barangay = mysqli_real_escape_string($conn, $_POST['add_barangay']);
    $city = mysqli_real_escape_string($conn, $_POST['add_city']);
    $province = mysqli_real_escape_string($conn, $_POST['add_province']);
    $region = mysqli_real_escape_string($conn, $_POST['add_region']);
    $is_default = isset($_POST['add_is_default']) ? 1 : 0;

    // Update the address in the database
    $update_sql = "UPDATE tbl_addresses SET
                    add_fName='$first_name', 
                    add_mName='$middle_name', 
                    add_sName='$surname', 
                    add_phone='$phone',
                    add_street_addr='$street_address', 
                    add_postal_code='$postal_code', 
                    add_barangay='$barangay', 
                    add_city='$city', 
                    add_province='$province', 
                    add_region='$region', 
                    add_is_default='$is_default'
                    WHERE add_id='$address_id' AND usact_id='$user_id'";

    if (mysqli_query($conn, $update_sql)) {
        header('Location: user-my-account.php');  // Redirect to account page
        exit();
    } else {
        echo "Error updating address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Address - HealthSync</title>
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

    <br>

    <section class="edit-address-page">
        <div class="form-container">
            <h2>Edit Address</h2>

            <form action="user-edit-address.php?id=<?php echo $address['add_id']; ?>" method="POST">
                <!-- Name -->
                <div class="input-group double-input">
                    <div class="input-half">
                        <label for="first-name">First name</label>
                        <input type="text" name="add_fName" value="<?php echo $address['add_fName']; ?>" required>
                    </div>
                    <div class="input-half">
                        <label for="last-name">Last name</label>
                        <input type="text" name="add_sName" value="<?php echo $address['add_sName']; ?>" required>
                    </div>
                </div>

                <!-- Middle Name -->
                <div class="input-group">
                    <label for="middle-name">Middle Name</label>
                    <input type="text" name="add_mName" value="<?php echo $address['add_mName']; ?>">
                </div>

                <!-- Phone -->
                <div class="input-group">
                    <label for="phone">Phone</label>
                    <input type="tel" name="add_phone" value="<?php echo $address['add_phone']; ?>" required>
                </div>

                <!-- Address -->
                <div class="input-group">
                    <label for="address">Street Address</label>
                    <input type="text" name="add_street_addr" value="<?php echo $address['add_street_addr']; ?>" required>
                </div>

                <!-- Postal Code -->
                <div class="input-group">
                    <label for="postal-code">Postal Code</label>
                    <input type="text" name="add_postal_code" value="<?php echo $address['add_postal_code']; ?>" required>
                </div>

                <!-- Barangay -->
                <div class="input-group">
                    <label for="barangay">Barangay</label>
                    <input type="text" name="add_barangay" value="<?php echo $address['add_barangay']; ?>" required>
                </div>

                <!-- City -->
                <div class="input-group">
                    <label for="city">City</label>
                    <input type="text" name="add_city" value="<?php echo $address['add_city']; ?>" required>
                </div>

                <!-- Province -->
                <div class="input-group">
                    <label for="province">Province</label>
                    <input type="text" name="add_province" value="<?php echo $address['add_province']; ?>" required>
                </div>

                <!-- Region -->
                <div class="input-group">
                    <label for="region">Region</label>
                    <input type="text" name="add_region" value="<?php echo $address['add_region']; ?>" required>
                </div>

                <!-- Default Address Checkbox -->
                <div class="input-group">
                    <label>
                        <input type="checkbox" name="add_is_default" <?php echo $address['add_is_default'] ? 'checked' : ''; ?>>
                        Set as Default Address
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-save">Update Address</button>
            </form>
        </div>
    </section>

    <br>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>
</body>
</html>
