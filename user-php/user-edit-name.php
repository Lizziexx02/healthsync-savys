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
    $new_name = mysqli_real_escape_string($conn, $_POST['name']);

    // Update the user's name in the database
    $update_name_query = "UPDATE tbl_user_account SET usact_fName = '$new_name' WHERE usact_id = '$user_id'";

    if (mysqli_query($conn, $update_name_query)) {
        // Redirect to the profile page after updating
        header('Location: user-my-account.php');
        exit();
    } else {
        echo "Error updating name: " . mysqli_error($conn);
    }
}

// Fetch user details for pre-filling the form
$query_user = "SELECT usact_fName FROM tbl_user_account WHERE usact_id = '$user_id'";
$result_user = mysqli_query($conn, $query_user);
$user = mysqli_fetch_assoc($result_user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Name - HealthSync</title>
    <link rel="stylesheet" href="user-styles-3.css">
</head>
<body>

    <header>
        <div class="healthsync-logo">
            <img src="images/Logos/logo3.png" alt="HealthSync Logo" class="logo-img">
        </div>
    </header>

    <section class="edit-name-section">
        <div class="form-container">
            <h2>Edit Your Name</h2>
            <form action="user-edit-name.php" method="POST">
                <label for="name">New Name:</label>
                <input type="text" name="name" value="<?php echo $user['usact_fName']; ?>" required>
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
