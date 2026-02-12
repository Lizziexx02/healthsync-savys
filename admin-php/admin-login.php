<?php
include('config.php');
session_start();

$email = $password = "";
$email_err = $password_err = "";
$login_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Updated to match tbl_admin columns explicitly
    $sql = "SELECT * FROM tbl_admin WHERE admin_email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $admin = mysqli_fetch_assoc($result);

    // Verify password (plain text as per your previous code, though schema mentions hashing)
    if ($admin && $password == $admin['admin_password']) {
        $_SESSION['admin_id'] = $admin['admin_id'];
        $_SESSION['admin_name'] = $admin['admin_name'];

        header('Location: admin-dashboard.php');
        exit();
    } else {
        $login_err = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - HealthSync</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin-styles.css">
</head>
<body>
    <section class="admin-login-section">
        <div class="login-container">
            <div class="healthsync-logo1">
                <img src="images/Logos/logo1.png" alt="HealthSync Logo" class="logo-img">
            </div>

            <h2>Admin Login</h2>

            <form action="admin-login.php" method="POST">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter admin email" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter admin password" required>
                    <span class="error"><?php echo $login_err; ?></span>
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>
</body>
</html>