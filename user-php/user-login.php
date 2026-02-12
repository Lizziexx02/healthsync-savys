<?php
include('config.php');
session_start();

$email = $password = "";
$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Updated query for tbl_user_account
    $sql = "SELECT * FROM tbl_user_account WHERE usact_email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['usact_password'])) {
        // Set Sessions
        $_SESSION['user_id'] = $user['usact_id'];
        
        // Combine names for the session display
        $full_name = $user['usact_fname'] . " " . $user['usact_sname'];
        $_SESSION['user_name'] = $full_name;

        header('Location: index.php');
        exit();
    } else {
        $login_error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HealthSync</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="user-styles-1.css">
</head>
<body>

    <section class="login-section">
        <div class="login-container">
            <div class="healthsync-logo1">
                <img src="images/Logos/logo1.png" alt="HealthSync Logo" class="logo-img">
            </div>

            <h2>Login</h2>

            <?php if($login_error): ?>
                <p style="color: #FF8FAB; text-align: center; font-weight: 600;"><?php echo $login_error; ?></p>
            <?php endif; ?>

            <form action="user-login.php" method="POST">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn-login">Login</button>
            </form>
            <p class="signup-link">Don't have an account? <a href="user-signup.php">Sign Up</a></p>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>
</body>
</html>