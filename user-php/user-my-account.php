<?php 
include('config.php');
session_start();

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    header('Location: user-login.php');
    exit();
}

// Fetch user details
$sql = "SELECT * FROM tbl_user_account WHERE usact_id='$user_id' AND deleted_at IS NULL";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Fetch saved addresses (limit to 3 addresses)
$address_sql = "SELECT * FROM tbl_addresses WHERE usact_id='$user_id'";
$address_result = mysqli_query($conn, $address_sql);
$address_count = mysqli_num_rows($address_result);

// Check if the user has 3 saved addresses
$max_addresses = 3;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - HealthSync</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="user-styles-3.css">
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
            </ul>
        </nav>
    </header>

    <section class="account-section">
        <div class="account-container">
            <h2>Profile</h2>
            <div class="account-info">
                <div class="info-item">
                    <label for="name">Name:</label>
                    <span>
                        <?php 
                            $middle = (!empty($user['usact_mName'])) ? $user['usact_mName'] . ' ' : '';
                            echo htmlspecialchars($user['usact_fName'] . ' ' . $middle . $user['usact_sName']); 
                        ?>
                    </span>
                    <button class="edit-link" id="editNameBtn">Edit</button>
                </div>

                <div class="info-item">
                    <label for="email">Email:</label>
                    <span><?php echo $user['usact_email']; ?></span>
                    <button class="edit-link" id="editEmailBtn">Edit</button>
                </div>
            </div>

            <div class="addresses-section">
                <h3>Addresses</h3>
                <?php if ($address_count == 0): ?>
                    <p>No addresses added.</p>
                    <a href="user-add-address.php" class="add-address-link">+ Add Address</a>
                <?php elseif ($address_count >= $max_addresses): ?>
                    <p>You can only have 3 addresses saved.</p>
                <?php else: ?>
                    <?php while ($address = mysqli_fetch_assoc($address_result)): ?>
                        <div class="address-container">
                            <div class="address-item">
                                <strong>Name:</strong> <?php echo $address['add_fName'] . " " . $address['add_sName']; ?>
                            </div>
                            <div class="address-item">
                                <strong>Phone:</strong> <?php echo $address['add_phone']; ?>
                            </div>
                            <div class="address-item">
                                <strong>Street Address:</strong> <?php echo $address['add_street_addr']; ?>
                            </div>
                            <div class="address-item">
                                <strong>Postal Code:</strong> <?php echo $address['add_postal_code']; ?>
                            </div>
                            <div class="address-item">
                                <strong>Barangay:</strong> <?php echo $address['add_barangay']; ?>
                            </div>
                            <div class="address-item">
                                <strong>City:</strong> <?php echo $address['add_city']; ?>
                            </div>
                            <div class="address-item">
                                <strong>Province:</strong> <?php echo $address['add_province']; ?>
                            </div>
                            <div class="address-item">
                                <strong>Region:</strong> <?php echo $address['add_region']; ?>
                            </div>
                            <a href="user-edit-address.php?id=<?php echo $address['add_id']; ?>" class="edit-link">Edit</a>
                        </div>
                    <?php endwhile; ?>
                    <a href="user-add-address.php" class="add-address-link">+ Add Another Address</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Modal for Editing Name -->
    <div id="editNameModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeNameModal">&times;</span>
            <h2>Edit Name</h2>
            <form action="user-edit-name.php" method="POST">
                <label for="fName">First Name:</label>
                <input type="text" id="fName" name="fName" value="<?php echo htmlspecialchars($user['usact_fName']); ?>" required>
                <br><br>

                <label for="mName">Middle Name (Optional):</label>
                <input type="text" id="mName" name="mName" value="<?php echo htmlspecialchars($user['usact_mName']); ?>">
                <br><br>

                <label for="sName">Surname:</label>
                <input type="text" id="sName" name="sName" value="<?php echo htmlspecialchars($user['usact_sName']); ?>" required>
                <br><br>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </div>
    </div>
    
    <!-- Modal for Editing Email -->
    <div id="editEmailModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEmailModal">&times;</span>
            <h2>Edit Email</h2>
            <form action="user-edit-email.php" method="POST">
                <label for="email">New Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user['usact_email']; ?>" required>
                <br><br>
                <button type="submit" class="btn-save">Save</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>

    <script>
        // Open modal for editing name
        document.getElementById('editNameBtn').onclick = function() {
            document.getElementById('editNameModal').style.display = "block";
        }

        // Close modal for editing name
        document.getElementById('closeNameModal').onclick = function() {
            document.getElementById('editNameModal').style.display = "none";
        }

        // Open modal for editing email
        document.getElementById('editEmailBtn').onclick = function() {
            document.getElementById('editEmailModal').style.display = "block";
        }

        // Close modal for editing email
        document.getElementById('closeEmailModal').onclick = function() {
            document.getElementById('editEmailModal').style.display = "none";
        }
    </script>

</body>
</html>
