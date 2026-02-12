<?php
include('config.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

$admin_id = $_SESSION['admin_id'];

$sql = "SELECT * FROM tbl_admin WHERE admin_id = '$admin_id'";
$result = mysqli_query($conn, $sql);
$admin = mysqli_fetch_assoc($result);

$full_name = $admin['admin_fName'] . ($admin['admin_mName'] ? " " . $admin['admin_mName'] : "") . " " . $admin['admin_sName'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin-styles-2.css">
</head>
<body>

    <header>
        <div class="healthsync-logo">
            <img src="images/Logos/logo3.png" alt="HealthSync Logo" class="logo-img">
        </div>
        <nav>
            <ul>
                <li><a href="admin-dashboard.php" class="nav-item">Dashboard</a></li>
                <li><a href="admin-products.php" class="nav-item">Manage Products</a></li>
                <li><a href="admin-orders.php" class="nav-item">Manage Orders</a></li>
                <li><a href="admin-users.php" class="nav-item">Manage Users</a></li>
                <li><a href="admin-my-account.php" class="nav-item active">My Account</a></li>
                <li><a href="logout.php" class="nav-item">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <section class="account-section">
        <div class="admin-grid-container">
            
            <div class="admin-card">
                <h3>Personal Info</h3>
                <div class="admin-info-row">
                    <span class="label">Full Name:</span>
                    <span class="value"><?php echo htmlspecialchars($full_name); ?></span>
                    <button id="editNameBtn" class="inline-edit">Edit</button>
                </div>
                <div class="admin-info-row">
                    <span class="label">Email Address:</span>
                    <span class="value"><?php echo htmlspecialchars($admin['admin_email']); ?></span>
                    <button id="editEmailBtn" class="inline-edit">Edit</button>
                </div>
                <div class="admin-info-row">
                    <span class="label">Password:</span>
                    <span class="value">●●●●●●●●</span>
                    <button id="editPassBtn" class="inline-edit-pass">Change Password</button>
                </div>
            </div>

            <div class="admin-card">
                <h3>Account Roles</h3>
                <div class="admin-info-row">
                    <span class="label">Role:</span>
                    <span class="value">System Administrator</span>
                </div>
                <div class="admin-info-row">
                    <span class="label">Admin ID:</span>
                    <span class="value">#<?php echo $admin['admin_id']; ?></span>
                </div>
                <div class="admin-info-row">
                    <span class="label">Last Login:</span>
                    <span class="value"><?php echo date("F d, Y"); ?></span>
                </div>
            </div>

        </div>
    </section>

    <!-- Modal for Editing Name -->
    <div id="editNameModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeNameModal">&times;</span>
            <h2>Edit Name</h2>
            <form action="admin-edit-name.php" method="POST">
                <div class="input-group">
                    <label>First Name:</label>
                    <input type="text" name="fname" value="<?php echo htmlspecialchars($admin['admin_fName']); ?>" required>
                </div>
                <br>
                
                <div class="input-group">
                    <label>Middle Name (Optional):</label>
                    <input type="text" name="mname" value="<?php echo htmlspecialchars($admin['admin_mName']); ?>">
                </div>
                <br>
                
                <div class="input-group">
                    <label>Surname:</label>
                    <input type="text" name="sname" value="<?php echo htmlspecialchars($admin['admin_sName']); ?>" required>
                </div>
                <br>
                
                <button type="submit" class="btn-save">Update Profile</button>
            </form>
        </div>
    </div>

    <!-- Modal for Editing Email -->
    <div id="editEmailModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEmailModal">&times;</span>
            <h2>Edit Email</h2>
            <form action="admin-edit-email.php" method="POST">
                <div class="input-group">
                    <label>New Email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($admin['admin_email']); ?>" required>
                </div>
                <br>
                <button type="submit" class="btn-save">Update Email</button>
            </form>
        </div>
    </div>

    <!-- Modal for Changing Password -->
    <div id="editPassModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closePassModal">&times;</span>
            <h2>Change Password</h2>
            <form action="admin-edit-password.php" method="POST">
                <div class="input-group">
                    <label>Current Password:</label>
                    <input type="password" name="current_password" required>
                </div>
                <br>
                
                <div class="input-group">
                    <label>New Password:</label>
                    <input type="password" name="new_password" required>
                </div>
                <br>
                
                <div class="input-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" name="confirm_password" required>
                </div>
                <br>
                <button type="submit" class="btn-save">Change Password</button>
            </form>
        </div>
    </div>

    <script>
        const nameModal = document.getElementById("editNameModal");
        const emailModal = document.getElementById("editEmailModal");
        const passModal = document.getElementById("editPassModal");

        document.getElementById("editNameBtn").onclick = function() {
            nameModal.style.display = "block";
        }

        document.getElementById("editEmailBtn").onclick = function() {
            emailModal.style.display = "block";
        }

        document.getElementById("editPassBtn").onclick = function() {
            passModal.style.display = "block";
        }

        document.getElementById("closeNameModal").onclick = function() {
            nameModal.style.display = "none";
        }

        document.getElementById("closeEmailModal").onclick = function() {
            emailModal.style.display = "none";
        }

        document.getElementById("closePassModal").onclick = function() {
            passModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == nameModal) {
                nameModal.style.display = "none";
            }
            if (event.target == emailModal) {
                emailModal.style.display = "none";
            }
            if (event.target == passModal) {
                passModal.style.display = "none";
            }
        }
    </script>

</body>
</html>
