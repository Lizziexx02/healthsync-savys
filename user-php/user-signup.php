<?php
include('config.php');

$fname = $mname = $sname = $username = $email = $password = $confirm_password = "";
$fname_err = $sname_err = $username_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $sname = mysqli_real_escape_string($conn, $_POST['sname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);
    
    if ($password !== $confirm_password) {
        $confirm_password_err = "Passwords do not match!";
    }

    $password_pattern = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/';
    if (!preg_match($password_pattern, $password)) {
        $password_err = "Password must be at least 8 characters long and contain at least one letter and one number.";
    }

    $email_check_query = "SELECT * FROM tbl_user_account WHERE usact_email='$email' LIMIT 1";
    $result = mysqli_query($conn, $email_check_query);
    $user = mysqli_fetch_assoc($result);
    
    if ($user) {
        $email_err = "Email already exists!";
    }

    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO tbl_user_account (usact_fname, usact_mname, usact_sname, usact_username, usact_email, usact_password) 
                VALUES ('$fname', '$mname', '$sname', '$username', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            header('Location: index.php'); 
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - HealthSync</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="user-styles-1.css">
</head>
<body>
    <br>
    <section class="signup-section">
        <div class="signup-container">
            <div class="healthsync-logo1">
                <img src="images/Logos/logo1.png" alt="HealthSync Logo" class="logo-img">
            </div>

            <h2>Create Account</h2>

            <form action="user-signup.php" method="POST">
                <div class="input-group">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" placeholder="First Name" value="<?php echo $fname; ?>" required>
                    <span class="error"><?php echo $fname_err; ?></span>
                </div>

                <div class="input-group">
                    <label for="mname">Middle Name (Optional)</label>
                    <input type="text" id="mname" name="mname" placeholder="Middle Name" value="<?php echo $mname; ?>">
                </div>

                <div class="input-group">
                    <label for="sname">Surname</label>
                    <input type="text" id="sname" name="sname" placeholder="Surname" value="<?php echo $sname; ?>" required>
                    <span class="error"><?php echo $sname_err; ?></span>
                </div>

                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
                    <span class="error"><?php echo $username_err; ?></span>
                </div>

                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email Address" value="<?php echo $email; ?>" required>
                    <span class="error"><?php echo $email_err; ?></span>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create Password" required>
                    <span class="error"><?php echo $password_err; ?></span>
                </div>

                <div class="input-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Repeat Password" required>
                    <span class="error"><?php echo $confirm_password_err; ?></span>
                </div>

                <button type="submit" class="btn-signup">Sign Up</button>
            </form>
            <p class="login-link">Already have an account? <a href="user-login.php">Login</a></p>
        </div>
    </section>
    <br>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>
</body>
</html>