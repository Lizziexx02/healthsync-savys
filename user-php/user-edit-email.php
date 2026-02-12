<?php
include('config.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: user-login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_email = mysqli_real_escape_string($conn, $_POST['email']);

    // Update the user's email in the database
    $update_email_query = "UPDATE tbl_user_account SET usact_email = '$new_email' WHERE usact_id = '$user_id'";

    if (mysqli_query($conn, $update_email_query)) {
        // Redirect to the profile page after updating
        header('Location: user-my-account.php');
        exit();
    } else {
        echo "Error updating email: " . mysqli_error($conn);
    }
}

// Fetch user details for pre-filling the form
$query_user = "SELECT usact_email FROM tbl_user_account WHERE usact_id = '$user_id'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Email - HealthSync</title>
    <link rel="stylesheet" href="user-styles-3.css">
</head>
<body>

    <header>
        <div class="healthsync-logo">
            <img src="images/Logos/logo3.png" alt="HealthSync Logo" class="logo-img">
        </div>
    </header>

    <section class="edit-email-section">
        <div class="form-container">
            <h2>Edit Your Email</h2>
            <form action="user-edit-email.php" method="POST">
                <label for="email">New Email:</label>
                <input type="email" name="email" value="<?php echo $user['usact_email']; ?>" required>
                <br><br>
                <button type="submit" class="btn-save">Save</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2026 HealthSync. All rights reserved.</p>
    </footer>

</body>
</html>
